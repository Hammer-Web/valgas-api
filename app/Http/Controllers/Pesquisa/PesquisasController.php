<?php

namespace App\Http\Controllers\Pesquisa;

use App\Http\Controllers\Controller;
use App\Pesquisa;
use App\StatusPesquisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesquisasController extends Controller
{
    public function pesquisa(Request $request)
    {
        $isPes = Pesquisa::where('id', $request->id)->first();

        if ($isPes == null) {

            $dados = array(
                'erro' => array(
                    'msg' => ' Pesquisa não encontrada!'
                )
            );

            return response()->json($dados, 203);
        }

        if ($isPes->cliente_id != Auth::user()->cliente_id) {

            $dados = array(
                'erro' => array(
                    'msg' => 'A pesquisa informada não pertece ao seu usuário!'
                )
            );

            return response()->json($dados, 203);
        }

        $status = StatusPesquisa::find($isPes->status);

        $dados = array(
            'pesquisa' => $request->id,
            'status' => $status->titulo,
        );


        if ($status->id == 5 || $status->id == 6 ){
            $dados['documento'] = $isPes->autorizacao_s3;
        }

        return response()->json($dados, 200);


    }
}
