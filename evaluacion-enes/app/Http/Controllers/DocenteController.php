<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Area;

use App\PeriodoAcademico;

use App\Paralelo;

use App\Rol;

class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function index(Request $request){
        $paralelo = $request->paralelo;
        $periodo = $request->periodo;
        $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
        ->join('areas', 'areas.id', '=', 'users.idarea')
        ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
        ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
        ->select('users.id', 'areas.name', 'paralelos.descripcion', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
        ->where('paralelos.id', '=', $paralelo)
        ->where('periodos_academicos.id', '=', $periodo)
        ->where('users.condicion', '=', '1')
        ->where('users.idrol', '=', '2')
        ->orderBy('users.apellidos', 'users.nombres', 'asc')
        ->get();   
        return $estudiantes;
    }

    public function getAreaDocente($id){
        $area = Area::where('id', '=', $id)->get();
        return response()->json(['area_docente' => $area], 200);
    }

    public function getPeriodoDocente($id){
        $periodo = PeriodoAcademico::where('id', '=', $id)->get();
        return response()->json(['periodo_docente' => $periodo], 200);
    }

    public function getParaleloDocente($id){
        $paralelo = Paralelo::where('id', '=', $id)->get();
        return response()->json(['paralelo_docente' => $paralelo], 200);
    }
   
    public function getRolDocente($id){
        $rol = Rol::where('id', '=', $id)->get();
        return response()->json(['rol_docente' => $rol], 200);
    }
}
