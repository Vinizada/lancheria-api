<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Perfil
 * @package App\Models
 * @property integer id
 * @property string perfil
 * @property integer acesso_id
 * @property integer ativo
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */ 
class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfil';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'perfil',
        'acesso_id',
        'ativo',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];
}
