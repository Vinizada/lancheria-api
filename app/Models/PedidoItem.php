<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PedidoItem
 * @package App\Models
 * @property integer id
 * @property integer pedido_id
 * @property integer produto_id
 * @property integer quantidade
 * @property float preco_unitario
 * @property float preco_total */
class PedidoItem extends Model
{
    use HasFactory;

    protected $table = 'pedido_itens';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'preco_total',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id')->getResults();
    }
}
