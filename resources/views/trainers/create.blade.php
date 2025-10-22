@extends('layouts.app')
@section('title', 'Crear Trainer')
@section('page-title', 'Nuevo Trainer')

@section('content')
    {!! Form::open(['route' => 'trainers.store', 'method' => 'POST', 'files' => true]) !!}
        @include('trainers.form')
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
