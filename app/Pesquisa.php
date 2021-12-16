<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesquisa extends Model
{
    protected $table = 'pesquisas_a_t';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'api',
        'consulta',
        'status',
        'tipo',
        'funcao',
        'cpf',
        'empresa',
        'cliente_id',
        'solicitante_usuario_id',
        'matriz_filial_nome',
        'matriz_filial_telefone',
        'telefone_retorno',
        'email_retorno',
        'data_pesquisa',
        'operador_analise',
        'data_analise',
        'nome_completo',
        'data_nascimento',
        'rntc',
        'rg',
        'rg_data_emissao',
        'rg_estado',
        'cnh',
        'cnh_categoria',
        'cnh_vencimento',
        'cnh_orgao_emissor',
        'pesquisas_a_tcol',
        'cnh_cidade',
        'cnh_estado',
        'cnh_primeira_habilitacao',
        'pai',
        'mae',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'telefone_residencial',
        'telefone_residencial_contato',
        'telefone_comercial',
        'telefone_comercial_contato',
        'telefone_referencia',
        'telefone_referencia_contato',
        'telefone_referencia1',
        'telefone_referencia_contato1',
        'matriz_filial_id',
        'protocolo',
        'validade',
        'renovada',
        'new_pesquisa_renovada',
        'padrao_pesquisa_preco',
        'email_retorno2',
        'vinculo_cliente',
        'autorizacao_s3',
        'autorizacao_s3_keyname',
    ];
}
