<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\MatrizFilial;
use App\Support\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function veiculos()
    {
        $queryPes = DB::select(" SELECT * FROM veiculos  ");

        return response()->json($queryPes);

    }

    public function marcas()
    {
        $queryPes = DB::select(" SELECT * FROM marcas_montadoras WHERE id <> 1  ");

        return response()->json($queryPes);
    }

    public function modelos()
    {
        $queryPes = DB::select(" SELECT * FROM modelos_veiculos ");

        return response()->json($queryPes);
    }
}
