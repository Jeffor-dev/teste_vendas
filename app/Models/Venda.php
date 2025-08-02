<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['data_venda', 'valor_total', 'cliente_id', 'user_id'];
    protected $table = 'vendas';
    protected $primaryKey = 'id';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class)->withDefault([
            'id' => 0,
            'nome' => 'não informado'
        ]);
    }

}
