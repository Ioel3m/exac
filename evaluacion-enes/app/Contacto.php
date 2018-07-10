<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'nombres', 'telefono', 'correo', 'mensaje'
    ];
}
