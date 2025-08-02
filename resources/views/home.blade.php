@extends('layouts.app')
@section('content')
<div class="container">
    <!-- novo cliente -->
    <div class="modal" id="novoClienteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
             <form method="POST" action="{{ route('cadastro.cliente') }}" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limparCamposModal('#novoClienteModal')" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeCliente" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeCliente" name="nome">
                        </div>
                        <div class="mb-3">
                            <label for="cpfCliente" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpfCliente" name="cpf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limparCamposModal('#novoClienteModal')">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
             </form>
            
        </div>
    </div>

    <!-- novo Produto -->
    <div class="modal" id="novoProdutoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
             <form method="POST" action="{{ route('cadastro.produto') }}" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limparCamposModal('#novoProdutoModal')" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeProduto" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeProduto" name="nome">
                        </div>
                        <div class="mb-3">
                            <label for="precoProdutoModal" class="form-label">Preço</label>
                            <input type="text" class="form-control" id="precoProduto" name="preco" oninput="formatarValorUnitario(event)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limparCamposModal('#novoProdutoModal')">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="cadastrarProduto()">Salvar</button>
                    </div>
                </div>
             </form>
            
        </div>
    </div>

    <!-- nova formaPagamento -->
    <div class="modal" id="novaFormaPagamentoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
             <form method="POST" action="{{ route('cadastro.formaPagamento') }}" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Forma de Pagamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limparCamposModal('#novaFormaPagamentoModal')" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeFormaPagamento" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeFormaPagamento" name="nome">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limparCamposModal('#novaFormaPagamentoModal')">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
             </form>

        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard de vendas') }}</div>
                <div class="card-body bg">
                    @if ($errors->any())
                        <div class="alert alert-danger" id="errors-list">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            setTimeout(() => {
                                const alert = document.getElementById('errors-list');
                                if (alert) alert.remove();
                            }, 2000);
                        </script>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success" role="alert" id="status-alert">
                            {{ session('status') }}
                        </div>
                        <script>
                            setTimeout(() => {
                                const alert = document.getElementById('status-alert');
                                if (alert) alert.remove();
                            }, 2000);
                        </script>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert" id="error-alert">
                            {{ session('error') }}
                        </div>
                        <script>
                            setTimeout(() => {
                                const alert = document.getElementById('error-alert');
                                if (alert) alert.remove();
                            }, 2000);
                        </script>
                    @endif
                    
                    <div class="mb-3 p-3 shadow rounded" style="background-color: #D6D6D6">
                        <h5 class="mb-3">Cadastros</h5>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#novoClienteModal">Novo Cliente</button>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#novoProdutoModal">Novo Produto</button>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#novaFormaPagamentoModal">Nova Forma de Pagamento</button>
                    </div>

                    <div class="mb-3 p-3 shadow rounded">
                        <h5 class="mb-3">Venda</h5>
                        <span>Cliente</span>
                        <select class="form-select form-select my-3" id="clienteSelect">
                            <option selected disabled>Selecionar Cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente['id'] }}">{{ $cliente['id'] }} - {{ $cliente['nome'] }}/ {{ $cliente['cpf'] }}</option>
                            @endforeach
                        </select>

                        <div id="clienteInfo">
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div class="mb-3">
                                <label for="produtoSelect" class="form-label" style="width: 230px;">Produto</label>
                                <select class="form-select form-select" id="produtoSelect" onchange="atualizarValorUnitario()">
                                    <option selected disabled>Selecionar Produto</option>
                                    @foreach ($produtos as $produto)
                                        <option value="{{ $produto['id'] }}">{{ $produto['nome'] }} / R${{ number_format($produto['preco'], 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="quantidade" class="form-label">Quantidade</label>
                                <input type="text" class="form-control" id="quantidade" name="quantidade" min="1" value="1" oninput="formatarQuantidade(event)" onchange="atualizarValorSubtotal()">
                            </div>

                            <div class="mb-3">
                                <label for="valorUnitario" class="form-label">Valor Unitário</label>
                                <input type="text" class="form-control" id="valorUnitario" name="valorUnitario" min="0" value="0" oninput="formatarValorUnitario(event)" onchange="atualizarValorSubtotal()">
                            </div>

                            <div class="mb-3">
                                <label for="subtotal" class="form-label">Subtotal</label>
                                <input type="text" class="form-control" id="subtotal" name="subtotal" min="0" value="0" disabled>
                            </div>

                            <button type="button" class="btn btn-primary mt-2" id="adicionarItemBtn" onclick="adicionarItemVenda()"><i class="bi bi-plus"></i></button>

                        </div>
                    </div>
                    <div class="mb-3 p-3 shadow rounded">
                        <h5 class="mb-3">Itens da Venda</h5>
                        <table class="table table-striped" id="itensVendaTable">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Cod.Produto</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Quant.</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="itensVendaBody">
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="1" class="text-start">Total:</td>
                                    <td id="totalVenda">R$ 0,00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-3 p-3 shadow rounded">
                        <h5 class="mb-3">Pagamento</h5>
                        <div class="mb-3" style="width: 400px">
                            <label for="inserirParcela" class="form-label">Forma de Pagamento</label>
                            <div class="input-group gap-3 justify-content-start">
                                <input type="number" class="form-control" id="inserirParcela" name="inserirParcela" placeholder="Quantidade de parcelas">
                                <button type="button" class="btn btn-primary" id="adicionarParcelaBtn" onclick="gerarParcelas()">Gerar Parcela</button>
                            </div>
                        </div>

                        <div id="parcelasContainer"></div>

                        <form method="POST" action="{{ route('cadastro.venda') }}" id="formRegistrarVenda">
                            @csrf
                            <input type="hidden" name="dataVenda" value="" id="dataVenda">
                            <input type="hidden" name="cliente_id" value="" id="clienteId">
                            <input type="hidden" name="total" value="" id="totalVendas">
                            <button type="button" class="btn btn-success mt-3" id="finalizarVendaBtn" onclick="finalizarVenda()">Registrar Venda</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const carrinhoVenda = []
    let totalVenda = 0
    let dataAntesDaTroca = null
    let dataParcelaAnterior = null
    let permitirRegistroVenda = false

    const finalizarVenda = () => {
        if (carrinhoVenda.length === 0) {
            alert('Adicione pelo menos um item.')
            return
        }

        const dadosVenda = {
            cliente_id: $('#clienteSelect').val(),
            itens: carrinhoVenda,
            total: totalVenda,
            dataVenda: new Date().toISOString().split('T')[0],
        }

        $('#dataVenda').val(dadosVenda.dataVenda)
        $('#clienteId').val(dadosVenda.cliente_id)
        $('#totalVendas').val(totalVenda)
        $('#formRegistrarVenda').submit()

    }

    const adicionarItemVenda = () => {
        const item = {
            cod_cliente: $('#clienteSelect').val(),
            cod_produto: $('#produtoSelect').find(':selected').val(),
            nome_produto: $('#produtoSelect').find(':selected').text().split(' / ')[0],
            quant_produto: parseInt($('#quantidade').val()),
            valor_unitario: parseFloat($('#valorUnitario').val()).toFixed(2),
            subtotal: parseFloat($('#subtotal').val()).toFixed(2)
        }
        carrinhoVenda.push(item)
        atualizarTabelaItensVenda()
        atualizarTotalVenda()
    }

    const atualizarTotalVenda = () => {
        totalVenda = carrinhoVenda.reduce((total, item) => total + parseFloat(item.subtotal), 0)
        $('#totalVenda').text(`R$ ${totalVenda.toFixed(2).replace('.', ',')}`)
    }

    const removerItemVenda = (index) => {
        carrinhoVenda.splice(index, 1)
        atualizarTabelaItensVenda()
        atualizarTotalVenda()
    }

    const atualizarTabelaItensVenda = () => {
        const body = $('#itensVendaBody')
        body.empty()
        carrinhoVenda.forEach((item, index) => {
            const row = `<tr class="align-middle">
                <td>${index + 1}</td>
                <td>${item.cod_produto}</td>
                <td>${item.nome_produto}</td>
                <td>${item.quant_produto}</td>
                <td>R$ ${parseFloat(item.valor_unitario).toFixed(2).replace('.', ',')}</td>
                <td>R$ ${parseFloat(item.subtotal).toFixed(2).replace('.', ',')}</td>
                <td>
                    <button class="btn btn-danger" onclick="removerItemVenda(${index})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`
            body.append(row)
        })
    }

    const cadastrarCliente = () => {
        const name = $('#nomeCliente').val()
        const cpf = $('#cpfCliente').val()

        if (name && cpf) {
            console.log(`Cliente cadastrado: ${name}, CPF: ${cpf}`)
        } else {
            alert('Por favor, preencha todos os campos.')
        }
    }

    const cadastrarProduto = () => {
        const name = $('#nomeProduto').val()
        const preco = 2
        $('#precoProduto').val(parseFloat($('#precoProduto').val().replace(',', '.')).toFixed(2))

        if (name && preco) {
            $('#novoProdutoModal form').submit()
        } else {
            alert('Por favor, preencha todos os campos.')
        }
    }

    const limparCamposModal = (idModal) => {
        const modalSelecionado = $(idModal)
        modalSelecionado.find('input[type="text"]').val('');
        modalSelecionado.find('input[type="checkbox"]').prop('checked', false)
        modalSelecionado.find('input[type="radio"]').prop('checked', false)
    }

    const formatarQuantidade = (event) => {
        const input = event.target
        if(input.value === '0') {
            
            alert('A quantidade não pode ser zero.')
            input.value = 1
            return
        }

        input.value = input.value.replace(/[^0-9]/g, '')

        atualizarValorSubtotal()
    }

    const atualizarValorUnitario = () => {
        const produtoSelect = $('#produtoSelect').find(':selected');
        const valorUnitarioInput = $('#valorUnitario')
        const valorUnitario = produtoSelect.text().match(/R\$\s*([\d,.]+)/)[1].replace(',', '.')
        valorUnitarioInput.val(valorUnitario)

        atualizarValorSubtotal()
    }

    const formatarValorUnitario = (event) => {
        const input = event.target;
        let valor = input.value.replace(/\D/g, '')

        if (!valor) {
            input.value = ''
            return;
        }

        valor = (parseInt(valor, 10) / 100).toFixed(2);
        input.value = valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')
        if (input !== $('#precoProduto')) {
            input.value = valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.')
            atualizarValorSubtotal()
            return
            
        }
    }

    const atualizarValorSubtotal = () => {
        const quantidade = parseInt($('#quantidade').val()) || 0
        const valorUnitario = parseFloat($('#valorUnitario').val().replace(',', '.')) || 0
        $('#subtotal').val(parseFloat(quantidade * valorUnitario).toFixed(2))
    }

    const gerarParcelas = () => {
        const parcelas = parseInt($('#inserirParcela').val())
        if(!parcelas) {
            alert('Por favor, insira uma quantidade válida de parcelas.')
            return
        }
        const valorParcelas = totalVenda / parcelas
        const parcelasContainer = $('#parcelasContainer')
        parcelasContainer.empty()

        const hoje = new Date()

        for(let i = 1; i <= parcelas; i++) {
            let dataParcela = new Date(hoje.getFullYear(), hoje.getMonth() + (i - 1), hoje.getDate())
            if (dataParcela.getDate() !== hoje.getDate()) {
                dataParcela = new Date(dataParcela.getFullYear(), dataParcela.getMonth() + 1, 0)
            }
            const dataFormatada = dataParcela.toISOString().split('T')[0]
            parcelasContainer.append(`
            <div class="input-group mb-3">
                <div class="d-flex gap-3">
                    <span class="input-group-text bg-primary text-white">${i}</span>
                    <input type="date" class="form-control" id="dataParcela${i}" name="dataParcela${i}" value="${dataFormatada}" onfocus="guardarDataAnterior(event)" oninput="verificarDataParcela(event)">
                    <input type="text" class="form-control" id="parcela${i}" name="parcela${i}" onchange="if(validarValorParcela(event)) distribuirValores(event)" value="${valorParcelas.toFixed(2).replace('.', ',')}" oninput="formatarValorUnitario(event)">
                    <select class="form-select" id="formaPagamento${i}" name="formaPagamento${i}">
                        <option selected disabled>Selecionar Forma de Pagamento</option>
                        @foreach ($formasPagamento as $formaPagamento)
                            <option value="{{ $formaPagamento['id'] }}">{{ $formaPagamento['nome'] }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control" id="observacao${i}" name="observacao${i}" placeholder="Observação">
                </div>
            </div>
        `)
    }

    const verificarDataParcela = (event) => {
        const input = event.target
        const dataSelecionada = new Date(input.value)

        if (!dataParcelaAnterior) return

        const anterior = new Date(dataParcelaAnterior)

        let diferencaMeses = dataSelecionada.getMonth() - anterior.getMonth()

        if (diferencaMeses < 1 || (diferencaMeses === 1)) {
            alert('A data da parcela deve ser no mês posterior a anterior.')
            input.value = dataAntesDaTroca
        }
    }

    const guardarDataAnterior = (event) => {
        dataAntesDaTroca = event.target.value
        let numeroParcela = (event.target.id).split('dataParcela')[1]

        if (parseInt(numeroParcela) > 1) {
            const dataAnterior = document.getElementById(`dataParcela${parseInt(numeroParcela) - 1}`)
            dataParcelaAnterior = dataAnterior.value
            return
        }
        dataParcelaAnterior = null
    }
}
</script>
@endsection

