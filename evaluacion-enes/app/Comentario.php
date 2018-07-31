<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'descripcion', 'idprofesor', 'idpublicacion', 'created_at', 'updated_at'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function publicacion(){
        return $this->belongsTo('App\Publicacion');
    }
}
