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
                        Nueva Orden
                    </h3>
                    <a href="{{route('orders.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Atras</a>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>

                    <table class="table">

                        @foreach ($categories as $category)
                        <thead>
                            <tr>
                                <th>{{$category->name}}</th>
                                <th>UMA</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->services as $service)
                                <tr>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->uma}}</td>
                                    <td>{{number_format($service->price, 2)}}</td>
                                    <td>
                                        <button type="button" data-service="{{$service}}" class="btn btn-sm btn-dark btn-make-order"><i class="fa fa-cart-plus"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        @endforeach

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script> 
        $('.btn-make-order').on('click', function () {
            const service = $(this).data('service')
            
            Swal.fire({
                title: `¿Desea generar la orden de ${service.name}?`,
                // text: "¡Por favor verifique el voucher de pago del cliente para validar la activación!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, generar!',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const { data } = await axios.post(`{{route('orders.store')}}`, service)
                        console.log(data)
                        if (data.success) {
                            
                        } else {
                            Swal.showValidationMessage(
                                `Request failed: ${data.message}`
                            )    
                        }
                        
                    } catch (error) {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
            
        })
    </script>
@endpush