<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function categoria() {
        return $this->belongsTo('App\Models\CategoriaProduto', 'categoria_produto_id', 'id');
    }

    public function tipo_produto() {
        return $this->belongsTo('App\Models\TipoProduto', 'tipo_produto_id', 'id');
    }

    public function orcamento() {
        return $this->belongsTo('App\Models\Orcamento', 'orcamento_id', 'id');
    }

    public function estoque() {
        return $this->belongsTo('App\Models\Estoque_geral')->select('descricao');
    }

    public function medidas() {
        return $this->hasMany('App\Models\MedidaProduto');
    }
}
