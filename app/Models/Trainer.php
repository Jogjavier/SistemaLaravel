<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'trainers';

    protected $fillable = [
        'name',
        'apellido',
        'avatar',
        'slug'
    ];

    protected $appends = ['avatar_url'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Accesor para la URL completa de la imagen
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
        // Verificar public primero
        $publicPath = public_path('images/' . $this->avatar);
        if (file_exists($publicPath)) {
            return asset('images/' . $this->avatar);
        }
        
        // Verificar storage
        $storagePath = storage_path('app/public/images/' . $this->avatar);
        if (file_exists($storagePath)) {
            return asset('storage/images/' . $this->avatar);
        }
    }
    
    // Si no hay imagen o no existe, retornar NULL
    return null;
    }

    // Boot method para generar slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trainer) {
            $trainer->slug = Str::slug($trainer->name . ' ' . $trainer->apellido);
            
            // Si el slug ya existe, agregar un número único
            $originalSlug = $trainer->slug;
            $count = 1;
            while (static::where('slug', $trainer->slug)->withTrashed()->exists()) {
                $trainer->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });

        static::updating(function ($trainer) {
            if ($trainer->isDirty(['name', 'apellido'])) {
                $trainer->slug = Str::slug($trainer->name . ' ' . $trainer->apellido);
                
                // Si el slug ya existe (excluyendo el actual), agregar un número único
                $originalSlug = $trainer->slug;
                $count = 1;
                while (static::where('slug', $trainer->slug)
                            ->where('_id', '!=', $trainer->id)
                            ->withTrashed()
                            ->exists()) {
                    $trainer->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    // Scope para trainers activos (no eliminados) - CORREGIDO
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    // Scope para trainers eliminados - CORREGIDO
    public function scopeOnlyTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    // MongoDB usa _id en lugar de id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Método para restaurar
    public function restoreTrainer()
    {
        return $this->restore();
    }

    // Método para eliminar permanentemente
    public function forceDeleteTrainer()
    {
        if ($this->avatar) {
            \Illuminate\Support\Facades\Storage::delete('public/images/' . $this->avatar);
        }
        return $this->forceDelete();
    }
}