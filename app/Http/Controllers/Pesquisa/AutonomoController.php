<?php

namespace App\Http\Controllers\Pesquisa;

use App\Cliente;
use App\Consulta;
use App\Fatura;
use App\Http\Controllers\Auxiliar\UsuarioController;
use App\Http\Controllers\Controller;
use App\Pesquisa;
use App\PesquisaCavalo;
use App\Support\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;

class AutonomoController extends Controller
{
    public function create(Request $request)
    {
        if (empty($request->consulta)) {

            $dados = array(
                'erro' => array(
                    'msg' => 'O campo consulta é obrigatório!'
                )
            );

            return response()->json($dados, 203);
        }

        $consultaObj = Consulta::find($request->consulta);

        if ($consultaObj == null) {
            $dados = array(
                'erro' => array(
                    'msg' => 'Consulta não encontrada!'
                )
            );

            return response()->json($dados, 203);
        }

        $uarios = new UsuarioController();
        $meusUsuarios = $uarios->meusUsuariosID();

        if (!in_array($consultaObj->usuario, $meusUsuarios)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Sem permissão para trabalhar com essa consulta'
            ], 203);
        }

        $tipoPesquisaPrecoId = DB::select(" SELECT * FROM tipo_pesquisa where cliente = :cliente order by valor desc LIMIT 1 ", [
            'cliente' => Auth::user()->cliente_id
        ]);

        if (empty($tipoPesquisaPrecoId)) {

            $dados = array(
                'erro' => array(
                    'msg' => 'Valores para tipo de pesquisa não definido, contate o administrador!'
                )
            );

            return response()->json($dados, 203);
        }

        $cliente = Cliente::find(Auth::user()->cliente_id);


        $createFixos = array(
            'api' => 1,
            'status' => 1,
            'consulta' => $consultaObj->id,
            'padrao_pesquisa_preco' => $tipoPesquisaPrecoId[0]->id,
            'tipo' => 1,
            'empresa' => $cliente->nome,
            'cliente_id' => Auth::user()->cliente_id,
            'matriz_filial_id' => $consultaObj->matrizFilialObj->id,
            'matriz_filial_nome' => $consultaObj->matrizFilialObj->nome,
            'matriz_filial_telefone' => $consultaObj->matrizFilialObj->telefone,
            'telefone_retorno' => $consultaObj->usuarioClienteMatrizObj->telefone,
            'email_retorno' => $consultaObj->usuarioClienteMatrizObj->email,
            'data_pesquisa' => time()
        );

        $createRequest = array(
            'solicitante_usuario_id' => $consultaObj->usuario,
            'funcao' => $request->funcao,
            'email_retorno2' => $request->email_retorno2,
            'funcao' => $request->funcao,
            'cpf' => $request->cpf,
            'nome_completo' => $request->nome_completo,
            'data_nascimento' => $request->data_nascimento,

            'rg' => $request->rg,
            'rg_data_emissao' => $request->rg_data_emissao,
            'rg_estado' => $request->rg_estado,

            'cnh' => $request->cnh,
            'cnh_categoria' => $request->cnh_categoria,
            'cnh_vencimento' => $request->cnh_vencimento,
            'cnh_orgao_emissor' => $request->cnh_orgao_emissor,
            'cnh_cidade' => $request->cnh_cidade,
            'cnh_estado' => $request->cnh_estado,
            'cnh_primeira_habilitacao' => $request->cnh_primeira_habilitacao,

            'pai' => $request->pai,
            'mae' => $request->mae,

            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,

            'telefone_residencial' => $request->telefone_residencial,
            'telefone_residencial_contato' => $request->telefone_residencial_contato,

            'telefone_comercial' => $request->telefone_comercial,
            'telefone_comercial_contato' => $request->telefone_comercial_contato,

            'telefone_referencia' => $request->telefone_referencia,
            'telefone_referencia_contato' => $request->telefone_referencia_contato,

        );

        $createRequest['rg_data_emissao'] = strtotime(str_replace('/', '-', $createRequest['rg_data_emissao']));
        $createRequest['cnh_vencimento'] = strtotime(str_replace('/', '-', $createRequest['cnh_vencimento']));
        $createRequest['cnh_primeira_habilitacao'] = strtotime(str_replace('/', '-', $createRequest['cnh_primeira_habilitacao']));
        $createRequest['data_nascimento'] = strtotime(str_replace('/', '-', $createRequest['data_nascimento']));

        $create = array_merge($createFixos, $createRequest);

        $pesquisa = Pesquisa::create($create);

        $setFaturaArray = array(
            'api' => 1,
            'usuario' => $consultaObj->usuario,
            'matriz_filial' => $consultaObj->matrizFilialObj->id,
            'data' => time(),
            'tipo' => 'pesquisa',
            'valor' => $tipoPesquisaPrecoId[0]->valor,
            'id_consulta_pesquisa' => $pesquisa->id
        );

        $newFatura = Fatura::create($setFaturaArray);

        $dados = array(
            'msg' => 'Pesquisa gerada com sucesso',
            'pesquisa' => $pesquisa->id
        );

        return response()->json($dados, 200);


    }

    public function vehicle(Request $request)
    {
        $modelo = $request->modelo;
        $marca = $request->marca;

        $queryModelo = DB::select(" SELECT * FROM modelos_veiculos WHERE id = $modelo");
        $queryMarca = DB::select(" SELECT * FROM marcas_montadoras WHERE id = $marca");

        if (empty($queryModelo)) {
            $dados = array(
                'erro' => array(
                    'msg' => 'ID de modelo de veículo inválido!'
                )
            );

            return response()->json($dados, 203);
        }

        if (empty($queryMarca)) {
            $dados = array(
                'erro' => array(
                    'msg' => 'ID de marca de veículo inválido!'
                )
            );

            return response()->json($dados, 203);
        }

        $placa = Helper::formatarPlaca($request->placa);

        $isPes = Pesquisa::where('id', $request->pesquisa)->first();

        if ($isPes == null){

            $dados = array(
                'erro' => array(
                    'msg' => 'Pesquisa não encontrada!'
                )
            );

            return response()->json($dados, 204);
        }


        if ($isPes->cliente_id != Auth::user()->cliente_id){
            $dados = array(
                'erro' => array(
                    'msg' => 'A pesquisa informada não pertece ao seu usuário!'
                )
            );

            return response()->json($dados, 203);
        }

        $isDadosVeiculoPesquisa = PesquisaCavalo::where('pesquisa', $request->pesquisa)->get();

        if (!empty($isDadosVeiculoPesquisa)){

            $dados = array(
                'erro' => array(
                    'msg' => 'A pesquisa informada já possui veículo atribuído!'
                )
            );

            return response()->json($dados, 203);
        }


        $pesquisaCavalo = PesquisaCavalo::create([
            'pesquisa' => $request->pesquisa,
            'cavalo_nome_proprietario' => $request->nome_proprietario,
            'cavalo_rntc_proprietario' => $request->_rntc_proprietario,
            'cavalo_cpf_cnpj_proprietario' => $request->cpf_cnpj_proprietario,
            'cavalo_cep_proprietario' => $request->cep_proprietario,
            'cavalo_placa' => $request->placa,
            'cavalo_cidade_emplacamento' => $request->cidade_emplacamento,
            'cavalo_estado_emplacamento' => $request->estado_emplacamento,
            'cavalo_renavam' => $request->renavam,
            'cavalo_marca' => $request->marca,
            'cavalo_modelo' => $request->modelo,
            'cavalo_chassi' => $request->chassi,
            'cavalo_ano' => $request->ano,
            'cavalo_cor' => $request->cor,
            'cavalo_telefone_residencial_proprietario' => $request->telefone_residencial_proprietario,
            'cavalo_telefone_residencial_contato_proprietario' => $request->telefone_residencial_contato_proprietario,
            'cavalo_telefone_comercial_proprietario' => $request->telefone_comercial_proprietario,
            'cavalo_telefone_comercial_contato_proprietario' => $request->telefone_comercial_contato_proprietario,
            'cavalo_logradouro_proprietario' => $request->logradouro_proprietario,
            'cavalo_numero_proprietario' => $request->numero_proprietario,
            'cavalo_complemento_proprietario' => $request->complemento_proprietario,
            'cavalo_bairro_proprietario' => $request->bairro_proprietario,
            'cavalo_cidade_proprietario' => $request->cidade_proprietario,
            'cavalo_estado_proprietario' => $request->estado_proprietario,
            'cavalo_rnt' => $request->rnt,
        ]);

        $dados = array(
            'msg' => 'Dados de veículos vinculados à pesquisa!'
        );

        return response()->json($dados, 200);


    }
}
