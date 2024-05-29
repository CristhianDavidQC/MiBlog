<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = 'posts'; //protected es como el const o como una clase privada
    protected $filliable = [ //protectec no se podra acceder desde cualquier lado como se hace con public
        'categoria_id',
       ' titulo',
        'imagen',
        'resumen',
        'contenido',
        'estado',
        'tags',
        'fecha_publicacion',
        'usuario_id',
    ];

    //relacion con categorias
    public function relacionCategoria(){
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }
    //relacion con USUARIOS
    public function relacionUsuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    //OBTENER IMAGEN
    public function getImagenUrl(){
        //si el campo imagen existe y es diferente de null
        if($this->imagen&&$this->imagen != 'default.png'&&$this->imagen != null){
            //obtendrá las imagenes desde una carpera que estará en la direccion de abajo
            return asset('imagenes/posteados/'.$this->imagen);
        }else{
            return asset('default.png');
        }
    }
     //RELACION CON COMENTARIOS
     public function relacionComentarios(){
        //de un post, voy a traer todos sus comentarios
        //con la relacion post_id que tengo en comentarios
        return $this->hasMany(Comentarios::class, 'post_id');
    }

}
