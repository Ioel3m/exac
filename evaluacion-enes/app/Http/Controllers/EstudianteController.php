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
            ->select('users.id', 'areas.name', 'paralelos.descripcion', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('paralelos.id', '=', Auth::user()->idparalelo)
            ->where('periodos_academicos.id', '=', Auth::user()->idperiodo)
            ->where('users.condicion', '=', '1')
            ->where('users.idrol', '=', '2')
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();   
        return response()->json(['estudiantes' => $estudiantes], 200);
    }

    public function allStudent(Request $request){
        $paralelo = $request->paralelo;
        $periodo = $request->periodo;
        $estudiantes = User::join('roles', 'roles.id', '=', 'users.idrol')
            ->join('areas', 'areas.id', '=', 'users.idarea')
            ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
            ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
            ->select('users.id', 'areas.name', 'paralelos.descripcion', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
            ->where('paralelos.id', '=', Auth::user()->idparalelo)
            ->where('periodos_academicos.id', '=', Auth::user()->idperiodo)
            ->where('users.idrol', '=', '2')
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();   
        return response()->json(['estudiantes' => $estudiantes], 200);   
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

    public function habilitado(Request $request){
        try{
            $habilitado = $request->habilitado;
            if ($habilitado != null) {
                foreach ($habilitado as $hb => $habilitar) {
                    $estudiante = User::findOrFail($habilitar['id']);
                    $estudiante->condicion = $habilitar['condicion'];
                    $estudiante->update();
                }
            }else{
                return response()->json(['error' => 'No hay estudiantes !!'], 401);    
            }
            return response()->json(['success' => 'DATOS ENVIADOS !!'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
    
}
