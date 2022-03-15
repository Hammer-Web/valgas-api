<?php

namespace App\Http\Controllers\Auxiliar;

use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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


    public function padroesDePequisas()
    {
        $client_id = $user = auth('api')->user()->cliente_id;

        $padroes = DB::select("SELECT id, titulo FROM tipo_pesquisa WHERE cliente = $client_id ");

        if ($padroes == null){

            $dados = array(
                'erro' => array(
                    'msg' => 'Nenhum padrão de pesquisa cadastrado!'
                )
            );

            return response()->json($dados, 203);

        }

        return response()->json($padroes);

    }




}
