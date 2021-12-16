<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    public $timestamps = false;

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

    public function filiais()
    {
        return $this->hasMany(MatrizFilial::class, 'cliente', 'id');

    }
}
