<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentosPesquisa extends Model
{
    protected $table = 'pesquisa_documentos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'pesquisa',
        'motorista_habilitacao',
        'motorista_comprovante_residencia',
        'cavalo_renavam',
        'carreta_1_renavam',
        'carreta_2_renavam',
        'carreta_3_renavam',
        'habilitacao_s3',
        'habilitacao_s3_keyname',
        'comprovante_s3',
        'comprovante_s3_keyname',
        'cavalo_renavam_s3',
        'cavalo_renavam_s3_keyname',
        'carreta_1_renavam_s3',
        'carreta_1_renavam_s3_keyname',
        'carreta_2_renavam_s3',
        'carreta_2_renavam_s3_keyname',
        'carreta_3_renavam_s3',
        'carreta_3_renavam_s3_keyname',
    ];
}
