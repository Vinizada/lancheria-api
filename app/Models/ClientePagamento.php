<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class ClientePagamento
 * @package App\Models
 * @property integer cliente_id 
 * @property integer metodo_id */ 
class ClientePagamento extends Model
{
    use HasFactory;

    protected $table = 'cliente_pagamento';

    protected $fillable = [
        'cliente_id',
        'metodo_id',
    ];
}
