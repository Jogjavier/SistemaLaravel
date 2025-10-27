<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Completo de Trainers</title>
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
        /* Estilo para la columna del avatar */
        .avatar-cell {
            text-align: center;
            padding: 5px;
        }
        .avatar-img {
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            object-fit: cover;
            /* Añadir un borde sutil para destacar la imagen */
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

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
                {{-- NUEVA COLUMNA DE AVATAR --}}
                <th>Avatar</th> 
                <th>Nombre Completo</th>
                <th>ID MongoDB</th>
                <th>Descripción (Primeras 50 chars)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainers as $index => $trainer)
            <tr>
                <td>{{ $index + 1 }}</td>
                {{-- CELDA DEL AVATAR --}}
                <td class="avatar-cell">
                    @if ($trainer->avatar)
                        {{-- CRUCIAL: Usar public_path() para la ruta absoluta, necesario para Dompdf --}}
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
                <td>
                    @if (!empty($trainer->description))
                        {{ Str::limit(strip_tags($trainer->description), 50, '...') }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
