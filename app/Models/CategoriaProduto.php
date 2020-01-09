<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    public function grupo_produto() {
        return $this->belongsTo('App\Models\GrupoProduto', 'grupo_produto_id', 'id');
    }
}
