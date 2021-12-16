<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $table = 'faturas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
      'id',
      'api',
      'usuario',
      'matriz_filial',
      'data',
      'tipo',
      'valor',
      'id_consulta_pesquisa',
    ];

    public function matrizFilialObj()
    {
        return $this->belongsTo(MatrizFilial::class, 'matriz_filial', 'id');
    }

    public function usuarioClienteMatrizObj()
    {
        return $this->belongsTo(UsuarioMatrizFilial::class, 'usuario', 'id');
    }
}
