<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Cliente
 * @package App\Models
 * @property integer id
 * @property string nome
 * @property string celular
 * @property float limite_credito
 * @property integer ativo
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */  
class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'email',
        'celular',
        'limite_credito',
        'ativo',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
    ];

    public function metodosDePagamento()
    {
        $pivotTable = app(ClientePagamento::class)->getTable();
        return $this->belongsToMany(MetodoPagamento::class, $pivotTable, 'cliente_id', 'metodo_id');
    }
}
