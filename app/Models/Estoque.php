<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Estoque
 * @package App\Models
 * @property integer produto_id
 * @property integer quantidade
 * @property Carbon  data_validade
 * @property Carbon  data_criacao
 * @property Carbon  data_alteracao
 */
class Estoque extends Model
{
    use HasFactory;

    protected $primaryKey = 'produto_id';

    protected $table = 'estoque';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $fillable = [
        'produto_id',
        'quantidade',
        'data_validade',
    ];

    protected $dates = [
        'data_validade',
        'data_criacao',
        'data_alteracao',
    ];
}
