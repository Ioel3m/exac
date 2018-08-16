<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Publicacion;

use App\Comentario;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\QueryException;

use Carbon\Carbon;

class PublicacionController extends Controller
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
        $publish = Publicacion::join('users', 'users.id', '=', 'publicaciones.idprofesor')
            ->select('publicaciones.id as idpublish','users.nombres as name_user_post', 
            'users.apellidos as lastname_user_post', 'publicaciones.descripcion as post', 
            'publicaciones.created_at as fecha_post_creado', 'publicaciones.updated_at as fecha_post_editado')
            ->orderBy('publicaciones.id', 'desc')
            ->get();

        $arrayPublicaciones = [];

        foreach ($publish as $key => $p) {      
            $comments = Comentario::join('users', 'users.id', '=', 'comentarios.idprofesor')
            ->join('publicaciones', 'publicaciones.id', '=', 'comentarios.idpublicacion')
            ->select('users.nombres as name_user_comment', 'users.apellidos as lastname_user_comment',
            'comentarios.id as idcomment','comentarios.descripcion as comentario','comentarios.created_at as fecha_comentario_creado', 'comentarios.updated_at as fecha_comentario_editado')
            ->where('publicaciones.id', '=', $p['idpublish'])
            ->orderBy('comentarios.id','asc')
            ->get();

            $arrayPublicaciones[] = [
                'id' => $p['idpublish'],
                'user_name_post' => $p['name_user_post'],
                'user_lastname_post' => $p['lastname_user_post'],
                'post' => $p['post'],
                'fecha_post_creado' => $p['fecha_post_creado'],
                'fecha_post_editado' => $p['fecha_post_editado'],
                'comentarios' => $comments
           ];
        }
        return response()->json($arrayPublicaciones, 200);   
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
            'descripcion' => 'required'
        ];

        $this->validate($request, $rules);

        $campos = $request->all();        
        $campos['idprofesor'] = Auth::user()->id;
        $publicar = Publicacion::create($campos);
        return response()->json(['success' => 'Publicado !!!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        return response()->json($publicacion, 200);    
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
        $rules = [
            'descripcion' => 'required'
        ];

        $this->validate($request, $rules);
        
        $publicar = Publicacion::findOrFail($id);
        $publicar->descripcion = $request->descripcion;
        $publicar->idprofesor = Auth::user()->id;
        $publicar->save();

        return response()->json(['success' => 'Publicación modificada !!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $publicacion->delete();
        return response()->json(['success' => 'Se ha borrado esta publicación'], 200);
    }
}
