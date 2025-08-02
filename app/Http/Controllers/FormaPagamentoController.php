<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormaPagamento;

class FormaPagamentoController extends Controller
{
    public function cadastrarFormaPagamento(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:30|unique:formas_pagamento,nome',
        ]);

        $formaPagamento = FormaPagamento::create([
            'nome' => $request->input('nome'),
            'user_id' => auth()->id(),
        ]);

        if (!$formaPagamento) {
            return redirect()->back()->with(['error' => 'Erro ao cadastrar forma de pagamento.']);
        }

        return redirect()->route('home')->with('status', 'Nova forma de pagamento criada com sucesso!');
    }
}
