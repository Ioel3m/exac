<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Asistencia;

use App\Clase;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

}
