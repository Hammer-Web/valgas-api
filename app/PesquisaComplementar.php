<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesquisaComplementar extends Model
{
    protected $table = 'pesquisas_complementares';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'pesquisa',
        'roubo',
        'acidente',
        'transportou',
        'rastreador',
        'observacoes',
        'valor',
        'descricao_operador',
        'descricao_supervisor',
    ];
}
