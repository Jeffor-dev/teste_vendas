<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function cadastrarProduto( Request $request )
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|decimal:0,2',
        ]);

        $produto = Produto::create([
            'nome' => $request->input('nome'),
            'preco' => $request->input('preco'),
            'user_id' => auth()->id(),
        ]);

        if (!$produto) {
            return redirect()->back()->with(['error' => 'Erro ao cadastrar produto.']);
        }

        return redirect()->route('home')->with('status', 'Novo produto criado com sucesso!');
    }
}
