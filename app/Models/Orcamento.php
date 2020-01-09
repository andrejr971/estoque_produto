<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    public function produto() {
        return $this->hasMany('App\Models\Produto', 'orcamento_id', 'id');
    }
}
