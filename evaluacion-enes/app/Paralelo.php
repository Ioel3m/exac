<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $fillable = [
        'idperiodo', 'denominacion', 'descripcion', 'condicion'
    ];

    public function periodo_academico() {
        return $this->belongsTo('App\PeriodoAcademico');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
