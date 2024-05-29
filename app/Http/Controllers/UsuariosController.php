<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //nos servirá para listar
         //traemos a todos los USERS
         $usuarios = User::orderBy('id','DESC')->paginate(10);
         //dd($tags);
         return view ('usuarios.index', compact('usuarios'));
    }
}
