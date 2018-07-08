<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombres', 'apellidos','cedula', 'nickname', 'email', 'password', 'telefono', 'direccion', 'fecha_nacimiento', 'estado_civil', 'informacion_personal', 'condicion', 'idrol', 'idparalelo', 'idarea', 'idperiodo', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol() {
        return $this->belongsTo('App\Rol');
    }

    public function paralelo() {
        return $this->belongsTo('App\Paralelo');
    }

    public function periodo_academico() {
        return $this->belongsTo('App\PeriodoAcademico');
    }

    public function clases(){
        return $this->hasMany('App\Clase');
    }
    
    public function asistencias(){
        return $this->hasMany('App\Asistencia');
    }
}
