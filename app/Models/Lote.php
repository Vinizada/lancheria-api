<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Fornecedor
 * @package App\Models
 * @property integer id
 * @property integer movimentacao_id
 * @property integer produto_id
 * @property Carbon data_validade
 * @property boolean promocao
 * @property float valor_promocional */
class Lote extends Model
{
    use HasFactory;

    protected $table = 'lote';

    protected $primaryKey = 'id';
    const UPDATED_AT = 'data_alteracao';
    const CREATED_AT = 'data_criacao';

    protected $fillable = [
        'movimentacao_id',
        'produto_id',
        'data_validade',
        'promocao',
        'valor_promocional'
    ];

    protected $dates = [
        'data_validade',
    ];
}
