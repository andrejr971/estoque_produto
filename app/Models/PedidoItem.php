<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    protected $fillable = [
        'pedido_estoque_id',
        'estoque_geral_id',
        'qtd',
        'valor',
        'status'
    ];

    public function pedido_item_estoque() {
        return $this->belongsTo('App\Models\Estoque_geral', 'estoque_geral_id', 'id');
    }
}
