<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesquisaCavalo extends Model
{
    protected $table = 'pesquisa_cavalo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'pesquisa',
        'cavalo_nome_proprietario',
        'cavalo_rntc_proprietario',
        'cavalo_cpf_cnpj_proprietario',
        'cavalo_cep_proprietario',
        'cavalo_placa',
        'cavalo_cidade_emplacamento',
        'cavalo_estado_emplacamento',
        'cavalo_renavam',
        'cavalo_marca',
        'cavalo_modelo',
        'cavalo_chassi',
        'cavalo_ano',
        'cavalo_cor',
        'cavalo_telefone_residencial_proprietario',
        'cavalo_telefone_residencial_contato_proprietario',
        'cavalo_telefone_comercial_proprietario',
        'cavalo_telefone_comercial_contato_proprietario',
        'cavalo_logradouro_proprietario',
        'cavalo_numero_proprietario',
        'cavalo_complemento_proprietario',
        'cavalo_bairro_proprietario',
        'cavalo_cidade_proprietario',
        'cavalo_estado_proprietario',
        'cavalo_rntrc'
    ];

    public function pesquisaObj()
    {
        return $this->belongsTo(Pesquisa::class, 'pesquisa', 'id', '');
    }
}
