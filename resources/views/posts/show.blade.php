@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio </a></li>
                        <li class="breadcrumb-item active">Posts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-end">
                                <a href="{{ url('/post')}}" class="btn btn-primary btn-sm">Volver al listado</a>
                            </div>
                            <div class="row mt-3">
                                {{-- para mostrar al usuario --}}
                                <div class="col-md-6">
                                    <b>USUARIO:</b> {{ $post->relacionUsuario->name}}
                                    <br>
                                    <small class="text-muted">ESTADO: {{  $post->estado? 'Publicado': 'Borrador' }}</small>
                                </div>
                                {{-- para mostrar la fecha --}}
                                <div class="col-md-6">
                                    <b>FECHA DE PUBLICACION:</b> {{$post->fecha_publicacion}}
                                    <br>
                                    <b>FECHA DE CREACION:</b> {{ $post->created_at }}
                                </div>
                                <div class="text-center">
                                    <h3>{{ $post->titulo}}</h3>
                                    <img  class="border" height="200px" src="{{$post->getImagenUrl()}}" alt="">
                                </div>
                                <div class="mt-3">
                                    <h4>RESUMEN</h4>
                                    {{$post->resumen}}
                                </div>
                                <div class="mt-3">
                                    <h4>CONTENIDO</h4>
                                    {{-- Nueva directiva de Laravel renderiza html
                                        ya que todo lo que se excribio llega en html y todas sus etiquietas --}}
                                    {!! $post->contenido!!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3>Comentarios del post</h3>
                            <table class="table table-borderless">
                                @foreach ($post->relacionComentarios as $comen )
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <b>Usuario:  </b>{{ $comen->relacionUsuario->name }}
                                                </div>
                                                <div class="col-md-6">
                                                    {{ $comen->fecha }}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    {{ $comen->comentario }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection



