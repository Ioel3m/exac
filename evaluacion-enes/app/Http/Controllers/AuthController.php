<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }


    public function Autenticar(Request $request){
        $credenciales = $request->only('nickname', 'password');
        $token = null;

        try{
            if (!$token = JWTAuth::attempt($credenciales)) {
                return response()->json(['error' => 'Las credenciales son incorrectas']);
            }
        }catch(JWTException $ex){
            return response()->json(['error' => 'Ha ocurrido un error interno en el servidor'], 500);
        }
        return response()->json(compact('token'));
    }
}
