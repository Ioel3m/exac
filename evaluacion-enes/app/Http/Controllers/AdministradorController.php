<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Area;

use App\PeriodoAcademico;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function index(){
        $docentes = User::join('roles', 'roles.id', '=', 'users.idrol')
        ->join('areas', 'areas.id', '=', 'users.idarea')
        ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
        ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
        ->select('users.id', 'areas.name as area', 'paralelos.descripcion', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
        ->where('users.idrol', '=', '3')
        ->orderBy('users.apellidos', 'users.nombres', 'asc')
        ->get();   
        return $docentes;
    }
    
    public function store(Request $request){
        try{
            $docente = new User();
            $docente->nombres = $request->nombres;
            $docente->apellidos = $request->apellidos;
            $docente->cedula = $request->cedula;
            $docente->nickname = $request->cedula.'-DOC';
            $docente->email = $request->email;
            $docente->password = Hash::make($request->cedula);
            $docente->telefono = $request->telefono;
            $docente->direccion = $request->direccion;
            $docente->fecha_nacimiento = '1990-09-09';
            $docente->estado_civil = null;
            $docente->informacion_personal = 1;
            $docente->condicion = 1;
            $docente->idrol = 3;
            $docente->idparalelo = $request->idparalelo;
            $docente->idarea = $request->idarea;
            $docente->idperiodo = $request->idperiodo;
            
            $docente->save();
            return response()->json(['success' => 'Docente registrado correctamente'], 200);   

        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }   
}
