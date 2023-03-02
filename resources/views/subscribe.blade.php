@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <x-menu-sidebar></x-menu-sidebar>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card-deck mb-3 text-center">
                        <div class="card mb-3 box-shadow">
                            <div class="card-header">
                                <h3 class="font-weight-bold">Suscripción Semestral/Anual: </h3>
                                @if (auth()->user()->subscription)
                                @if (!auth()->user()->hasPaidSubscription())
                                <div class="alert text-justify alert-warning alert-block">
                                    Tu tienes una subscripcion <strong>{!!auth()->user()->subscription->plan->title!!}</strong>.
                                    Para continuar con tu solicitud de suscripción le proporcionamos un correo electrónico para que nos envié su comprobante de pago para poder habilitar su plan y comenzar a usarla.
                                    Correo: <a class="text-link text-primary" href="mailto:documentooficial@oaxaca.com.mx">documentooficial@oaxaca.com.mx</a>
                                </div>
                                @endif
                                @endif
                            </div>
                            <form action="{{route('subscribe.store')}}" method="post" id="paymentForm">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    @foreach ($plans as $plan)
                                                    <label class="btn btn-outline-primary rounded m-2 p-3 {{$plan_id == $plan->id ? 'active' : ''}}">
                                                        <input type="radio" name="plan" value="{{$plan->slug}}" required>
                                                        <strong>Plan</strong>
                                                        <p class="h5 font-weight-bold text-capitalize">
                                                            {{$plan->title}}
                                                        </p>
                                                        <p class="display-4 text-capitalize">
                                                            {{$plan->visual_price}}
                                                        </p>
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5_">
                                        <div class="col-md-12">
                                            <x-custom-alert></x-custom-alert>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn position-sticky btn-lg btn-block btn-dark">Suscribirse</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection