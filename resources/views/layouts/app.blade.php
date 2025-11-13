<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'App Shop')</title>

    {{-- Material Kit CSS --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://demos.creative-tim.com/material-kit/assets/css/material-kit.min.css?v=3.0.4" rel="stylesheet" />
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    {{-- Estilos personalizados --}}
    <style>
        .gap-2 {
            gap: 0.5rem !important;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Mensajes Flash --}}
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="material-icons">check_circle</i></span>
                <span class="alert-text"><strong>Éxito!</strong> {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="material-icons">error</i></span>
                <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>

    {{-- Contenido Principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Material Kit JS --}}
    <script src="https://demos.creative-tim.com/material-kit/assets/js/core/popper.min.js"></script>
    <script src="https://demos.creative-tim.com/material-kit/assets/js/core/bootstrap.min.js"></script>
    <script src="https://demos.creative-tim.com/material-kit/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="https://demos.creative-tim.com/material-kit/assets/js/material-kit.min.js?v=3.0.4"></script>
    
    {{-- Scripts personalizados --}}
    @stack('scripts')
</body>
</html>