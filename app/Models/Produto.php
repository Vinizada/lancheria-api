<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Produto
 * @package App\Models
 * @property integer id
 * @property string nome
 * @property float preco_venda
 * @property float preco_custo
 * @property integer fornecedor_id
 * @property integer estoque_minimo
 * @property float giro_medio
 * @property integer ativo
 * @property integer categoria_id
 * @property boolean vende_sem_estoque
 * @property Carbon data_criacao
 * @property Carbon data_atualizacao */
class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    const CREATED_AT = 'data_criacao';

    const UPDATED_AT = 'data_alteracao';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'preco_venda',
        'preco_custo',
        'fornecedor_id',
        'estoque_minimo',
        'giro_medio',
        'ativo',
        'categoria_id',
        'vende_sem_estoque',
    ];

    protected $dates = [
        'data_criacao',
        'data_alteracao',
        'data_validade',
    ];

    public function fornecedor()
    {
        $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function estoque()
    {
        $this->hasMany(Estoque::class, 'produto_id');
    }
}
