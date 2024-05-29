@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Posts</h1>
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
        <!--Cuando enviamos imagenes debemos de añadir     endtype="multipart/form-data"  igual pasa en VUE-->
        <form action="{{ url('/posts/registrar') }}" method="POST" endtype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                @include('includes.alertas') <!--incluye desde la carpera includes-->
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        {{-- imagen y titulo --}}
                        <div class="card m-1">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="imagen">Imagen</label>
                                    <!--Los inputs de tipo file son para las imagenes-->
                                    <input type="file" name="imagen" value="{{ old('imagen') }}" class="form-control">
                                    <!--validacion de que este campo no este vacio-->
                                    @error('imagen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="titulo">Titulo</label>
                                    <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control">
                                    <!--validacion de que este campo no este vacio-->
                                    @error('titulo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- categorias y tags  --}}
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="form-group">
                                    <!--Necesito un select múltiple para categorias-->
                                    <label for="categoria_id">Categoría</label>
                                    <select type="text" name="categoria_id" id="categoria_id"  class="form-control">
                                        <option value="">Seleccione ...</option>
                                        @foreach ($categorias as $categ )
                                            <option value="{{ $categ->id }}"@if($categ->id==old('categori_id'))selected @endif> {{ $categ->nombre}} </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                    <!--Necesito un select múltiple para Tags-->
                                <div class="form-group">
                                    <label for="tags">#Tags</label>
                                    <select name="tags[]" id="tags"  class="form-control" multiple><!--multiple permite seleccionar mas de una opcion-->
                                        <option value="">Seleccione ...</option>
                                        @foreach ($tags as $item )
                                            <option value="{{ $item->nombre }}" {{-- post->tags es un array, y a ese array le preguntamos si existe, si existe que lo seleccione --}}
                                                @if( old('tags') && in_array($item->nombre, old('tags')))
                                                selected
                                                @endif>{{ $item->nombre}}</option>{{ $item->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        {{--Fecha publicacion y estado--}}
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="form-grpup">
                                    <label for="fecha_publicacion">Fecha publicacion</label>
                                    <input type="datetime-local" name="fecha_publicacion" class="form-control" value="{{old('fecha_publicacion')}}">
                                    @error('fecha_publicacion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mt-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="estado" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Publicar?</label>
                                        @error('estado')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="{{ url('/posts') }}" class="btn btn-primary ">Volver al Listado</a>
                                    <button class="btn btn-success" type="submit">Registrar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-7">
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="resumen">Resumen del Posts</label>
                                    <textarea name="resumen" id="resumen" cols="30" rows="3" class="form-control" {{ old('resumen')}}></textarea>
                                    @error('resumen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="contenido">Contenido del Posts</label>
                                    <textarea name="contenido" id="contenido" cols="30" rows="15" class="form-control" {{ old('contenido')}}></textarea>
                                    @error('contenido')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
{{-- aqui vamos a usar summerNote para que mi textArea funcione --}}
    <script>
        $(document).ready(function() {
            $('#contenido').summernote(
                {
                    placeholder: 'Escribe el contenido, aqui..',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                }
            );

        });
    </script>

@endsection
