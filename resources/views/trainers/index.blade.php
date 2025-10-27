@extends('layouts.app')
@section('title', 'Trainers')

@section('content')
@csrf

<div class="container mt-4">

    {{-- Encabezado con botón de Logout y botón de Descargar Listado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0">Listado de Trainers</h3>
        
        <div class="d-flex gap-2">
            {{-- NUEVO BOTÓN PARA DESCARGAR EL PDF COMPLETO --}}
            <a href="{{ route('trainers.all.pdf') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Descargar Listado PDF
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($trainers as $trainer)
            <div class="col">
                <div class="card text-center shadow-sm h-100">
                    <img 
                        class="card-img-top rounded-circle mx-auto mt-3" 
                        style="height: 100px; width: 100px; object-fit: cover; background-color: #EFEFEF;"
                        src="{{ asset('images/' . $trainer->avatar) }}" 
                        alt="{{ $trainer->name }}"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $trainer->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">
                            {{ $trainer->apellido ?? 'Sin apellido registrado.' }}
                        </p>

                        <div class="mt-auto d-flex flex-column gap-2">
                            <a href="{{ route('trainers.show', $trainer->id) }}" class="btn btn-secondary w-100">
                                Ver más...
                            </a>

                            <form action="{{ route('trainers.destroy', $trainer->slug) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('¿Mover {{ $trainer->name }} a la papelera?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-trash"></i> Borrar temporalmente
                                </button>
                            </form>

                            <form action="{{ route('trainers.force-destroy', $trainer->_id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('ELIMINAR PERMANENTEMENTE a {{ $trainer->name }}?\n\nEsta acción NO se puede deshacer y eliminará también su imagen.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection