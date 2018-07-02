<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioHabilitado extends Model
{
    protected $table ='usuarios_habilitados';
    protected $fillable = ['num_identificacion', 'condicion'];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
