<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Representante;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

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
            ->select('users.id', 'areas.name', 'paralelos.descripcion as paralelo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('paralelos.id', '=', $paralelo)
            ->where('periodos_academicos.id', '=', $periodo)
            ->where('users.condicion', '=', '1')
            ->where('users.idrol', '=', '2')
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();   
        return response()->json($estudiantes, 200);
    }

    public function allStudent(Request $request){
        $paralelo = $request->paralelo;
        $periodo = $request->periodo;
        $condicion = $request->condicion;
        if(isset($periodo) && !isset($paralelo) && !isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('periodos_academicos.id', '=', $periodo)
                ->where('users.idrol', '=', '2')
                ->orderBy('users.id', 'desc')
                ->get();
        }else if(isset($periodo) && isset($paralelo) && !isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('paralelos.id', '=', $paralelo)
                ->where('periodos_academicos.id', '=', $periodo)
                ->where('users.idrol', '=', '2')
                ->orderBy('users.id', 'desc')
                ->get();
        }else if(!isset($periodo) && isset($paralelo) && !isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('paralelos.id', '=', $paralelo)
                ->where('users.idrol', '=', '2')
                ->orderBy('users.id', 'desc')
                ->get();
        }else if(!isset($periodo) && isset($paralelo) && isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('paralelos.id', '=', $paralelo)
                ->where('users.idrol', '=', '2')
                ->where('users.condicion', '=', $condicion)
                ->orderBy('users.id', 'desc')
                ->get();   
        }else if (isset($periodo) && !isset($paralelo) && isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('periodos_academicos.id', '=', $periodo)
                ->where('users.idrol', '=', '2')
                ->where('users.condicion', '=', $condicion)
                ->orderBy('users.id', 'desc')
                ->get();
        }else if(!isset($periodo) && !isset($paralelo) && isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('users.idrol', '=', '2')
                ->where('users.condicion', '=', $condicion)
                ->orderBy('users.id', 'desc')
                ->get();
        }else if(isset($periodo) && isset($paralelo) && isset($condicion)){
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('paralelos.id', '=', $paralelo)
                ->where('periodos_academicos.id', '=', $periodo)
                ->where('users.idrol', '=', '2')
                ->where('users.condicion', '=', $condicion)
                ->orderBy('users.id', 'desc')
                ->get();   
        }else{
            $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('users.idrol', '=', '2')
                ->orderBy('users.id', 'desc')
                ->get();   
        }
        return response()->json($estudiantes, 200);   
    }
    
    public function getStudents(){
        $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
            ->join('areas', 'areas.id', '=', 'users.idarea')
            ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
            ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
            ->select('users.id', 'areas.name', 'paralelos.descripcion as paralelo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('users.idrol', '=', '2')
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();   
        return response()->json($estudiantes, 200);   
    }

    public function show($id){
        $estudiante = User::findOrFail($id);
        return $estudiante;
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
            $estudiante->condicion = $request->condicion;
            $estudiante->idrol = 2;
            $estudiante->idparalelo = $request->idparalelo;
            $estudiante->idarea = 2;
            $estudiante->idperiodo = $request->idperiodo;
            
            $estudiante->save();

            return response()->json(['success' => 'ESTUDIANTE INGRESADO'], 200);   

        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function updateInformation (Request $request){
        try{
            DB::beginTransaction();
                $estudiante = User::findOrFail(Auth::user()->id);
                $estudiante->nombres = $request->nombres;
                $estudiante->apellidos = $request->apellidos;
                $estudiante->nickname = $request->nickname;
                $estudiante->email = $request->email;
                $estudiante->password = Hash::make($request->password);
                $estudiante->telefono = $request->telefono;
                $estudiante->direccion = $request->direccion;
                $estudiante->fecha_nacimiento = $request->fecha_nacimiento;
                $estudiante->estado_civil = $request->estado_civil;
                $estudiante->informacion_personal = 1;
                $estudiante->update();

                $representantes = $request->representantes;
                foreach ($representantes as $r => $representante) {
                    $rep = new Representante();
                    $rep->cedula = $representante['cedula'];
                    $rep->nombres = $representante['nombres'];
                    $rep->apellidos = $representante['apellidos'];
                    $rep->telefono = $representante['telefono'];
                    $rep->correo = $representante['correo'];
                    $rep->condicion = 1;
                    $rep->idalumno = Auth::user()->id;
                    $rep->save();
                }
            DB::commit();
            return response()->json(['success' => 'SU INFORMACIÓN HA SIDO ACTUALIZADA '.$request->nombres.' '.$request->apellidos], 200);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json($e, 500);
        }
    }

    public function edit(Request $request, $id){
         try{
            $estudiante = User::findOrFail($id);
            $estudiante->cedula = $request->cedula;
            $estudiante->nickname = $request->nickname;
            $estudiante->idparalelo = $request->idparalelo;
            $estudiante->idperiodo = $request->idperiodo;
            $estudiante->save();
            return response()->json(['success' => 'SE HA ACTUALIZADO EL ESTUDIANTE'], 200);   

        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function habilitado(Request $request, $id) 
    {
        try{
            $estudiante = User::findOrFail($id);
            $estudiante->condicion = $request->condicion;
            $estudiante->save();
            if ($request->condicion) {
                return response()->json(['success' => 'SE HA HABILITADO EL ESTUDIANTE '.$estudiante->nombres.' '.$estudiante->apellidos], 200);   
            }else{
                return response()->json(['success' => 'SE HA DESHABILITADO EL ESTUDIANTE '.$estudiante->nombres.' '.$estudiante->apellidos], 200);
            }
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
    
}
