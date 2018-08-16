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

    /*Devuelve alumnos activos para el docente que hayan actualizado su información de acuerdo a periodo y paralelo*/
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
            ->where('users.informacion_personal', '=', '1')
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
        $alumno = [];
        $estudiante = User::findOrFail($id);
        $representante = Representante::where('idalumno', '=', $id)->get();

        $rep = new Representante();
        foreach ($representante as $key => $r) {
            $rep->cedula = $r['cedula'];
            $rep->nombres = $r['nombres'];
            $rep->apellidos = $r['apellidos'];
            $rep->telefono = $r['telefono'];
            $rep->correo = $r['correo'];
            $rep->condicion = $r['condicion'];
            $rep->idalumno = $r['idalumno'];
        }

        $alumno = [
            "id" =>  $estudiante->id,
            "nombres" => $estudiante->nombres,
            "apellidos" => $estudiante->apellidos,
            "cedula" => $estudiante->cedula,
            "nickname" => $estudiante->nickname,
            "email" => $estudiante->email,
            "telefono" => $estudiante->telefono,
            "direccion" => $estudiante->direccion,
            "fecha_nacimiento" => $estudiante->fecha_nacimiento,
            "estado_civil" => $estudiante->estado_civil,
            "informacion_personal" => $estudiante->informacion_personal,
            "condicion" => $estudiante->condicion,
            "idrol" => $estudiante->idrol,
            "idparalelo" => $estudiante->idparalelo,
            "idarea" => $estudiante->idarea,
            "idperiodo" => $estudiante->idperiodo,
            "created_at" => ($estudiante->created_at == null) ? $estudiante->created_at : $estudiante->created_at->toDateTimeString(),
            "updated_at" => ($estudiante->updated_at == null) ? $estudiante->updated_at : $estudiante->updated_at->toDateTimeString(),
            "cedula_rep" => $rep->cedula,
            "nombres_rep" => $rep->nombres,
            "apellidos_rep" => $rep->apellidos,
            "telefono_rep" => $rep->telefono,
            "correo_rep" => $rep->correo
        ];
        return response()->json($alumno, 200); 
    }

    public function store(Request $request){
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

                $rep = new Representante();
                $rep->cedula = $request->cedula_rep;
                $rep->nombres = $request->nombres_rep;
                $rep->apellidos = $request->apellidos_rep;
                $rep->telefono = $request->telefono_rep;
                $rep->correo = $request->correo_rep;
                $rep->condicion = 1;
                $rep->idalumno = Auth::user()->id;
                $rep->save();
                
            DB::commit();
            return response()->json(['success' => 'SU INFORMACIÓN HA SIDO ACTUALIZADA '.$request->nombres.' '.$request->apellidos], 200);
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json($e, 500);
        }
    }

    public function edit(Request $request, $id){
         try{
            DB::beginTransaction();
            $estudiante = User::findOrFail($id);
            $estudiante->cedula = $request->cedula;
            $estudiante->nombres = $request->nombres;
            $estudiante->apellidos = $request->apellidos;
            $estudiante->nickname = $request->nickname;
            $estudiante->email = $request->email;
            $estudiante->telefono = $request->telefono;
            $estudiante->direccion = $request->direccion;
            $estudiante->fecha_nacimiento = $request->fecha_nacimiento;
            $estudiante->estado_civil = $request->estado_civil;   
            $estudiante->condicion = 1;
            $estudiante->idparalelo = $request->idparalelo;
            $estudiante->idperiodo = $request->idperiodo;
            $estudiante->save();

            $rep = Representante::where('idalumno', $id)->first();
            $rep->cedula = $request->cedula_rep;
            $rep->nombres = $request->nombres_rep;
            $rep->apellidos = $request->apellidos_rep;
            $rep->telefono = $request->telefono_rep;
            $rep->correo = $request->correo_rep;
            $rep->condicion = 1;
            $rep->save();
            DB::commit();

            return response()->json(['success' => 'SE HA ACTUALIZADO EL ESTUDIANTE '.$estudiante->nombres.' '.$estudiante->apellidos], 200);   
        }catch(QueryException $e){
            DB::rollBack();
            return response()->json($e, 500);
        }
    }

    public function resetPassword($id){
        try{
            $estudiante = User::findOrFail($id);
            $estudiante->password = Hash::make($estudiante->cedula);
            //$estudiante->informacion_personal = 0;
            $estudiante->save();
            return response()->json(['success' => 'Se ha reseteado la clave de el estudiante '.$estudiante->nombres.' '.$estudiante->apellidos], 200);
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
