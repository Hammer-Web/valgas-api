<?php

namespace App\Http\Controllers\Auxiliar;

use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UsuarioController extends Controller
{
    public function meusUsuarios()
    {
        $user = auth('api')->user();

        $usuariosJSON = array();

        $cliente = Cliente::find($user->cliente_id);

        if ($cliente->filiais() != null) {

            foreach ($cliente->filiais as $filial) {

                foreach ($filial->usuariosFiliasOBJ as $usuario) {
                    $data = array(
                        'id' => $usuario->id,
                        'email' => $usuario->email,
                        'nome' => $usuario->nome,
                        'matriz_filial_id' => $usuario->matriz_filial,
                        'matriz_filial_nome' => $usuario->matrizFilialObj->nome,
                        'matriz_filial_cnpj' => $usuario->matrizFilialObj->cnpj,
                    );

                    array_push($usuariosJSON, $data);
                }
            }

            return response()->json($usuariosJSON);

        }
    }


    public function meusUsuariosID()
    {
        $user = auth('api')->user();

        $usuariosJSON = array();

        $cliente = Cliente::find($user->cliente_id);



        if ($cliente->filiais() != null) {

            foreach ($cliente->filiais as $filial) {

                foreach ($filial->usuariosFiliasOBJ as $usuario) {
                    array_push($usuariosJSON, $usuario->id);
                }
            }

            return $usuariosJSON;

        }
    }




}
