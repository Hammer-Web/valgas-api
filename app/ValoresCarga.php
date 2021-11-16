<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValoresCarga extends Model
{
    protected $table = 'score_valores_carga';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'valor',
        'pontos',
        'deleted',
        'preco',
        'tipo_motorista',
    ];
}
