<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilAcesso
 * @package App\Models
 * @property integer perfil_id
 * @property integer acesso_id */
class PerfilAcesso extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $table = 'perfil_acessos';

    protected $fillable = [
      'perfil_id',
      'acesso_id',
    ];
}
