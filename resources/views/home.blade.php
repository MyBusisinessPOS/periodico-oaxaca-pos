@extends('layouts.app')
@push('css')
<style>
    .link-color {
        color: #93c54b;
        text-decoration: underline;
    }

    .link-color:hover {
        color: #769e3c;
    }

    .list-group-item {
        color: #3e3f3a !important;
    }
</style>
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-end">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <x-menu-sidebar></x-menu-sidebar>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-8 ">
            <x-custom-alert></x-custom-alert>
            <div class="panel panel-default">
                <div class="panel-heading main-color-bg mb-3">
                    <h4 class="panel-title">Opciones de administración de módulos</h4>
                </div>
                <div class="panel-body">
                    @if (auth()->user()->role_id === 1)
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{route('publications.index')}}" class="link-color">
                                <div class="well dash-box d-flex flex-column align-items-center ">
                                    <div class="w-25">
                                        <img src="{{asset('img/icono-pdf.png')}}" class="img-fluid" alt="...">
                                    </div>

                                    <h3><svg class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true" data-prefix="fas" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path>
                                        </svg>Administrar publicación</h3>
                                    <h4>Agregar, Editar y Eliminar</h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('sign-documents.index')}}" class="link-color">
                                <div class="well dash-box d-flex flex-column align-items-center ">
                                    <div class="w-25">
                                        <img src="{{asset('img/icono-write-pdf.png')}}" class="img-fluid" alt="...">
                                    </div>

                                    <h3>
                                        <svg class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true" data-prefix="fas" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path>
                                        </svg> Archivos certificados
                                    </h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>Bienvenido {{auth()->user()->name}}</h3>
                            @if (auth()->user()->hasPaidSubscription() === 0)
                            <div class="alert text-justify mt-5 alert-warning alert-block">
                                <strong>Tu tienes una subscripcion {!!auth()->user()->subscription->plan->title!!}.
                                    Para continuar con tu solicitud de suscripción le proporcionamos un correo electrónico para que nos envié su comprobante de pago para poder habilitar su plan y comenzar a usarla.
                                    Correo: <a class="text-link text-primary" href="mailto:documentooficial@oaxaca.com.mx">documentooficial@oaxaca.com.mx</a> </strong>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection