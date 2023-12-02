<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Estoque
 * @package App\Models
 * @property integer produto_id 
 * @property integer quantidade
 * @property Carbon  data_validade */ 
class Estoque extends Model
{
    use HasFactory;

    protected $table = 'estoque';

    protected $fillable = [
        'produto_id',
        'quantidade',
    ];

    protected $dates = [
        'data_validade',
    ];
}
