<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizFilial extends Model
{
    protected $table = 'matriz_filial';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cliente',
        'tipo',
        'cnpj',
        'nome',
        'email',
        'telefone',
        'responsavel',
        'status',
        'deleted'
    ];

    public function clienteOb()
    {
        $cliente = Cliente::find($this->cliente);

        return $cliente;
    }

    public function usuariosFiliasOBJ()
    {
        $users = UsuarioMatrizFilial::where('matriz_filial', $this->id)->where('deleted', 0)->get();

        return $users;
    }

}
