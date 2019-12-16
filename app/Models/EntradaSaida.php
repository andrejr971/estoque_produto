<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaSaida extends Model
{
    public function estoque() {
        return $this->belongsTo('App\Models\Estoque_geral', 'estoque_geral_id', 'id');
    }

    public function fornecedores() {
        return $this->belongsTo('App\Models\Fornecedor', 'fornecedor_id', 'id')
                    ->select('id', 'nome', 'cnpj');
    }

    public function tipo_estoque() {
        return $this->belongsTo('App\Models\tipo_estoque', 'tipo_estoque_id', 'id')
                    ->select('id', 'descricao');
    }

}
