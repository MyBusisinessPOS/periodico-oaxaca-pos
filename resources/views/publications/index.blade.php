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
                        Lista de Publicaciones<br>
                        <small class="h6">Mostrando {{$publications->firstItem()}}–{{$publications->lastItem()}} de {{$publications->total()}} resultados</small>
                    </h3>
                    <a href="{{route('publications.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>

                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Archivo</th>
                                    <th>Tipo Publicación</th>
                                    <th>Tamaño</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($publications as $publication)
                                <tr>
                                    <td>{{$publication->id}}</td>
                                    <td>
                                        <a href="{{asset($publication->media)}}" target="_blank">
                                            @if ($publication->media_type === 'application/pdf')
                                            <img width="50" height="50" src="{{asset('img/fontawesome/icono-pdf.png')}}" alt="{{$publication->media_name}}">
                                            @else
                                            <img width="50" height="50" src="{{asset($publication->media)}}" alt="{{$publication->media_name}}">
                                            @endif
                                            
                                        </a>
                                    </td>
                                    <td>{{$publication->type->name}}</td>
                                    <td>{{$publication->media_size}}</td>
                                    <td>{!!getDateColumn($publication, 'updated_at')!!}</td>
                                    <td>
                                        <a href="{{route('publications.edit', $publication->id)}}" title="Editar" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="button" data-toggle="modal" data-target="#delete{{$publication->id}}" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                                        @include('publications.delete')
                                    </td>
                                </tr>
                                
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron registros</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!!$publications->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection