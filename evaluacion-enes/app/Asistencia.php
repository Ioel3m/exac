<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = ['idalumno', 'idclase', 'asistio'];
    
    public function clase()
    {
        return $this->belongsTo('App\Clase');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
