<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

/**
 * Class Colaborador
 * @package App\Models
 * @property integer id
 * @property integer perfil_id
 * @property string nome
 * @property string email
 * @property string senha
 * @property integer ativo
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao
 */
class Colaborador extends Authenticatable
{
    use HasFactory;

    protected $table = 'colaboradores';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'perfil_id',
        'senha',
        'email',
        'ativo',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];

    /**
     * Retorna a senha para autenticação.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id')->where('ativo', 1);
    }

    public function acessos()
    {
        $pivotTable = app(PerfilAcesso::class)->getTable();
        return $this->belongsToMany(Perfil::class, $pivotTable, 'perfil_id', 'perfil_id');
    }
}
