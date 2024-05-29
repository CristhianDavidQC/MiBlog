<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //nos servirá para listar
         //traemos a todos los TAGS con su relacionUsuario, ordenado descendentemente y una paginacion de 10
         $tags = Tags::with('relacionUsuario')->orderBy('id', 'DESC')->paginate(10); //creamos la tabla y abajo la mostramos
         //dd($tags);
         return view ('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //validamos las columnas necesarias de tags

         $this->validate($request, [
            //nombre es requerido y debe ser unico en la tabla tags columna nombre
            'nombre' => 'required|unique:tags',
        ]);

        //ahora instanciamos al modelo tags en la variable tag
        $tag = new Tags();
        $tag->nombre = $request->nombre;
        $tag->estado = true;
        $tag->usuario_id = auth()->user()->id;

        if($tag->save()){
            return redirect('/tags')->with('success', 'Registro agregado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue realizado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tag = Tags:: find($id);
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         //validamos las columnas necesarias de tags
         $this->validate($request,[
            'nombre' => 'required|unique:tags,nombre,'.$id, //es requerido y debe ser unico en la tabla tags

        ]);
        //buscamos el archivo segun el id
         $tag = Tags::find($id);
        //ahora instanciamos al modelo Tags en la variables tag
        $tag->nombre = $request->nombre;
        $tag->estado = true;
        $tag->usuario_id = auth()->user()->id;

        if($tag->save()){
            return redirect('/tags')->with('success', 'Registro Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function estado($id)
    {
        $tag = Tags::find($id);
        $tag->estado = !$tag->estado;

        if($tag->save()){
            return redirect('/tags')->with('success', 'Registro Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }
}
