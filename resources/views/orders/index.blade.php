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
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <x-menu-sidebar></x-menu-sidebar>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>
                        Lista de Ordenes<br>
                        <small class="h6">Mostrando {{$orders->firstItem()}}–{{$orders->lastItem()}} de {{$orders->total()}} resultados</small>
                    </h3>
                    <a href="{{route('orders.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    @if (auth()->user()->role_id === 1)
                                    <th>Cliente</th>
                                    @endif
                                    <th>Categoria</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{$order->label}}</td>
                                    @if (auth()->user()->role_id === 1)
                                    <td>{{$order->user->name}}</td>
                                    @endif
                                    <td>{{$order->service->category->name}}</td>
                                    <td>{{$order->service->name}}</td>
                                    <td>${{number_format($order->price, 2)}}</td>
                                    <td>${{number_format($order->total, 2)}}</td>
                                    <td>{!!$order->badge_status!!}</td>
                                    <td>
                                        @if (auth()->user()->role_id === 1 && $order->status == 'Por Pagar')
                                        <button type="button" data-id="{{$order->id}}" class="btn btn-sm btn-dark btn-paid" title="Marcar como pagado">
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
                        {!!$orders->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('.btn-paid').on('click', function(e) {
        const id = $(this).data('id')
        Swal.fire({
            title: '¿Desea marcar como pagada la orden?',
            text: "¡Por favor verifique el voucher de pago del cliente para validar la orden!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, marcar!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                let url = `{{route('orders.update', ':id')}}`
                url = url.replace(':id', id)
                try {
                    const { data } = await axios.put(`${url}`)
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
                    title: 'Orden Pagada',
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