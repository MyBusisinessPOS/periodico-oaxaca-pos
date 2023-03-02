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
                    <h3>Firmar archivo {{$signDocument->file_uuid}}</h3>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>
                    <form role="form" method="POST" action="{{route('signs.store')}}" enctype="multipart/form-data">
                        <input type="hidden" name="sign_document_id" id="sign_document_id" value="{{$signDocument->id}}">
                        @csrf
                        <div class="form-group">
                            <label for="description">Descripción <span class="text-red">*</span></label>
                            <textarea disabled id="description" name="description" class="form-control">{{$signDocument->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">¡Aviso!</h4>
                                <p>El sistema no acepta archivos de nombre con acentos y símbolos, ejemplo: catálogos.pdf, año.png, o actualización.jpg.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <embed src="{{asset($signDocument->file)}}" type="{{$signDocument->file_type}}" width="100%" height="630px" />
                            </div>
                            <div class="form-group col-md-4">
                                <h5>Agregar una firma en la caja de texto o una imagen</h5>
                                <label for="signature">Firma</label>
                                <input type="text" class="form-control" autocomplete="off" id="signature" name="signature" placeholder="Ingrese texto para la firma">
                                <hr>
                                <label for="media">Firma Digital (.png)</label>
                                <input type="file" name="media" id="media" class="form-control" autocomplete="off" accept="image/png">
                                <p class="help-block">Maximo 3MB</p>
                                @error('media')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <hr>
                                <button type="submit" class="btn btn-block btn-danger"> Guardar Firma</button>

                                <hr>
                                <!-- Signs -->
                                @foreach ($signDocument->signs as $sign)
                                <div class="row text-center" style="font-family: Vladimir Script; font-size: 34px;">
                                    @if ($sign->type == 'text')
                                    <div class='col my-2 py-3 border border-dark'>{{$sign->signature}}</div>
                                    @elseif ($sign->type == 'media')
                                    <div class='col my-2 py-3 border border-dark'><img src="{{asset($sign->media)}}" width='80' height='50'></div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                @if ($signDocument->signs->isNotEmpty())                
                <div class="card-footer">
                    <div class="form-group mt-4">
                        <div class="row col-md-4">
                            <form role="form" method="POST" action="{{route('sign-file')}}">
                                <input type="hidden" name="sign_document_id" id="sign_document_id" value="{{$signDocument->id}}">
                                @csrf
                                <button type="submit" class="btn btn-block btn-primary">Firmar Documento</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection