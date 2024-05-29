<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //nos servirá para listar
       $comentarios = Comentarios::with('relacionUsuario', 'relacionPost')->orderBy('id', 'DESC')->paginate(10); //creamos la tabla y abajo la mostramos
       //dd($blogs);
       return view ('comentarios.index', compact('comentarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($post_id)
    {
        //cuando haga el store tendre la id
        return view('comentarios.create', compact('post_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $post_id)
    {
        $this->validate($request, [
            'comentario'=>'required|string|min:10|max:200'
        ]);

        $coment = new Comentarios();
        $coment->post_id = $post_id;
        $coment->comentario = $request->comentario;
        $coment->estado = true;
        $coment->fecha = now();
        $coment->usuario_id = auth()->user()->id;

        if($coment->save()){
            return redirect('/comentarios')->with('success', 'Registro agregado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue realizado');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // busca al comentario sugun el id y a su vez me traes las relaciones con usuario  categoria
        //sin el orderby y sin el paginate porque solo es uno
        $coment = Posts::with('relacionUsuario', 'relacionCategoria')->find($id);
        return view('comentarios.show', compact('coment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comentario = Comentarios::find ($id);
        return view('comentarios.edit', compact('comentario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'comentario'=>'required|string|min:10|max:200'
        ]);

        $coment = Comentarios::find($id);
        $coment->comentario = $request->comentario;
        $coment->estado = true;
        $coment->fecha = now();
        $coment->usuario_id = auth()->user()->id;

        if($coment->save()){
            return redirect('/comentarios')->with('success', 'Registro actualizado Correctamente');
        }else{
            return back()->whit('error', 'El registro no fue actualizado');
        }
    }
    public function estado ($id)
    {
        //busco el item segun el id seleccionado
        $coment = Comentarios::find($id);
        //inveirto el contenido del estado
        $coment->estado = !$coment->estado;
        if($coment->save()){
            return redirect('/comentarios')->with('success', 'Estado Actualizado Correctamente');
        }else{
            return back()->whit('error', 'El Estado no fue actualizado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
