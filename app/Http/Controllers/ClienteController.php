<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\MatrizFilial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::where('deleted', 0)->get([
            'id',
            'nome',
            'cnpj_matriz',
            'preco_consulta',
            'preco_pesquisa',
        ]);;

        if ($clientes == null){
            return response()->json('', 204);
        }

        return response()->json($clientes);
    }

    public function matrizesFiliais()
    {
        $clientePer = Auth::user('api')->clienteObj->id;

        $matrizesFiliais = MatrizFilial::where('deleted', 0)->where('cliente', $clientePer)->get([
            'id',
            'cliente',
            'nome',
            'cnpj',
            'email',
            'responsavel',
        ]);

        if ($matrizesFiliais == null){
            return response()->json('', 204);
        }

        foreach ($matrizesFiliais as $key => $matriz)
        {
            $matrizesFiliais[$key]['cliente_nome'] = ($matriz->clienteOb() != null) ? $matriz->clienteOb()->nome : ' - ';
        }

        return response()->json($matrizesFiliais);
    }
}
