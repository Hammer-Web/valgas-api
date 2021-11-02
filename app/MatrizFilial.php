<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizFilial extends Model
{
    protected $table = 'matriz_filial';

    protected $fillable = [
      'id',
      'cliente',
      'tipo',
      'cnpj',
      'nome',
      'email',
      'responsavel',
      'status',
      'deleted'
    ];

    public function clienteOb()
    {
        $cliente = Cliente::find($this->cliente);

        return $cliente;
    }

}
