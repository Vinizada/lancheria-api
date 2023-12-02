<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Pedido
 * @package App\Models
 * @property integer id
 * @property integer cliente_id
 * @property integer metodo_id
 * @property integer colaborador_id
 * @property float valor_total
 * @property string status
 * @property integer quantidade_itens
 * @property integer cancelado
 * @property Carbon data
 * @property Carbon data_cancelamento */  

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    const CREATED_AT = 'data';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cliente_id',
        'metodo_id',
        'valor_total',
        'status',
        'quantidade_itens',
        'colaborador_id',
        'cancelado',
    ];

    protected $dates = [
        'data',
        'data_cancelamento',
    ];

    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'pedido_id');
    }

    public function produtos()
    {
        $pivotTable = app(ItemPedido::class)->getTable();
        return $this->belongsToMany(Produto::class, $pivotTable, 'pedido_id', 'produto_id')
            ->withPivot('quantidade');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function metodoPagamento()
    {
        return $this->belongsTo(MetodoPagamento::class, 'metodo_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id');
    }
}
