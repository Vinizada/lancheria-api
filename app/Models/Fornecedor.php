<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Fornecedor
 * @package App\Models
 * @property integer id
 * @property string nome
 * @property string celular
 * @property string cnpj
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */ 
class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'email',
        'celular',
        'cnpj',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];

    public function produtos()
    {
        $this->hasMany(Produto::class, 'fornecedor_id');
    }
}
