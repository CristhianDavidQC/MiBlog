@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Comentarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio </a></li>
                    <li class="breadcrumb-item active">Tags</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        @include('includes.alertas')  <!--incluye desde la carpera includes-->

                        <!--Cuando enviamos imagenes debemos de añadir     endtype="multipart/form-data"  igual pasa en VUE-->
                        <form action="{{ url('/comentarios/actualizar/'.$comentario->id)}}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="comentario">Comentario</label>
                                <textarea name="comentario" cols="30" rows="2" class="form-control">{{ $comentario->comentario }}</textarea>
                                <!--validacion de que este campo no este vacio-->
                                @error('comentario') <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="text-center">
                                <a href="{{ url('/comentarios')}}" class="btn btn-primary ">Ir al Listado</a>
                                <button class="btn btn-success" type="submit">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
