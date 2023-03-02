<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('img/icono.png')}}">
    <title>Mi sistema de gestión de contenido</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/estilos_admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fontawesome-all.css')}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        a {
            color: #3e3f3a;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            color: #769e3c;
        }

        .progress {
            --bs-progress-height: 1rem;
            --bs-progress-font-size: 0.75rem;
            --bs-progress-bg: #dfd7ca;
            --bs-progress-border-radius: 10px;
            --bs-progress-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
            --bs-progress-bar-color: #325d88;
            --bs-progress-bar-bg: #325d88;
            --bs-progress-bar-transition: width 0.6s ease;
            display: flex;
            height: var(--bs-progress-height);
            overflow: hidden;
            font-size: var(--bs-progress-font-size);
            background-color: var(--bs-progress-bg);
            border-radius: var(--bs-progress-border-radius);
        }
    </style>
    @stack('css')
</head>

<body style="background-color: #FFFFFF;">
    <div>
        <div class="header bg-light_ py-3 _bg-transparent">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <img src="{{asset('img/logos_izq.gif')}}" width="300" height="70" alt="SISTEMA DE SUSCRIPCIÓN">
                    </div>
                </div>
                <!--/row-->
            </div>
            <!--container-->
        </div>
        <nav class="navbar navbar-dark bg-dark navbar-expand-sm sticky-top navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    SISTEMA DE SUSCRIPCIÓN
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth                    
                        @if(auth()->user()->role_id === 1)                  
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <strong>Registrar</strong>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('publications.create')}}">
                                        Publicación
                                    </a>

                                    <a class="dropdown-item" href="{{route('sign-documents.create')}}">
                                        Archivo a Certificar
                                    </a>
                                </div>
                            </li>
                        </ul>
                        @endif
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Registrarse</a>
                        </li>
                        @endif
                       
                        @else
                        @if (!optional(auth()->user())->hasActiveSubscription() && auth()->user()->role_id === 2)
                        <li class="nav-item">
                            <a class="btn btn-outline-warning" href="{{route('subscribe.show')}}">Suscribirse</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <span class="fas fa-power-off" aria-hidden="true"></span> Salir
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content py-5">
            @yield('content')
        </main>

        <footer class="text-center text-white mt-4" style="background-color: rgba(0, 0, 0, 0.2);">
            <div class="container py-3">
                <section class="mb-4">
                    <a class="btn btn-link btn-floating btn-lg text-dark m-1 text-iconos" href="#!" role="button" data-mdb-ripple-color="dark">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="btn btn-link btn-floating btn-lg text-dark m-1 text-iconos" href="#!" role="button" data-mdb-ripple-color="dark">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a class="btn btn-link btn-floating btn-lg text-dark m-1 text-iconos" href="#!" role="button" data-mdb-ripple-color="dark">
                        <i class="fab fa-instagram"></i>
                    </a>
                </section>
            </div>
        </footer>

        <!-- Footer -->
        <footer class="text-center text-lg-start bg-dark text-muted mt-2">
            <section class="pt-5">
                <div class="container text-center text-md-start mt-5">
                    <div class="row mt-3">
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4 d-flex flex-column justify-content-center">
                            <h6 class=" fw-bold mb-2 h5 text-center">
                                Gobierno del Estado de Oaxaca
                            </h6>
                            <p>
                                <img src="{{asset('img/oax-escudo.png')}}" height="90" class="rounded mx-auto d-block w-imagen" alt="...">
                            </p>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">
                                Acceso rapido
                            </h6>
                            <p><i class="fas fa-home me-3 text-secondary"></i> Inicio</p>
                        </div>
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">Contactos</h6>
                            <p>
                                <i class="fas fa-envelope me-3 text-secondary"></i>
                                contacto@oaxaca.gob.com.mx
                            </p>
                            <p>
                                <i class="fas fa-envelope me-3 text-secondary"></i>
                                oaxacaoficial@hotmail.com
                            </p>
                            <p><i class="fas fa-phone me-3 text-secondary"></i> 558 - 234 - 1212</p>
                        </div>
                    </div>
                </div>
            </section>
            <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
                © Portal de Gobierno del Estado de Oaxaca 2022
            </div>
        </footer>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/fontawesome-all.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('scripts')   
</body>

</html>