<?php

namespace App\Http\Controllers;

use App\Mail\notifyOperatorNewSearch;
use App\Pesquisa;
use App\User;
use App\UsuarioMatrizFilial;
use App\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $teste = array(
            'email' => $request->email,
            'password' => $request->token_api
        );


        if (!$token = auth('api')->attempt($teste)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        $user = auth('api')->user();

        $data = [
            "name"  => $user->name,
            "client_id"  => $user->cliente_id,
            "client_name"  => $user->clienteObj->nome,
            "email"  => $user->email,
        ];


        return response()->json($data);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function teste()
    {
        $user = UsuarioSistema::find(8);
        $search = Pesquisa::find(49122);


        Mail::send(new notifyOperatorNewSearch($user, $search));
    }

}
