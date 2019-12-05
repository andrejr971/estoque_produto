<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque_geral extends Model
{
    protected $table = 'estoque_geral';

    public function fornecedores() {
        return $this->belongsToMany('App\Models\Fornecedor', 'estoques')->withPivot('tipo_estoque_id');
    }

    public function pedido_estoque() {
        return $this->belongsTo('App\Models\PedidoItem', 'id', 'estoque_geral_id')
            ->select('id', 'estoque_geral_id', 'qtd');
    }
}
