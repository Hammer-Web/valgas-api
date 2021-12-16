<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioMatrizFilial extends Model
{
    protected $table = 'clientes_usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'matriz_filial',
        'email',
        'nome',
        'cargo',
        'telefone',
    ];

    public function matrizFilialObj()
    {
        return $this->belongsTo(MatrizFilial::class, 'matriz_filial', 'id');
    }
}
