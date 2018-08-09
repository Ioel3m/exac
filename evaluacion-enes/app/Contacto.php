<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{    
    protected $fillable = [
        'nombres', 'telefono', 'correo', 'mensaje', 'created_at', 'updated_at'
    ];
}
