<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $fillable = ['idprofesor', 'tema', 'condicion'];
    
    public function asistencias()
    {
        return $this->hasMany('App\Asistencia');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
