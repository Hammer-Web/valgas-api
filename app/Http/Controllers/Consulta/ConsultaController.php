<?php

namespace App\Http\Controllers\Consulta;

use App\Consulta;
use App\Http\Controllers\Auxiliar\UsuarioController;
use App\Http\Controllers\Controller;
use App\UsuarioMatrizFilial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;

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

        $ar = array('cpf' => $request->cpf_motorista,
            'tipo' => 1,
            'validade' => time(),
            'cliente_id' => auth('api')->user()->cliente_id,
            'hoje' => $hoje);


        $pesquisasValidas = '';

        $usuarioMatriz = UsuarioMatrizFilial::find($request->usuario);

        $ar = array(
            'status' => 1,
            'cpf_motorista' => $request->cpf_motorista,
            'cavalo_placa' => $request->cavalo_placa,
            'cavalo_cpf_cnpj_proprietario' => $request->cavalo_cpf_cnpj_proprietario,
            'carreta_1_placa' => $request->carreta_1_placa ,
            'carreta_1_cpf_cnpj_proprietario' => $request->carreta_1_cpf_cnpj_proprietario ,
            'carreta_2_placa_carreta' => $request->carreta_2_placa_carreta ,
            'carreta_2_cpf_cnpj_proprietario' => $request->carreta_2_cpf_cnpj_proprietario ,
            'carreta_3_placa' => $request->carreta_3_placa ,
            'carreta_3_cpf_cnpj_proprietario' => $request->carreta_3_cpf_cnpj_proprietario ,
            'origem_cep_carga' => $request->origem_cep_carga ,
            'origem_cidade_carga' => $request->origem_cidade_carga ,
            'origem_estado_carga' => $request->origem_estado_carga ,
            'destino_cep_carga' => $request->destino_cep_carga ,
            'destino_cidade_carga' => $request->destino_cidade_carga ,
            'destino_estado_carga' => $request->destino_estado_carga ,
            'tipo_mercadoria' => $request->tipo_mercadoria ,
            'valor' => $request->valor ,
            'data' => time() ,
            'usuario' => $usuarioMatriz->id ,
            'matriz_filial' => $usuarioMatriz->matrizFilialObj->id ,
        );

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

                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS
                    //CONTINUAR REGRA DE CARRETAS

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

                        $newConsulta = Consulta::create($ar);
                        $newConsulta->timestamps = false;

                        $msg = array(
                            'message' => 'Consulta realizada com sucesso',
                            'consulta' => $newConsulta->id
                        );

                        return response()->json($msg, '200');
                    }
                }


            }

            // nao retornou pesquisa por cavalo (placa e cpf) e VALOR DE CARGA
            $newConsulta = Consulta::create($ar);
            $newConsulta->timestamps = false;

            $msg = array(
                'message' => 'Consulta realizada com sucesso',
                'consulta' => $newConsulta->id
            );

            return response()->json($msg, '200');





        } else {
            // nao retornou pesquisa por cpf
            //  setNovaConstula($dados);


            $newConsulta = Consulta::create($ar);
            $newConsulta->timestamps = false;

            $msg = array(
                'message' => 'Consulta realizada com sucesso',
                'consulta' => $newConsulta->id
            );

            return response()->json($msg, '200');
        }

    }

    public function setConsultaSemPesquisa($dados){

    }

}
