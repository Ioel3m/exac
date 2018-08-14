<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $fillable = [
        'descripcion', 'condicion', 'created_at', 'updated_at'
    ];

    public function users(){
        return $this->hasMany('App\User');
    }
}
