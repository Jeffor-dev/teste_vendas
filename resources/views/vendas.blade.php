@extends('layouts.app')
@section('content')
<div class="container">
    <!-- editar venda -->
    <div class="modal" id="editarVendaModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
             <form method="POST" class="w-100" id="formEditarVenda">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Venda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="cliente_id" class="mb-3">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="form-select mb-3">
                            <option value="" id="optionCliente">2</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mb-3">
                            <label for="dataVenda" class="form-label">Data Venda</label>
                            <input type="date" class="form-control" id="dataVenda" name="data_venda">
                        </div>
                        <div class="mb-3">
                            <label for="precoProduto" class="form-label">Valor Total</label>
                            <input type="text" class="form-control" id="precoProduto" name="preco" oninput="formatarValorUnitario(event)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="text" name="venda_id" id="venda_id" hidden>
                        <input type="text" name="valor_total" id="valor_total" hidden>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limparCamposModal('#editarVendaModal')">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="salvarEdicaoVenda()">Salvar</button>
                    </div>
                </div>
             </form>
            
        </div>
    </div>

        <table class="table">
            <thead>
                <tr>
                <th scope="col">Código</th>
                <th scope="col">Cliente</th>
                <th scope="col">Data Venda</th>
                <th scope="col">Valor Total</th>
                <th scope="col">Ações</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($vendas as $venda)
                    <tr>
                        <th scope="row">{{ $venda->id }}</th>
                        <td>{{ $venda->cliente->nome }}</td>
                        <td>{{ $venda->data_venda }}</td>
                        <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-primary" oninput="formatarValorUnitario(event)" onclick="exibirDadosVenda({{ $venda }})" data-bs-toggle="modal" data-bs-target="#editarVendaModal">Editar</button>
                            <form action="{{ route('deletar.venda', ['id' => $venda->id]) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
<script>

    const exibirDadosVenda = (venda) => {
        $('#optionCliente').val(venda.cliente_id)
        $('#optionCliente').text(venda.cliente.nome)
        $('#cliente_id').val(venda.cliente_id)
        $('#dataVenda').val(venda.data_venda)
        $('#precoProduto').val(venda.valor_total)
        $('#venda_id').val(venda.id)
        $('#valor_total').val(venda.valor_total)
    }

    const salvarEdicaoVenda = () => {
        
        let url = "{{ route('editar.venda', ':id') }}".replace(':id', $('#venda_id').val())
        $('#formEditarVenda').attr('action', url)
        $('#formEditarVenda').submit()
    }

    const formatarValorUnitario = (event) => {
        
        const input = event.target;
        let valor = input.value.replace(/\D/g, '')

        if (!valor) {
            input.value = ''
            return
        }

        valor = (parseInt(valor, 10) / 100).toFixed(2)
        input.value = valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')
        if (input !== $('#precoProduto')) {
            input.value = valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')
            return
            
        }
    }

        const limparCamposModal = (idModal) => {
        const modalSelecionado = $(idModal)
        modalSelecionado.find('input[type="text"]').val('')
        modalSelecionado.find('input[type="checkbox"]').prop('checked', false)
        modalSelecionado.find('input[type="radio"]').prop('checked', false)
    }
</script>

@endsection

