<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class MetodoPagamento
 * @package App\Models
 * @property integer id
 * @property float limite_metodo
 * @property integer ativo
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */  
class MetodoPagamento extends Model
{
    use HasFactory;

    protected $table = 'metodos_pagamento';

    protected $primaryKey = 'id';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $fillable = [
        'metodo',
        'limite_metodo',
        'ativo',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];
}
