@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva Categorias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio </a></li>
                    <li class="breadcrumb-item active">Categorias</li>
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
                        <form action="{{ url('/categorias/registrar')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control">
                                @error('nombre') <small class="text-danger">{{$message}}</small> <!--validacion de que este campo no este vacio-->
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <!--Los inputs de tipo file son para las imagenes-->
                                <input type="file" name="imagen" value="{{old('imagen')}}" class="form-control">
                                @error('imagen') <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="text-center">
                                <a href="{{ url('/categorias')}}" class="btn btn-primary ">Volver al Listado</a>
                                <button class="btn btn-success" type="submit">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
