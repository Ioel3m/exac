<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PeriodoAcademico;
use App\User;
use App\Area;
use App\Paralelo;
use App\Rol;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }
    
    public function getUserAuth(){
        $user = User::where('id', '=', Auth::user()->id)->get();
        return response()->json(['admin' => $user], 200);  
    }

    public function getAreaUser(){
        $area = Area::where('id', '=', Auth::user()->idarea)->get();
        return response()->json(['area_docente' => $area], 200);
    }

    public function getPeriodoUser(){
        $periodo = PeriodoAcademico::where('id', '=', Auth::user()->idperiodo)->get();
        return response()->json(['periodo_docente' => $periodo], 200);
    }

    public function getParaleloUser(){
        $paralelo = Paralelo::where('id', '=', Auth::user()->idparalelo)->get();
        return response()->json(['paralelo_docente' => $paralelo], 200);
    }
   
    public function getRolUser(){
        $rol = Rol::where('id', '=', Auth::user()->idrol)->get();
        return response()->json(['rol_docente' => $rol], 200);
    }
}
