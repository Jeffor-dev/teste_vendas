<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'preco', 'user_id', 'venda_id'];
    protected $table = 'produtos';
    protected $primaryKey = 'id';

    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'produto_venda', 'produto_id', 'venda_id');
    }
}
