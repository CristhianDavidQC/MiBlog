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
                    <li class="breadcrumb-item active">Categorias</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                @include('includes.alertas')  <!--incluye desde la carpera includes aui esta nuestro success nuestro info nuestro error-->

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>POST</th>
                                <th>COMENTARIO</th>
                                <th>ESTADO</th>
                                <th>FECHA PUBLICACIÓN</th>
                                <th>USUARIO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comentarios as $item )
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    {{-- <td>{{ $item->relacionPost->titulo}}</td>  esto solo me mostrará el texto--}}
                                    <td>
                                        <a href="{{ url('/posts/ver/'.$item->post_id)}}"> {{ $item->relacionPost->titulo}} </a>
                                    </td>
                                    <td>{{$item->comentario}}</td>
                                    <td>
                                        @if ($item->estado==true)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->fecha_publicacion }} <br>
                                        <!--Carbon nos ayuda a gestionar fechas de diferentes formas-->
                                        <small>{{ \Carbon\Carbon::parse($item->fecha_publicacion)->diffForHumans(now()) }}</small>
                                    </td>

                                    <td>{{ $item->relacionUsuario->name}}</td>
                                    <td>

                                        <a href="{{url('/comentarios/actualizar/'.$item->id)}}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($item->estado==true)
                                            <a href="{{url('/comentarios/estado/'.$item->id)}}" class="btn btn-danger btn-sm">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        @else
                                            <a href="{{url('/comentarios/estado/'.$item->id)}}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $comentarios ->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
