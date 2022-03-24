<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusPesquisa extends Model
{
    protected $table = 'status_pesquisa';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'titulo',
    ];
}
