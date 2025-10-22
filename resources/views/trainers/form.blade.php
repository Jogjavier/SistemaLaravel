<div class="form-group mb-3"> 
    {{ Form::label('name', 'Nombre:') }}
    {{ Form::text('name', $trainer->name ?? null, ['class' => 'form-control']) }}
</div>

<div class="form-group mb-3">
    {{ Form::label('apellido', 'Apellido:') }}
    {{ Form::text('apellido', $trainer->apellido ?? null, ['class' => 'form-control']) }}
</div>

<div class="form-group mb-3">
    {{ Form::label('avatar', 'Avatar:') }}
    {{ Form::file('avatar', ['class' => 'form-control']) }}
</div>
