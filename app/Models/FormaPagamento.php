<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $fillable = ['nome', 'user_id'];
    protected $table = 'formas_pagamento';
    protected $primaryKey = 'id';

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
