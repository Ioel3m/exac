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
    public function index(Request $request)
    {
        if (isset($request->condicion)) {
            $periodos = PeriodoAcademico::where('condicion', '=', $request->condicion)
                ->orderBy('fecha_inicio', 'asc')
                ->get();    
        }else{
            $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'asc')->get();
        }
        return response()->json([$periodos], 200);
    }

    public function show($id){
        $periodo = PeriodoAcademico::findOrFail($id);
        return response()->json([$periodo], 200);
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
            $rules = [
                'fecha_inicio' => 'required|date|unique:periodos_academicos',
                'fecha_fin' => 'required|date|unique:periodos_academicos',
                'condicion' => 'required|boolean'
            ];

            $this->validate($request, $rules);

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
            $rules = [
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'condicion' => 'required|boolean'
            ];

            $this->validate($request, $rules);

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

    public function habilitado(Request $request, $id) 
    {
        try{
            $rules = [
                'condicion' => 'required|boolean'
            ];

            $this->validate($request, $rules);

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
