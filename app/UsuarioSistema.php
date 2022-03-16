<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioSistema extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id';

    protected $fillable = [
        'usu_id',
        'usu_nome',
        'usu_email'
    ];
}
