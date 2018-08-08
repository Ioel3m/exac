<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PeriodoAcademico;

use Illuminate\Database\QueryException;

class PeriodoAcademicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodos = PeriodoAcademico::where('condicion', '=', '1')->orderBy('id', 'desc')->get();
        return response()->json([$periodos], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $periodo = new PeriodoAcademico();
            $periodo->fecha_inicio = $request->fecha_inicio;
            $periodo->fecha_fin = $request->fecha_fin;
            $periodo->condicion = '1';
            $periodo->save();
            return response()->json(['success' => 'Se ha creado un nuevo periodo académico'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $periodo = PeriodoAcademico::findOrFail($id);
            $periodo->fecha_inicio = $request->fecha_inicio;
            $periodo->fecha_fin = $request->fecha_fin;
            $periodo->condicion = '1';
            $periodo->save();
            return response()->json(['success' => 'Se ha editado con éxito este periodo académico'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function desactivarPeriodo($id) 
    {
        try{
            $periodo = PeriodoAcademico::findOrFail($id);
            $periodo->condicion = '0';
            $periodo->save();
            return response()->json(['success' => 'Se ha desactivado este periodo'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function habilitado(Request $request, $id) 
    {
        try{
            $periodo = PeriodoAcademico::findOrFail($id);
            $periodo->condicion = $request->condicion;
            $periodo->save();
            if ($request->condicion) {
                return response()->json(['success' => 'SE HA HABILITADO EL PERIODO CON FECHA INICIO '.$periodo->fecha_inicio.' Y FIN '.$periodo->fecha_fin], 200);   
            }else{
                return response()->json(['success' => 'SE HA DESHABILITADO EL PERIODO CON FECHA INICIO '.$periodo->fecha_inicio.' Y FIN '.$periodo->fecha_fin], 200);
            }
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
    
}
