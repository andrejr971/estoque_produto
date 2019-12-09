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

    public function entrada_saidaE() {
        return $this->belongsToMany('App\Models\Fornecedor', 'entrada_saidas', 'estoque_geral_id', 'id');
    }

    public function estoque()
    {
        return $this->BelongsToMany('App\Models\tipo_estoque', 'estoques')
                ->select('id', 'descricao', 'nota');
    }
}
