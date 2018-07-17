<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Paralelo;

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
    public function index()
    {
        $paralelos = Paralelo::where('condicion', '=', '1')->where('id', '<>', '1')->orderBy('id', 'desc')->get();
        return response()->json(['paralelos' => $paralelos], 200);
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
            $paralelo = new Paralelo();
            $paralelo->descripcion = $request->descripcion;
            $paralelo->save();
            return response()->json(['success' => 'Se ha creado un nuevo paralelo'], 200);   
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
            $paralelo = Paralelo::findOrFail($id);
            $paralelo->descripcion = $request->descripcion;
            $paralelo->save();
            return response()->json(['success' => 'Se ha editado este paralelo'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function desactivarParalelo($id) 
    {
        try{
            $paralelo = Paralelo::findOrFail($id);
            $paralelo->condicion = '0';
            $paralelo->save();
            return response()->json(['success' => 'Se ha desactivado este paralelo'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }

    public function activarParalelo($id) 
    {
        try{
            $paralelo = Paralelo::findOrFail($id);
            $paralelo->condicion = '1';
            $paralelo->save();
            return response()->json(['success' => 'Se ha activado este paralelo'], 200);   
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
}
