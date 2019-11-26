<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class tipo_estoque extends Model
{
    public function estoque()
    {
        return BelongsToMany('App\Models\Estoque_geral', 'estoques');
    }
}
