@extends('layouts.app')
@push('css')
<style>

</style>
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <x-menu-sidebar></x-menu-sidebar>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>
                        Lista de Suscriptores<br>
                        <small class="h6">Mostrando {{$subscriptions->firstItem()}}–{{$subscriptions->lastItem()}} de {{$subscriptions->total()}} resultados</small>
                    </h3>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Plan</th>
                                    <th>Estado</th>
                                    <th>Periodo</th>
                                    <th>Expira en</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($subscriptions as $subscription)
                                <tr>
                                    <td>{{$subscription->id}}</td>
                                    <td>{{$subscription->user->name}}</td>
                                    <td>{{$subscription->plan->title}}</td>
                                    <td>{!!$subscription->status_label!!}</td>
                                    <td>{{$subscription->plan->duration_in_days}} Días</td>
                                    <td>{{$subscription->expire_at}}</td>
                                    <td>${{number_format($subscription->plan->price, 2)}}</td>
                                    <td>
                                        @if (!$subscription->isPaid())
                                        <button type="button" data-id="{{$subscription->id}}" class="btn btn-dark btn-subscription-paid">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron registros</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!!$subscriptions->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
    $('.btn-subscription-paid').on('click', function(e) {
        const id = $(this).data('id')
        Swal.fire({
            title: '¿Desea activar la suscripción?',
            text: "¡Por favor verifique el voucher de pago del cliente para validar la activación!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, activar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                let url = `{{route('admin-subscriptions.update', ':id')}}`
                url = url.replace(':id', id)
                try {
                    const {
                        data
                    } = await axios.put(`${url}`)
                    if (data.success) {
                        return data
                    }
                    throw new Error(data.message)
                } catch (error) {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    )
                }
           },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Suscripción habilitada',
                    text: `${result.value.message}`, 
                    icon: 'success',                   
                    confirmButtonText: 'Aceptar',
                }).then(() => {
                    window.location.reload()
                })
            }
        })
    })
</script>
@endpush