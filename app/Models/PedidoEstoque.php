<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoEstoque extends Model
{
    protected $fillable = [
        'fornecedor_id',
        'status'
    ];

    public function pedido_item() {
        return $this->hasMany('App\Models\PedidoItem')
            /*->select(\DB::raw('estoque_geral_id, count(1) as qtd, sum(valor) as valores'))
            ->groupBy('estoque_geral_id')
            ->orderBy('estoque_geral_id', 'desc')*/;
    }

    public function fornecedor() {
        return $this->belongsTo('App\Models\Fornecedor', 'fornecedor_id', 'id');
    }

    public function consultaId($where) {
        $pedido = PedidoEstoque::where($where)->first(['id']);
        return !empty($pedido->id) ? $pedido->id : null;
    }
}
