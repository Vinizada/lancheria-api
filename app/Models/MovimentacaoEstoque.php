<?php

namespace App\Models;

use App\Constants\TipoMovimentacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class MovimentacaoEstoque
 * @package App\Models
 * @property integer id
 * @property integer produto_id
 * @property integer pedido_id
 * @property integer cliente_id
 * @property integer colaborador_id
 * @property integer quantidade
 * @property float valor_total
 * @property float valor_unitario
 * @property string tipo_movimentacao
 * @property Carbon data_movimentacao */
class MovimentacaoEstoque extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $table = 'movimentacao_estoque';

    protected $fillable = [
        'produto_id',
        'pedido_id',
        'colaborador_id',
        'data_movimentacao',
        'cliente_id',
        'quantidade',
        'valor_total',
        'valor_unitario',
        'tipo_movimentacao',
    ];

    protected $dates = [
        'data_movimentacao'
    ];

    public function isAjuste()
    {
        return $this->tipo_movimentacao == TipoMovimentacao::AJUSTE;
    }

    public function isEntrada()
    {
        return $this->tipo_movimentacao == TipoMovimentacao::ENTRADA;
    }

    public function isSaida()
    {
        return $this->tipo_movimentacao == TipoMovimentacao::SAIDA;
    }
}
