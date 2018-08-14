<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Paralelo;

use Illuminate\Database\QueryException;

class ParaleloController extends Controller
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
            $paralelos = Paralelo::where('condicion', '=', $request->condicion)->where('id', '<>', '1')->orderBy('descripcion', 'asc')->get();    
        }else{
            $paralelos = Paralelo::where('id', '<>', '1')->orderBy('descripcion', 'asc')->get();
        }
        return response()->json($paralelos, 200);
    }

    public function show($id){
        $paralelo = Paralelo::findOrFail($id);
        return response()->json($paralelo, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'descripcion' => 'required|unique:paralelos',
            'condicion' => 'required|boolean'
        ];

        $this->validate($request, $rules);

        $paralelo = new Paralelo();
        $paralelo->descripcion = $request->descripcion;
        $paralelo->condicion = $request->condicion;
        $paralelo->save();
        return response()->json(['success' => 'Se ha creado el paralelo '.$request->descripcion], 200);   
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
                'descripcion' => 'required',
                'condicion' => 'required|boolean'
            ];

            $this->validate($request, $rules);

            $paralelo = Paralelo::findOrFail($id);
            $descripcion_paralelo = $paralelo->descripcion;

            $paralelo->descripcion = $request->descripcion;
            $paralelo->condicion = $request->condicion;
            
            $paralelo->save();
            return response()->json(['success' => 'Se ha editado el paralelo '.$descripcion_paralelo.' a '.$paralelo->descripcion], 200);   
        }catch(QueryException $e){
            return response()->json($e, 422);
        }
    }

    public function habilitado(Request $request, $id) 
    {
        try{
            $rules = [
                'condicion' => 'required|boolean'
            ];

            $this->validate($request, $rules);
            $paralelo = Paralelo::findOrFail($id);
            $paralelo->condicion = $request->condicion;
            $paralelo->save();
            if ($request->condicion) {
                return response()->json(['success' => 'SE HA HABILITADO EL PARALELO '.$paralelo->descripcion], 200);   
            }else{
                return response()->json(['success' => 'SE HA DESHABILITADO EL PARALELO '.$paralelo->descripcion], 200);
            }
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
}
