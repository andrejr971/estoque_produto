<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    public function grupo_produto() {
        return $this->hasMany('App\Models\Produto', 'grupo_produto_id', 'id');
    }
}
