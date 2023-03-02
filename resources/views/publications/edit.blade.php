@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <x-menu-sidebar></x-menu-sidebar>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Editar Publicación</h3>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <form role="form" method="POST" action="{{route('publications.update', $publication->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="publication_type_id">Tipo de Publicación <span class="text-red">*</span></label>
                                <select id="publication_type_id" name="publication_type_id" class="form-control @error('publication_type_id') is-invalid @enderror" autocomplete="off">
                                    <option>Selecciona un opción</option>
                                    @foreach ($types as $type)
                                    <option {{old('publication_type_id', $publication->publication_type_id) == $type->id ?'selected' : ''}} value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>

                                @error('publication_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="document_type_id">Tipo de Documento <span class="text-red">*</span></label>
                                <select id="document_type_id" name="document_type_id" class="form-control @error('document_type_id') is-invalid @enderror" autocomplete="off">
                                    <option>Selecciona un opción</option>
                                    @foreach ($documents as $document)
                                    <option {{old('document_type_id', $publication->document_type_id) == $document->id ?'selected' : ''}} value="{{$document->id}}">{{$document->name}}</option>
                                    @endforeach
                                </select>

                                @error('document_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="author">Autor de la Publicación <span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" autocomplete="off" id="author" name="author" placeholder="Autor de la Publicación *" value="{{old('author', $publication->author)}}">
                                @error('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="publication_category_id">Clasificación <span class="text-red">*</span></label>
                                <select id="publication_category_id" name="publication_category_id" class="form-control @error('publication_category_id') is-invalid @enderror" autocomplete="off">
                                    <option>Selecciona un opción</option>
                                    @foreach ($categories as $category)
                                    <option {{old('publication_category_id', $publication->publication_category_id) == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('publication_category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="summary">Sumario <span class="text-red">*</span></label>
                            <input value="{{old('summary', $publication->summary)}}" type="text" class="form-control @error('summary') is-invalid @enderror" autocomplete="off" id="summary" name="summary" placeholder="Sumario *">
                            @error('summary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción del archivo <span class="text-red">*</span></label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" autocomplete="off" placeholder="Descripción del archivo *">{{old('description', $publication->description)}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">¡Aviso!</h4>
                                <p>El sistema no acepta archivos de nombre con acentos y símbolos, ejemplo: catálogos.pdf, año.png, o actualización.jpg.
                                </p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="media">Imagen <span class="text-red">*</span></label>
                                <input type="file" name="media" id="media" class="form-control @error('media') is-invalid @enderror" autocomplete="off">
                                <p class="help-block">Maximo 3MB</p>
                                @error('media')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 align-items-center">
                                <label for="image" class="text-center"><strong>Imagen Actual</strong></label>
                                <img id="image" src="{{asset($publication->media)}}" class="img-fluid img-round" alt="{{$publication->media_name}}">
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="row col-md-4">
                                <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection