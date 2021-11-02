<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'cnpj_matriz',
        'status',
        'deleted',
        'preco_consulta',
        'preco_pesquisa',
        'permitir_criacao_cliente',
        'criador',
    ];
}
