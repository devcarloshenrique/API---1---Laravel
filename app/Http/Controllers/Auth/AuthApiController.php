<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthApiController extends Controller
{
    public function authenticate(Request $request)
    {
        // Pegando email e senha da request
        $credentials = $request->only('email', 'password');

        try {
            // Apartir do email e senha é feita a autenticação via jwt, armazenando o retorno no token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // Em caso de erro
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function refreshToken()
    {
        // Faz a validação do token
        if (!$token = JWTAuth::getToken())
            return response()->json(['error' => 'token_not_send'], 401);

        try {
            // Após a valuidação é realizado o refresh do token
            $token = JWTAuth::refresh();
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }

        // Devolve o token atualizado
        return response()->json(compact('token'));
    }
}
