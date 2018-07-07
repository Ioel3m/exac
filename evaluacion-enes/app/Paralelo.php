<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $fillable = [
        'descripcion', 'condicion'
    ];

    public function users(){
        return $this->hasMany('App\User');
    }
}
