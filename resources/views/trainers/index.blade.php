@extends('layouts.app')
@section('title', 'Trainers')
@section('content')
@csrf
    <p>Listado de trainers</p>

<div class = "row">
    @foreach ($trainers as $trainer)
    <div class="col-sm">
        <div class="card text-center" style="width: 18rem; margin-top: 70px;">
           <img 
                class="card-img-top rounded-circle mx-auto d-block" 
                style="height: 100px; width: 100px; background-color: #EFEFEF; margin: 20px;"
                src="{{ asset('images/' . $trainer->avatar) }}" 
                alt="{{ $trainer->name }}">
            <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $trainer->name }}</h5>
                    <p class="card-text text-muted flex-grow-1">
                        {{ $trainer->apellido ?? 'Información del trainer' }}
                    </p>
                    
                    <!-- Botones -->
                    <div class="mt-auto">
                        <a href="{{ route('trainers.show', $trainer->slug) }}" 
                           class="btn btn-primary btn-sm w-100 mb-2">
                            Ver más
                        </a>
                        
                        <!-- Botón Eliminación Lógica -->
                        <form action="{{ route('trainers.destroy', $trainer->slug) }}" 
                              method="POST" 
                              class="d-inline w-100 mb-2"
                              onsubmit="return confirm('¿Mover {{ $trainer->name }} a la papelera?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning btn-sm w-100">
                                <i class="bi bi-trash"></i> Borrar temporalmente
                            </button>
                        </form>
                        
                        <!-- Botón Eliminación Física -->
                        <form action="{{ route('trainers.force-destroy', $trainer->_id) }}" 
                              method="POST" 
                              class="d-inline w-100"
                              onsubmit="return confirm('⚠️ ELIMINAR PERMANENTEMENTE a {{ $trainer->name }}?\n\nEsta acción NO se puede deshacer y eliminará también su imagen.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-trash-fill"></i> Eliminar
                            </button>
                        </form>
                    </div>
</div>
    </div>
    @endforeach
</div>
@endsection