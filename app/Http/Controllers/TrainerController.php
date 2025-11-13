<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\ObjectId;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainerController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->has('search') && !empty($request->search)) {
            try {
                // Intentar búsqueda con Scout/Meilisearch
                $trainers = Trainer::search($request->search)
                    ->query(fn($query) => $query->whereNull('deleted_at'))
                    ->get();
            } catch (\Exception $e) {
                // Fallback: búsqueda manual si Meilisearch falla
                $searchTerm = $request->search;
                $trainers = Trainer::where(function($query) use ($searchTerm) {
                        $query->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('apellido', 'like', "%{$searchTerm}%");
                    })
                    ->whereNull('deleted_at')
                    ->get();
            }
        } else {
            $trainers = Trainer::active()->get();
        }
        
        $trashedCount = Trainer::onlyTrashed()->count();
        
        return view('trainers.index', compact('trainers', 'trashedCount'));
    }

    // Mostrar trainers eliminados - CORREGIDO
    public function trashed()
    {
        $trainers = Trainer::onlyTrashed()->get();
        return view('trainers.trashed', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $trainer = new Trainer();
        $trainer->name = $request->input('name');
        $trainer->apellido = $request->input('apellido');

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            
            $destinationPath = public_path('images');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $trainer->avatar = $filename;
        }

        $trainer->save();
        return redirect()->route('trainers.index')->with('success', 'Trainer creado exitosamente');
    }

    public function show($id)
    {
        $trainer = Trainer::find($id);

        return view('trainers.show', compact('trainer'));
    }

    public function edit($id)
    {
        $trainer = Trainer::where('slug', $id)->firstOrFail();
        //return $trainer;
        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request, $id)
    {
        $trainer = Trainer::where('slug', $id)->firstOrFail();
        //return $trainer;
        //return $request;
        $trainer->fill($request->except('_avatar'));
        
        if ($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name=time().'_'.$file->getClientOriginalName();

            $trainer->avatar=$name;
            $file->move(public_path().'/images/',$name);
        }
        $trainer->save();
            return redirect('trainers/'.$trainer->id);
    }

    // Eliminación lógica
    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return redirect()->route('trainers.index')
                    ->with('success', 'Trainer movido a la papelera!');
    }

    // Restaurar trainer - CORREGIDO para MongoDB
    /**
    public function restore($id)
    {
        try {
            // Para MongoDB, podemos usar find() con el string ID directamente
            $trainer = Trainer::onlyTrashed()->find($id);
            
            if (!$trainer) {
                return redirect()->route('trainers.trashed')
                                ->with('error', 'Trainer no encontrado en la papelera.');
            }

            $trainer->restore();

            return redirect()->route('trainers.trashed')
                            ->with('success', 'Trainer restaurado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('trainers.trashed')
                            ->with('error', 'Error al restaurar trainer: ' . $e->getMessage());
        }
    }*/

    // Eliminación permanente
    public function forceDestroy($id)
    {
            $trainer = Trainer::withTrashed()->findOrFail($id);
        
        
        if ($trainer->avatar) {
            $imagePath = public_path('images/' . $trainer->avatar);
            
            if (file_exists($imagePath)) {
                @unlink($imagePath); // @ suprime errores de permisos
            }
        }
        
        // Eliminación permanente
        $trainer->forceDelete();

        return redirect()->route('trainers.index')
                    ->with('success', 'Trainer y su imagen eliminados permanentemente!');
    }

    // Vaciar papelera - CORREGIDO
    public function emptyTrash()
    {
        try {
            $trashedTrainers = Trainer::onlyTrashed()->get();
            
            foreach ($trashedTrainers as $trainer) {
                $trainer->forceDeleteTrainer();
            }

            return redirect()->route('trainers.trashed')
                            ->with('success', 'Papelera vaciada exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('trainers.trashed')
                            ->with('error', 'Error al vaciar papelera: ' . $e->getMessage());
        }
    }

    public function downloadPdf(string $id = null)
    {
        // Si se proporciona un ID, generamos la ficha individual
        if ($id) {
            
            $trainer = Trainer::findOrFail($id);
            
            $pdf = Pdf::loadView('trainers.pdf', compact('trainer'));
           
            return $pdf->download("ficha-trainer-{$trainer->name}-{$trainer->apellido}.pdf");

        } 
        
        else {
            
            $trainers = Trainer::all(); // Obtener todos los documentos de la colección

            $pdf = Pdf::loadView('trainers.pdf', compact('trainers'));

            $pdf->setPaper('a4', 'portrait');

            return $pdf->download('listado-completo-trainers.pdf');
        }
    }
}