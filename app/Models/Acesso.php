<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Acesso
 * @package App\Models
 * @property integer id
 * @property string acesso
 * @property integer ativo
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */
class Acesso extends Model
{
    use HasFactory;

    protected $table = 'acessos';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'acesso',
        'ativo',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];

    public function perfis()
    {
        return $this->hasMany(Perfil::class, 'acesso_id');
    }
}
