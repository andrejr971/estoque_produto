<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoProduto extends Model
{
    public function categoria() {
        return $this->hasMany('App\Models\CategoriaProduto', 'grupo_produto_id', 'id');
    }
}
