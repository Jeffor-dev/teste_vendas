<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/vendas', [App\Http\Controllers\VendaController::class, 'index'])->name('vendas');


Route::post('/cliente', [App\Http\Controllers\HomeController::class, 'cadastrarCliente'])->name('cadastro.cliente');
Route::post('/produto', [App\Http\Controllers\ProdutoController::class, 'cadastrarProduto'])->name('cadastro.produto');
Route::post('/forma-pagamento', [App\Http\Controllers\FormaPagamentoController::class, 'cadastrarFormaPagamento'])->name('cadastro.formaPagamento');
Route::post('/venda', [App\Http\Controllers\VendaController::class, 'registrarVenda'])->name('cadastro.venda');
Route::put('/venda/{id}', [App\Http\Controllers\VendaController::class, 'editarVenda'])->name('editar.venda');
Route::delete('/venda/{id}', [App\Http\Controllers\VendaController::class, 'deletarVenda'])->name('deletar.venda');