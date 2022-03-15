<?php

namespace App\Http\Controllers\Pesquisa;

use App\Cliente;
use App\Fatura;
use App\Http\Controllers\Auxiliar\UsuarioController;
use App\Http\Controllers\Controller;
use App\Pesquisa;
use App\User;
use App\UsuarioMatrizFilial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RHController extends Controller
{
    public function create(Request $request)
    {
        $usuarios = new UsuarioController();
        $meusUsuarios = $usuarios->meusUsuariosID();

        if (!in_array($request->usuario, $meusUsuarios)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Usuário informado não pertece ao cliente autenticado na API!'
            ], 403);
        }

        $cliente = Auth::user('api')->cliente_id;
        $padroes = DB::select(" SELECT id FROM tipo_pesquisa where cliente = $cliente ");
        $permitidos = array();

        if ($padroes){
            foreach ($padroes as $pa){
                array_push($permitidos, $pa->id);
            }
        }


        if (!in_array($request->padrao_pesquisa, $permitidos)){

            $dados = array(
                'erro' => array(
                    'msg' => 'Padrão de pesquisa [padrao_pesquisa] inválido! Consulte a endpoit auxiliar PADRÃO DE PESQUISA'
                )
            );

            return response()->json($dados, 203);
        }

        $cliente = Cliente::find(Auth::user()->cliente_id);
        $usuario = UsuarioMatrizFilial::find($request->usuario);

        $createFixos = array(
            'api' => 1,
            'tipo' => 2,
            'status' => 1,
            'padrao_pesquisa_preco' => $request->padrao_pesquisa,
            'empresa' => $cliente->nome,
            'cliente_id' => Auth::user()->cliente_id,
            'matriz_filial_id' => $usuario->matrizFilialObj->id,
            'matriz_filial_nome' => $usuario->matrizFilialObj->nome,
            'matriz_filial_telefone' => $usuario->matrizFilialObj->telefone,
            'telefone_retorno' => $usuario->telefone,
            'email_retorno' => $usuario->email,
            'data_pesquisa' => time()
        );

        $createRequest = array(
            'solicitante_usuario_id' => $request->usuario,
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
            'usuario' => $request->usuario,
            'matriz_filial' => $usuario->matrizFilialObj->id,
            'data' => time(),
            'tipo' => 'pesquisa',
            'valor' => $request->padrao_pesquisa,
            'id_consulta_pesquisa' => $pesquisa->id
        );

        $newFatura = Fatura::create($setFaturaArray);

        $dados = array(
            'msg' => 'Pesquisa gerada com sucesso',
            'pesquisa' => $pesquisa->id
        );

        return response()->json($dados, 200);
    }
}
