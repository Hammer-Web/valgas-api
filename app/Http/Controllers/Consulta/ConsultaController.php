<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Auxiliar\UsuarioController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function solicitar(Request $request)
    {
        $hoje = time();

        $uarios = new UsuarioController();
        $meusUsuarios = $uarios->meusUsuariosID();

        if (!in_array($request->usuario, $meusUsuarios)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Usuário informado não pertece ao cliente autenticado na API!'
            ], 403);
        }

        $dadosPes = array(
            'cpf' => $request->cpf_motorista,
            'tipo' => 1,
            'validade' => time(),
            'cliente_id' => auth('api')->user()->cliente_id,
            'hoje' => $hoje
        );

        $queryPes = DB::select(" SELECT * FROM pesquisas_a_t WHERE
                                           cpf = :cpf AND
                                           tipo = :tipo AND
                                           status = 5 AND
                                           cliente_id = :cliente_id AND
                                           validade > :validade AND
                                           cnh_vencimento > :hoje ",
            [
                'cpf' => $request->cpf_motorista,
                'tipo' => 1,
                'validade' => time(),
                'cliente_id' => auth('api')->user()->cliente_id,
                'hoje' => $hoje
            ]);


        $pesquisasValidas = '';

        if ($queryPes != null) {

            foreach ($queryPes as $idPesquisa) {
                $pesquisasValidas .= $idPesquisa->id . ', ';
            }

            $pesquisasValidas = substr($pesquisasValidas, 0, -2);

            // filtrar se das pesquisas alguma bate o cavalo E a placa
            $queryCavalo = DB::select(" SELECT * FROM pesquisa_cavalo WHERE
                                     pesquisa in ($pesquisasValidas) AND
                                        cavalo_placa = :cavalo_placa AND
                                        cavalo_cpf_cnpj_proprietario = :cavalo_cpf_cnpj_proprietario ", [
                'cavalo_placa' => $request->cavalo_placa,
                'cavalo_cpf_cnpj_proprietario' => $request->cavalo_cpf_cnpj_proprietario,
            ]);

            if ($queryCavalo <> null) {

                $pesquisasValidas = '';

                foreach ($queryCavalo as $idPesquisaCavalo) {
                    $pesquisasValidas .= $idPesquisaCavalo->pesquisa . ', ';
                }

                // sao pesquisas concluidas nas regras ate o cavalo
                $pesquisasValidas = substr($pesquisasValidas, 0, -2);

                if ($request->carreta_1_placa != '' && $request->carreta_1_cpf_cnpj_proprietario) {

                    $queryCarreta1 = DB::select(" SELECT * FROM pesquisa_carreta_1 WHERE
                                     pesquisa in ($pesquisasValidas) AND
                                        carreta_1_placa = :carreta_1_placa AND
                                        carreta_1_cpf_cnpj_proprietario = :carreta_1_cpf_cnpj_proprietario ", [
                        'carreta_1_placa' => $request->carreta_1_placa,
                        'carreta_1_cpf_cnpj_proprietario' => $request->carreta_1_cpf_cnpj_proprietario,
                    ]);

                }

                $valor = $request->valor;

                $queryValores = DB::select(" SELECT pesquisa, valor FROM pesquisas_complementares WHERE pesquisa in ($pesquisasValidas)  ");

                if ($queryValores <> null) {

                    $maiorValor = array();

                    foreach ($queryValores as $v) {

                        array_push($maiorValor, $v->valor);
                    }

                    $mai = max($maiorValor);

                    if ($valor <= $mai) {

                        $request->pesquisa_reutilizada = $queryValores[0]->pesquisa;

                        $dados['validade'] = time();

                        //$newConsulta = setConstulaSemPesquisa($dados);
                        //&msg=reutilizada
                    }
                    die('nao');
                }


            }

            // nao retornou pesquisa por cavalo (placa e cpf)
            //return setNovaConstula($dados);

            die('setNovaConstula nao retornou pesquisa por cavalo (placa e cpf) ');


        } else {
            // nao retornou pesquisa por cpf
            //  setNovaConstula($dados);


            die(' nao retornou pesquisa por cpf ');
        }

    }
}
