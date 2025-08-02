<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nome', 'cpf', 'user_id'];
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

}
