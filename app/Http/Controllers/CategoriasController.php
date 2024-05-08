<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //nos servirá para listar
        $categorias = Categorias::with('relacionUsuario')->orderBy('id', 'DESC')->paginate(10); //creamos la tabla y abajo la mostramos
        //dd($categorias);
        return view ('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('categorias.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validamos las columnas necesarias de categorias
        $this->validate($request,[
            'nombre' => 'required|unique:categorias', //es requerido y debe ser unico en la tabla categorias
            'imagen'=> 'nullable|image|mimes:png,jpg,jpeg', //puede ser nula y debe ser de tipo imagen

        ]);
        //SUBIMOS ARCHIVO AL SERVIDOR Y YA PODEMOS USARLO
        //debemos de subir la imagen a nuestro servidor, preguntando antes si existe
        if($request->file('imagen')){ //si la imagen es un archivo
            //si existe, debo de obtener esa imagen, instancio la imagen
            $imagen = $request->file('imagen');
            //creo un nombre de archivo, debo de tener un identificador único
            //ponderemos el nombre de la categoria mas una linea temporal
            $nombreImagen = uniqid('categoria_').'.png';
            //mover este archivo a la siguiente direccion
            $subido = $imagen->move(public_path().'/imagenes/categorias/', $nombreImagen);
        }else{
            $nombreImagen= 'default.png';
        }

        //ahora instanciamos al modelo categorias ne la variables categoria
        $categoria = new Categorias();
        $categoria->nombre = $request->nombre;
        $categoria->imagen = $nombreImagen;
        $categoria->estado = true;
        $categoria->usuario_id = auth()->user()->id;

        if($categoria->save()){
            return redirect('/categorias')->with('success', 'Registro agregado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue realizado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categorias:: find($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validamos las columnas necesarias de categorias
        $this->validate($request,[
            'nombre' => 'required|unique:categorias,nombre,'.$id, //es requerido y debe ser unico en la tabla categorias
            'imagen'=> 'nullable|image|mimes:png,jpg,jpeg', //puede ser nula y debe ser de tipo imagen

        ]);
        //buscamos el archivo segun el id
         $categoria = Categorias::find($id);
        //debemos de subir la imagen a nuestro servidor, preguntando antes si existe
        if($request->file('imagen')){ //si la imagen es un archivo
            // elliminar el anterior
            if($categoria->imagen!='default.png'){
                if(file_exists(public_path().'/imagenes/categorias/'.$categoria->imagen)){
                    //unlik sirve para borrar la ruta
                    unlink(public_path().'/imagenes/categorias/'.$categoria->imagen);
                }
            }

            //si existe, debo de obtener esa imagen, instancio la imagen
            $imagen = $request->file('imagen');
            //creo un nombre de archivo, debo de tener un identificador único
            //ponderemos el nombre de la categoria mas una linea temporal
            $nombreImagen = uniqid('categoria_').'.png';
            //mover este archivo a la siguiente direccion
            $subido = $imagen->move(public_path().'/imagenes/categorias/', $nombreImagen);
        }

        //ahora instanciamos al modelo categorias en la variables categoria
        $categoria->nombre = $request->nombre;
        $categoria->imagen = $nombreImagen;
        $categoria->estado = true;
        $categoria->usuario_id = auth()->user()->id;

        if($categoria->save()){
            return redirect('/categorias')->with('success', 'Registro Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function estado($id)
    {
        $categoria = Categorias::find($id);
        $categoria->estado = !$categoria->estado;

        if($categoria->save()){
            return redirect('/categorias')->with('success', 'Registro Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }
}
