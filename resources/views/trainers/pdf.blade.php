<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>
        @if (isset($trainers))
            Listado Completo de Trainers
        @else
            Ficha de Trainer: {{ $trainer->name }}
        @endif
    </title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #004d99;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #004d99;
            margin: 0;
            font-size: 28px;
        }
        .info {
            font-size: 12px;
            text-align: right;
            margin-bottom: 15px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #e6f2ff;
            color: #004d99;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .trainer-name {
            font-weight: bold;
        }
        /* Estilos para AVATAR en la tabla (Listado) */
        .avatar-cell {
            text-align: center;
            padding: 5px;
        }
        .avatar-img {
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            object-fit: cover;
            border: 1px solid #ccc;
        }
        /* Estilos para Ficha Individual */
        .card-detail {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
        }
        .card-detail h2 {
            text-align: center;
            color: #004d99;
            margin-top: 0;
        }
        .detail-avatar {
            display: block;
            margin: 0 auto 20px auto;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #004d99;
        }
        .detail-row {
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }
        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>

    {{-- LÓGICA CONDICIONAL: Si existe $trainers (plural), muestra el listado completo --}}
    @if (isset($trainers))

        <div class="header">
            <h1>Listado Completo de Trainers Registrados</h1>
        </div>

        <div class="info">
            Total de Trainers: {{ count($trainers) }} | Generado el: {{ date('d/m/Y H:i:s') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Avatar</th> 
                    <th>Nombre Completo</th>
                    <th>ID MongoDB</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainers as $index => $trainer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="avatar-cell">
                        @if ($trainer->avatar)
                            <img 
                                src="{{ public_path('images/' . $trainer->avatar) }}" 
                                alt="{{ $trainer->name }}"
                                class="avatar-img"
                            >
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="trainer-name">{{ $trainer->name }} {{ $trainer->apellido ?? '' }}</td>
                    <td>{{ $trainer->_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{-- Si no existe $trainers, asumimos que existe $trainer (singular) para la ficha individual --}}
    @elseif (isset($trainer))

        <div class="header">
            <h1>Ficha Detallada del Trainer</h1>
        </div>
        
        <div class="card-detail">
            <h2>{{ $trainer->name }} {{ $trainer->apellido ?? '' }}</h2>
            
            @if ($trainer->avatar)
                <img 
                    src="{{ public_path('images/' . $trainer->avatar) }}" 
                    alt="Avatar de {{ $trainer->name }}"
                    class="detail-avatar"
                >
            @endif

            <div class="detail-row">
                <span class="detail-label">ID MongoDB:</span> {{ $trainer->_id }}
            </div>


            <div class="info" style="text-align: center; margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
                Generado el: {{ date('d/m/Y H:i:s') }}
            </div>

        </div>
    
    @else
        <div class="header">
            <h1>Error: No se encontró información del Trainer o Listado.</h1>
        </div>
    @endif

</body>
</html>
