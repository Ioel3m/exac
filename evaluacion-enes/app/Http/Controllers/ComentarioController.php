<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Publicacion;

use App\Comentario;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\QueryException;

class ComentarioController extends Controller
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
        $comments = Comentario::join('users', 'users.id', '=', 'comentarios.idprofesor')
            ->join('publicaciones', 'publicaciones.id', '=', 'comentarios.idpublicacion')
            ->select('publicaciones.id as id_publish','publicaciones.descripcion as publicacion','users.nombres as name_user_comment', 'users.apellidos as lastname_user_comment',
            'comentarios.id as idcomment','comentarios.descripcion as comentario','comentarios.created_at as fecha_comentario_creado', 'comentarios.updated_at as fecha_comentario_editado')
            ->orderBy('comentarios.id','asc')
            ->get();

        return response()->json($comments, 200);   
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
            'idpublicacion' => 'numeric|required',
            'descripcion' => 'required'           
        ];

        $this->validate($request, $rules);

        $comentar = new Comentario();
        $comentar->idprofesor = Auth::user()->id;
        $comentar->idpublicacion = $request->idpublicacion;
        $comentar->descripcion = $request->descripcion;
        $comentar->save();

        return response()->json(['success' => 'Has comentado esta publicación !!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCommentsByPublish($id)
    {
        $comments = Comentario::join('users', 'users.id', '=', 'comentarios.idprofesor')
            ->join('publicaciones', 'publicaciones.id', '=', 'comentarios.idpublicacion')
            ->select('publicaciones.id as id_publish','publicaciones.descripcion as publicacion','users.nombres as name_user_comment', 'users.apellidos as lastname_user_comment',
            'comentarios.id as idcomment','comentarios.descripcion as comentario','comentarios.created_at as fecha_comentario_creado', 'comentarios.updated_at as fecha_comentario_editado')
            ->where('publicaciones.id', '=', $id)
            ->orderBy('comentarios.id','asc')
            ->get();

        return response()->json($comments, 200);   
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
            'idpublicacion' => 'numeric|required',
            'descripcion' => 'required'           
        ];

        $this->validate($request, $rules);

        $comentar = Comentario::findOrFail($id);
        $comentar->idprofesor = Auth::user()->id;
        $comentar->idpublicacion = $request->idpublicacion;
        $comentar->descripcion = $request->descripcion;
        $comentar->save();

        return response()->json(['success' => 'Has actualizado tu comentario de esta publicación !!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->delete();
        return response()->json(['success' => 'El comentario ha sido eliminado !!'], 200);
    }
}
