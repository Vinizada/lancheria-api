<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Cliente
 * @package App\Models
 * @property integer id
 * @property integer cliente_id
 * @property integer pedido_id
 * @property float valor
 * @property string tipo_operacao
 * @property float valor_disponivel
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */
class ContaCliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cliente_id',
        'pedido_id',
        'valor',
        'tipo_operacao',
        'valor_disponivel',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];
}
