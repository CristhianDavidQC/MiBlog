<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = [
        'nombre',
        'imagen',
        'estado',
        'usuario_id',
    ];

    //OBTENER LA IMAGEN
    public function getImagenUrl(){
        //si el campo imagen existe y es diferente de nul
        if($this->imagen && $this->imagen != 'default.png'&& $this->imagen != null){
            //obtendrá las imagenes desde una carpera que estará en la direccion de abajo
            return asset('imagenes/categorias/'.$this->imagen);
        }else{
            return asset('default.png');
        }
    }


    //relacion con USUARIOS
    public function relacionUsuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

}
