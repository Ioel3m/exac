<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $table ='publicaciones';
    
    protected $fillable = [
        'descripcion', 'idprofesor', 'created_at', 'updated_at'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comentarios(){
        return $this->hasMany('App\Comentario');
    }
}
