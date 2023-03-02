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
                    <h3>Subir archivo para firmar</h3>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <form role="form" method="POST" action="{{route('sign-documents.store')}}" enctype="multipart/form-data">
                        @csrf                        
                        <div class="form-group">
                            <label for="description">Descripción <span class="text-red">*</span></label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" autocomplete="off" placeholder="Descripción *">{{old('description')}}</textarea>
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

                        <div class="form-group">
                            <label for="file">Archivo (PDF) <span class="text-red">*</span></label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" 
                            autocomplete="off" accept="application/pdf">
                            <p class="help-block">Maximo 5MB</p>
                            @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <div class="row col-md-4">
                                <button type="submit" class="btn btn-block btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection