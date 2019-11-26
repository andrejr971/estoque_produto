<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque_geral extends Model
{
    protected $table = 'estoque_geral';

    public function fornecedores() {
        return $this->belongsToMany('App\Models\Fornecedor', 'estoques')->withPivot('tipo_estoque_id');
    }
}
