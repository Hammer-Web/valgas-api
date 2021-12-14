<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'status',
        'cpf_motorista',
        'data_vencimento_cnh',
        'cavalo_cpf_cnpj_proprietario',
        'cavalo_placa',
        'carreta_1_cpf_cnpj_proprietario',
        'carreta_1_placa',
        'carreta_2_cpf_cnpj_proprietario',
        'carreta_2_placa',
        'carreta_3_cpf_cnpj_proprietario',
        'carreta_3_placa',
        'origem_carga',
        'destino_carga',
        'tipo_mercadoria',
        'valor',
        'data',
        'usuario',
        'matriz_filial',
        'data_cancelamento',
        'data_autorizacao',
        'origem_cidade_carga',
        'origem_estado_carga',
        'origem_cep_carga',
        'destino_cidade_carga',
        'destino_estado_carga',
        'destino_cep_carga',
        'solicitante_nome',
        'protocolo',
        'pesquisa_reutilizada',
        'validade',
        's3',
        's3_keyname',
    ];
}
