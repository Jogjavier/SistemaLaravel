@extends('layouts.app')
@section('title', 'Crear Trainer')
@section('page-title', 'Nuevo Trainer')

@section('content')
    <form class="form-group" method="POST" action="/trainers" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="avatar">Avatar:</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection