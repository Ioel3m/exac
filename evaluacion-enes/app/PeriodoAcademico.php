<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoAcademico extends Model
{
    
    protected $table ='periodos_academicos';

    protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'condicion'
    ];

    public function paralelos(){
        return $this->hasMany('App\Paralelo');
    }
}
