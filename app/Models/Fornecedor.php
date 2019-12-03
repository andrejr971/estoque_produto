<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    public function estoque() {
        return $this->belongsToMany('App\Models\Estoque_geral', 'estoques')->withPivot('tipo_estoque_id');
    }
}
