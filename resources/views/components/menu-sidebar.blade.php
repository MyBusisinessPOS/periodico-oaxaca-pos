<div class="card">
    <div class="card-header">
        <a href="#">
            <span class="fas fa-cog" aria-hidden="true"></span> Panel de Control
        </a>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item" >
            <a href="{{route('home')}}" class="active color-principal">
                <span class="fas fa-store-alt" aria-hidden="true"></span> Inicio
            </a>
        </li>
        @if (auth()->user()->role_id == 1)
        <li class="list-group-item">
            <a href="{{route('publications.index')}}">
                <span class="fas fa-images" aria-hidden="true"></span> Archivos publicados
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{route('sign-documents.index')}}">
                <span class="fas fa-images" aria-hidden="true"></span> Archivos certificados
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{route('orders.index')}}">
                <img src="{{asset('img/fontawesome/shopping-cart-solid.svg')}}" height="16" alt=""> Ordenes
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{route('admin-subscriptions.index')}}">
                <img src="{{asset('img/fontawesome/user-tie-solid.svg')}}" height="16" alt=""> Suscripciones
            </a>
        </li>
        @else 
        @if (!optional(auth()->user())->hasActiveSubscription())
        <li class="list-group-item">
            <a href="{{route('subscribe.show')}}">
                <img src="{{asset('img/fontawesome/laptop-file-solid.svg')}}" height="16" alt=""> Elíja un plan
            </a>
        </li>
        @endif
        <li class="list-group-item">
            <a href="{{route('orders.index')}}">
                <img src="{{asset('img/fontawesome/shopping-cart-solid.svg')}}" height="16" alt=""> Ordenes
            </a>
        </li>
        <li class="list-group-item">
            <a href="{{route('calendars.index')}}">
                <img src="{{asset('img/fontawesome/calendar-alt-solid.svg')}}" height="16" alt=""> Periodico Calendario
            </a>
        </li>
        @endif
    </ul>
</div>

<div class="well mb-5 mt-4">
    <h4><span class="fas fa-rss-square"></span> Url del sitio web</h4>
    <div class="progress mb-3 pl-2 py-2">
        <a href="https://poax.b32.mx/index.php" target="_blank">https://poax.b32.mx/index.php</a>
    </div>
    <h4><span class="fas fa-share-alt-square"></span> Datos de Sesión</h4>
    <p>
        Email: {{auth()->user()->email}}<br>
        Usuario: {{auth()->user()->name}}<br>
        @if (auth()->user()->role_id == 2)
        @if(auth()->user()->subscription)
        <span class="badge badge-success text-dark">{{auth()->user()->subscription->plan->title}}</span>
        @else
        <a class="btn btn-sm btn-danger" href="{{route('subscribe.show')}}">Suscribirse</a>
        @endif
        @endif
    </p>
    @if (auth()->user()->role_id == 1)
    <h4><span class="fas fa-share-alt-square"></span> Tamaño de archivos en MegasBytes máximo</h4>
    <div class="progress mb-3 pl-2 py-2">
        <div class="barra-progreso" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
            20 MB
        </div>
    </div>
    @endif
</div>