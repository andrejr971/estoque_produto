<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueProduto extends Model
{
    public function estoque() {
        return $this->belongsTo('\App\Models\Estoque_geral', 'estoque_geral_id', 'id')
                    ->select('id', 'descricao', 'qtd');
    }
}
