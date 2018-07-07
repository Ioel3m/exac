<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'idalumno', 'cedula', 'nombres', 'apellidos', 'telefono', 'correo', 'condicion'
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
