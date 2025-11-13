@extends('layouts.app')
@section('title', 'Detalles del Trainer')

@section('content')
<div class="row justify-content-center">
    {{-- Botón de PDF Individual --}}
    <div class="d-flex gap-2">
        <a href="{{ route('trainers.pdf', $trainer->_id) }}" class="btn btn-info btn-sm w-20">
            <i class="bi bi-box-arrow-right"></i> Descargar PDF de detalles del Trainer
        </a>
    </div>
    <div class="col-sm-6">
        <div class="card text-center" style="width: 18rem; margin-top: 70px;">
            <img 
                class="card-img-top rounded-circle mx-auto d-block" 
                style="height: 100px; width: 100px; background-color: #EFEFEF; margin: 20px;"
                src="{{ asset('images/' . $trainer->avatar) }}" 
                alt="{{ $trainer->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $trainer->name }}</h5>
                <p class="card-text text-muted">
                    {{ $trainer->apellido ?? 'Some quick example text to build on the card title and make up the bulk of the card\'s content.' }}
                </p>

                <div class="mt-3">
                    <form action="{{ route('trainers.destroy', $trainer) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary" onclick="return confirm('¿Estás seguro de eliminar este trainer?')">Delete</button>
                    </form>
                    <a href="{{ route('trainers.edit', $trainer) }}" class="btn btn-secondary">Editar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection