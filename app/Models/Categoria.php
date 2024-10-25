<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Colaborador
 * @package App\Models
 * @property integer id
 * @property string nome
 * @property integer ativo
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'ativo',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];
}
