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
                        Lista de Archivos<br>
                        <small class="h6">Mostrando {{$documents->firstItem()}}–{{$documents->lastItem()}} de {{$documents->total()}} resultados</small>
                    </h3>
                    <a href="{{route('sign-documents.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>

                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Archivo</th>
                                    <th>Tipo</th>
                                    <th>Tamaño</th>
                                    <th>Fecha</th>
                                    <th>¿Firmado?</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $document)
                                <tr>
                                    <td>{{$document->id}}</td>
                                    <td>
                                        <a target='_blank' href="{{asset($document->file)}}">
                                            <span class='fas fa-file-pdf tamanioicon'></span>
                                        </a>
                                    </td>
                                    <td>{{$document->file_type}}</td>
                                    <td>{{$document->file_size}}</td>
                                    <td>{!!getDateColumn($document, 'updated_at')!!}</td>
                                    <td>{!!getBooleanColumn($document, 'is_signed')!!}</td>
                                    <td>
                                        <a href="{{route('sign-documents.edit', $document->id)}}" title="Editar" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        @if (!$document->is_signed)
                                        <a href="{{route('sign-documents.show', $document->id)}}" title="Firmar" class="btn btn-sm btn-warning"><i class="fa fa-sign"></i></a>
                                        @endif
                                        <button type="button" data-toggle="modal" data-target="#delete{{$document->id}}" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                                        @include('sign_documents.delete')
                                    </td>
                                </tr>
                                
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron registros</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!!$documents->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection