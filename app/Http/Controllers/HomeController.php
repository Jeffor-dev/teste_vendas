<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente as Cliente;
use App\Models\Produto;
use App\Models\FormaPagamento;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $clientes = Cliente::where('user_id', $user->id)->get();
        $produtos = Produto::where('user_id', $user->id)->get();
        $formasPagamento = FormaPagamento::where('user_id', $user->id)->get();

        return view('home', [
            'clientes' => $clientes,
            'produtos' => $produtos,
            'formasPagamento' => $formasPagamento
        ]);
    }


    public function cadastrarCliente( Request $request )
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
        ]);

        if (Cliente::where('cpf', $request->input('cpf'))->exists()) {
            return redirect()->back()->with(['error' => 'CPF já cadastrado.']);
        }

        $cliente = Cliente::create([
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'user_id' => auth()->id(),
        ]);


        if (!$cliente) {
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar cliente.']);
        }        

        return redirect()->route('home')->with('status', 'Novo cliente criado com sucesso!');
    }

    public function cadastrarProduto( Request $request )
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric',
        ]);

        $produto = Produto::create([
            'nome' => $request->input('nome'),
            'preco' => $request->input('preco'),
        ]);

        if (!$produto) {
            return redirect()->back()->with(['error' => 'Erro ao cadastrar produto.']);
        }

        return redirect()->route('home')->with('status', 'Novo produto criado com sucesso!');
    }

}
