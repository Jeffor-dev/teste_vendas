<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Cliente;

class VendaController extends Controller
{

    public function index()
    {
        $vendas = Venda::with('cliente')->where('user_id', auth()->id())->get();
        $clientes = Cliente::where('user_id', auth()->id())->get();

        return view('vendas', [
            'vendas' => $vendas,
            'clientes' => $clientes,
        ]);
    }

    public function registrarVenda(Request $request)
    {
        $validated = $request->validate([
            'dataVenda' => 'required|date',
            'cliente_id' => 'nullable',
            'total' => 'required|decimal:0,2',
        ]);

        $venda = Venda::create([
            'user_id' => auth()->id(),
            'cliente_id' => $validated['cliente_id'],
            'data_venda' => $validated['dataVenda'],
            'valor_total' => $validated['total'],
        ]);

        if (!$venda) {
            return redirect()->back()->with(['error' => 'Erro ao registrar venda.']);
        }

        return redirect()->route('vendas')->with('status', 'Venda registrada com sucesso!');

    }

    public function editarVenda(Request $request, $id)
    {

        $venda = Venda::findOrFail($id);

        $venda->update([
            'data_venda' => $request['data_venda'],
            'cliente_id' => $request['cliente_id'],
            'valor_total' => floatval($request['preco']),
        ]);

        return redirect()->route('vendas')->with('status', 'Venda editada com sucesso!');
    }

    public function deletarVenda($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->delete();

        return redirect()->route('vendas')->with('status', 'Venda excluída com sucesso!');
    }
}
