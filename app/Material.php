<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiais';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'titulo',
        'deleted',
    ];
}
