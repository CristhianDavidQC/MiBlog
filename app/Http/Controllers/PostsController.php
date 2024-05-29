<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Posts;
use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //nos servirá para listar
        $blogs = Posts::with('relacionUsuario', 'relacionCategoria')->orderBy('id', 'DESC')->paginate(10); //creamos la tabla y abajo la mostramos
        //dd($blogs);
        return view ('posts.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //solo enviar la vista. PERo blogs necesita categorias y tambien los tags
        $categorias = Categorias::where('estado',true)->get();
        $tags = Tags::where('estado',true)->get();
        return view ('posts.create', compact('categorias', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //ahora queremos que nos registre los datos
        //primero hacemos la validacion
        $this->validate($request,[
            //categoria_id será requerido y tiene que existir en la tabla categorias en el campo ID
            'categoria_id'=>'required|exists:categorias,id',
            //titulo es requerido debe ser de tipo string, como mínimo deberá tener  10 caracteres
            // y como maximo tendrá 200 caracteres
            'titulo' => 'required|string|min:10|max:200',
            //imagen es requerido debe ser de tipo image y las extensiones deben ser png,jpg,jpeg
            //'imagen'=> 'required|image|mimes:png,jpg,jpeg',
            'imagen'=> 'nullable|image|mimes:png,jpg,jpeg',
            'resumen' => 'required|string|min:5|max:350',
            'contenido' => 'required|string|min:5',
            'estado' => 'nullable', //el estado llega como on y of asi que debemos de cambiar para que sea boolean abajo
            'tags' => 'nullable', // puede ser nullable pero debe ser un array
            'fecha_publicacion' => 'required',

        ]);

        // if($request->file('imagen')){ //si la imagen es un archivo
        //     //si existe, debo de obtener esa imagen, instancio la imagen
        //     $imagen = $request->file('imagen');
        //     //creo un nombre de archivo, debo de tener un identificador único
        //     //uniqid empezará en post
        //     $nombreImagen = uniqid('posteados_').'.png';
        //     //si no existe la carpera posteados dentro de la carpeta imagenes entonces la creará
        //     if(!is_dir(public_path('/imagenes/posteados/' ))){
        //         File::makeDirectory(public_path().'/imagenes/posteados/',0777,true);
        //     }
        //     //mover este archivo a la siguiente direccion
        //     $subido = $imagen->move(public_path().'/imagenes/posteados/', $nombreImagen);
        // }else{
        //     //si llegó un archivo, lo subimos y eso está almacenado en nombreImagen
        //     // y si no llegó el archivo a nombreImagen le pongo una por defecto
        //     $nombreImagen= 'default.png';
        // }
        if($request->file('imagen')){ //si la imagen es un archivo
            //si existe, debo de obtener esa imagen, instancio la imagen
            $imagen = $request->file('imagen');
            //creo un nombre de archivo, debo de tener un identificador único
            //pondremos el nombre de la categoria mas una linea temporal
            $nombreImagen = uniqid('post_'). '.png';
            //mover este archivo a la siguiente direccion
            $subido = $imagen->move(public_path().'/imagenes/posteados/', $nombreImagen);
        }else{
            $nombreImagen= 'default.png';
        }
        //instanciamos post para que tenga todas sus propiedades
        $post = new Posts();
        $post->categoria_id = $request->categoria_id;
        $post->titulo = $request->titulo;
        $post->imagen = $nombreImagen; //nombreImagen contiene una imagen
        $post->resumen = $request->resumen;
        $post->contenido = $request->contenido;
        $post->estado = ($request->estado== 'on'? true: false); //ya que estado llega como on y of
        $post->tags = json_encode($request->tags);//guardamos todo el array tags aunque tambien podriamos guardarlo como Json
        $post->fecha_publicacion = $request->fecha_publicacion;
        $post->usuario_id = auth()->user()->id;

        if($post->save()){
            return redirect('/posts')->with('success', 'Registro agregado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue realizado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // busca al Post sugun el id y a su vez me traes las relaciones con usuario  categoria
        //sin el orderby y sin el paginate porque solo es uno
        $post = Posts::with('relacionUsuario', 'relacionCategoria', 'relacionComentarios', 'relacionComentarios.relacionUsuario')->find($id);
        return view('posts.show', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Posts::find($id);
        //dd($post);
        //solo enviar la vista. PERo blogs necesita categorias y tambien los tags
        $categorias = Categorias::where('estado',true)->get();
        $tags = Tags::where('estado',true)->get();
        return view('posts.edit', compact('post','categorias', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         //ahora queremos que nos registre los datos
        //primero hacemos la validacion
        $this->validate($request,[
            //categoria_id será requerido y tiene que existir en la tabla categorias en el campo ID
            'categoria_id'=>'required|exists:categorias,'.$id,
            //titulo es requerido debe ser de tipo string, como mínimo deberá tener  10 caracteres
            // y como maximo tendrá 200 caracteres
            'titulo' => 'required|string|min:10|max:200',
            //imagen es requerido debe ser de tipo image y las extensiones deben ser png,jpg,jpeg
            //'imagen'=> 'required|image|mimes:png,jpg,jpeg',
            'imagen'=> 'nullable|image|mimes:png,jpg,jpeg',
            'resumen' => 'required|string|min:5|max:350',
            'contenido' => 'required|string|min:5',
            'estado' => 'nullable', //el estado llega como on y of asi que debemos de cambiar para que sea boolean abajo
            'tags' => 'nullable', // puede ser nullable pero debe ser un array
            'fecha_publicacion' => 'required'

        ]);
        //buscamos el archivo segun el id
        $post = Posts::find($id);

        if($request->file('imagen')){ //si la imagen es un archivo
             // eliminar el anterior
             if($post->imagen != 'default.png'){
                if(file_exists(public_path().'/imagenes/posteados/'.$post->imagen)){
                    //unlik sirve para borrar la ruta
                    unlink(public_path().'/imagenes/posteados/'.$post->imagen);
                }
            } //una vez eliminado va a subir la nueva imagen

            $imagen = $request->file('imagen');
            //creo un nombre de archivo, debo de tener un identificador único
            //uniqid empezará en post
            $nombreImagen = uniqid('posteados_'). '.png';
            //si no existe la carpera posteados dentro de la carpeta imagenes entonces la creará
            if(!is_dir(public_path('/imagenes/posteados/' ))){
                File::makeDirectory(public_path().'/imagenes/posteados/',0777,true);
            }
            //mover este archivo a la siguiente direccion
            $subido = $imagen->move(public_path().'/imagenes/posteados/', $nombreImagen);
            $post->imagen = $nombreImagen; //nombreImagen contiene una imagen
        }
        // if($request->file('imagen')){ //si la imagen es un archivo
        //     //si existe, debo de obtener esa imagen, instancio la imagen
        //     $imagen = $request->file('imagen');
        //     //creo un nombre de archivo, debo de tener un identificador único
        //     //ponderemos el nombre de la categoria mas una linea temporal
        //     $nombreImagen = uniqid('posteados_'). '.png';
        //     //mover este archivo a la siguiente direccion
        //     $subido = $imagen->move(public_path().'/imagenes/posteados/', $nombreImagen);
        // }
        //instanciamos post para que tenga todas sus propiedades

        $post->categoria_id = $request->categoria_id;
        $post->titulo = $request->titulo;
        $post->resumen = $request->resumen;
        $post->contenido = $request->contenido;
        $post->estado = ($request->estado== 'on'? true: false); //ya que estado llega como on y of
        $post->tags = json_encode($request->tags);//guardamos todo el array tags aunque tambien podriamos guardarlo como Json
        $post->fecha_publicacion = $request->fecha_publicacion;
        $post->usuario_id = auth()->user()->id;

        if($post->save()){
            return redirect('/posts')->with('success', 'Registro Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function estado($id)
    {
        $post = Posts::find($id);
        $post->estado = !$post->estado;
        if($post->save()){
            return redirect('/posts')->with('success', 'Registro Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }
}
