<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class tipo_estoque extends Model
{
    public function estoque()
    {
        return $this->BelongsToMany('App\Models\Estoque_geral', 'estoques')
                ->select(['id', 'descricao', 'qtd', 'preco', 'estante', 'cod_item', 'un_medida']);
    }
}
