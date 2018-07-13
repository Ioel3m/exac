<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
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

    public function ingresarAlumno(Request $request){
        try{
            $estudiante = new User();
            $estudiante->nombres = '';
            $estudiante->apellidos = '';
            $estudiante->cedula = $request->cedula;
            $estudiante->nickname = $request->cedula.'-EST';
            $estudiante->email = '';
            $estudiante->password = Hash::make($request->cedula);
            $estudiante->telefono = '';
            $estudiante->direccion = '';
            $estudiante->fecha_nacimiento = '1990-09-09';
            $estudiante->estado_civil = null;
            $estudiante->informacion_personal = 0;
            $estudiante->condicion = 0;
            $estudiante->idrol = 2;
            $estudiante->idparalelo = $request->idparalelo;
            $estudiante->idarea = $request->idarea;
            $estudiante->idperiodo = $request->idperiodo;
            
            $estudiante->save();
            return response()->json(['success' => 'Estudiante ingresado'], 200);   

        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function habilitar($id){
        try{
            $estudiante = User::findOrFail($id);
            $estudiante->condicion = '1';
            $estudiante->save();
            return response()->json(['success' => 'Se ha habilitado el alumno '.$estudiante->nombres.' '.$estudiante->apellidos], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
    
    public function deshabilitar($id){
        try{
            $estudiante = User::findOrFail($id);
            $estudiante->condicion = '0';
            $estudiante->save();
            return response()->json(['success' => 'Se ha deshabilitado el alumno '.$estudiante->nombres.' '.$estudiante->apellidos], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
}
