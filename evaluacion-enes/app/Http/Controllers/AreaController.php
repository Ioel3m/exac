<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Area;

use Illuminate\Database\QueryException;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function index(){
        $areas = Area::orderBy('name', 'asc')->where('id', '<>', '1')->where('id', '<>', '2')->get();
        return response()->json($areas, 200);
    }

    public function store(Request $request){    
        try{
            $area = new Area();
            $area->name = $request->name;
            $area->save();
            return response()->json(['success' => 'Se ha creado una nueva área'], 200);   
        }catch(QueryException $ex){
            return response()->json($e, 500);
        }
    }

    public function update(Request $request, $id){
        try{
            $area = Area::findOrFail($id);
            $area->name = $request->name;
            $area->save();
            return response()->json(['success' => 'Se ha modificado esta área'], 200);   
        }catch(QueryException $ex){
            return response()->json($e, 500);
        }
    }
}
