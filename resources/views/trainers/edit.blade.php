@extends('layouts.app')
@section('title', 'Editar Trainer')

@section('content')
    <form class="form-group" method="POST" action="{{ route('trainers.update', $trainer->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="{{ $trainer->name }}" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" value="{{ $trainer->apellido }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="avatar">Avatar:</label>
            <input type="file" name="avatar" class="form-control" value="{{ $trainer->avatar }}">
        </div>

        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
@endsection