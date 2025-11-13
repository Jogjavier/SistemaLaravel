<nav class="navbar navbar-expand-lg bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="{{ route('trainers.index') }}">
            <i class="material-icons align-middle">fitness_center</i>
            App Shop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('trainers.index') }}">
                            <i class="material-icons align-middle">list</i> Trainers
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white">
                                <i class="material-icons align-middle">logout</i> Salir
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>