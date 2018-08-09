<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
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
            ->select('users.id', 'areas.id as idarea','areas.name as area', 'paralelos.id as idparalelo','paralelos.descripcion as paralelo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('users.idrol', '=', '3')
            ->orderBy('users.id', 'desc')
            ->get();   
        return response()->json($docentes, 200);
    }
    
    public function show(Request $request){
        $paralelo = $request->paralelo;
        $periodo = $request->periodo;
        $docentes = User::join('roles', 'roles.id', '=', 'users.idrol')
            ->join('areas', 'areas.id', '=', 'users.idarea')
            ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
            ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
            ->select('users.id', 'areas.name as area', 'paralelos.descripcion as paralelo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('users.idrol', '=', '3')
            ->where('paralelos.id', '=', $paralelo)
            ->where('periodos_academicos.id', '=', $periodo)
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();   
        return response()->json($docentes, 200);
    }

    public function search($id){
        $docente = User::findOrFail($id);
        return response()->json($docente, 200);
    }

    public function getDocentesActive(Request $request){
        $paralelo = $request->paralelo;
        $periodo = $request->periodo;
        $condicion = $request->condicion;
        $docentes = User::join('roles', 'roles.id', '=', 'users.idrol')
            ->join('areas', 'areas.id', '=', 'users.idarea')
            ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
            ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
            ->select('users.id', 'areas.name as area', 'paralelos.descripcion as paralelo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('users.idrol', '=', '3')
            ->where('paralelos.id', '=', $paralelo)
            ->where('periodos_academicos.id', '=', $periodo)
            ->where('users.condicion', '=', $condicion)
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();   
        return response()->json($docentes, 200);
    }

    public function store(Request $request){
        $rules = [
            'cedula' => 'numeric|required|unique:users'
        ];

        $this->validate($request, $rules);

        $docente = new User();
        $docente->nombres = '';
        $docente->apellidos = '';
        $docente->cedula = $request->cedula;
        $docente->nickname = $request->cedula.'-DOC';
        $docente->email = '';
        $docente->password = Hash::make($request->cedula);
        $docente->telefono = '';
        $docente->direccion = '';
        $docente->fecha_nacimiento = '1990-09-09';
        $docente->estado_civil = null;
        $docente->informacion_personal = 0;
        $docente->condicion = 1;
        $docente->idrol = 3;
        $docente->idparalelo = $request->idparalelo;
        $docente->idarea = $request->idarea;
        $docente->idperiodo = $request->idperiodo;
        
        $docente->save();
        return response()->json(['success' => 'Docente registrado correctamente !!'], 200);   
    }

    public function updateProfileDocente(Request $request){
        $rules = [
            'nickname' => 'required',
            'email' => 'required'
        ];

        $this->validate($request, $rules);

        $docente = User::findOrFail(Auth::user()->id);
        $docente->nombres = $request->nombres;
        $docente->apellidos = $request->apellidos;
        $docente->nickname = $request->nickname;
        $docente->email = $request->email;
        $docente->password = Hash::make($request->password);
        $docente->telefono = $request->telefono;
        $docente->direccion = $request->direccion;
        $docente->fecha_nacimiento = $request->fecha_nacimiento;
        $docente->estado_civil = $request->estado_civil;
        $docente->informacion_personal = 1;
        $docente->condicion = 1;
    
        $docente->save();
        return response()->json(['success' => 'Perfil del docente actualizado'], 200);   
    }
    
    public function update(Request $request, $id){
        try{
            $rules = [
                'cedula' => 'numeric|required'
            ];

            $this->validate($request, $rules);

            $docente = User::findOrFail($id);
            $docente->nombres = $request->nombres;
            $docente->apellidos = $request->apellidos;
            $docente->cedula = $request->cedula;
            $docente->nickname = $request->nickname;
            $docente->email = $request->email;
            $docente->telefono = $request->telefono;
            $docente->direccion = $request->direccion;
            $docente->fecha_nacimiento = $request->fecha_nacimiento;
            $docente->estado_civil = $request->estado_civil;
            $docente->condicion = 1;
            $docente->idrol = 3;
            $docente->idparalelo = $request->idparalelo;
            $docente->idarea = $request->idarea;
            $docente->idperiodo = $request->idperiodo;
            
            $docente->save();
            return response()->json(['success' => 'Se han guardado los cambios !!'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function resetPassword($id){
        try{
            $docente = User::findOrFail($id);
            $docente->password = Hash::make($docente->cedula);
            $docente->informacion_personal = 0;
            $docente->save();
            return response()->json(['success' => 'Se ha reseteado la clave de el docente '.$docente->nombres.' '.$docente->apellidos], 200);
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function habilitar(Request $request, $id) 
    {
        try{
            $docente = User::findOrFail($id);
            $docente->condicion = $request->condicion;
            $docente->save();
            if ($request->condicion) {
                return response()->json(['success' => 'SE HA HABILITADO EL DOCENTE '.$docente->nombres.' '.$docente->apellidos], 200);   
            }else{
                return response()->json(['success' => 'SE HA DESHABILITADO EL DOCENTE '.$docente->nombres.' '.$docente->apellidos], 200);
            }
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

}
