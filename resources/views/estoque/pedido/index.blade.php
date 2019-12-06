@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-5">
                    <h1 class="card-title"> Pedido para o Estoque </h1>
                </div>
                <div class="col">
                    <a href=" {{ route('pedidosEstoqueEN') }}" class="btn btn-info w-100">Enviados</a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-primary w-100">Autorizados</a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-success w-100">Finalizados</a>
                </div>
            </div>
        </div>
    </div>
    @forelse ($pedidos as $pedido)
        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <h4 class="card-title"> Pedido: {{ $pedido->id }} </h4>
                    </div>
                    <div class="col">
                        <h4 class="card-title text-center"> 
                            <strong>Fornecedor: {{ $pedido->fornecedor->nome }}</strong>
                        </h4>
                    </div>
                    <div class="col-3">
                        <h4 class="card-title"> Criado em: {{ $pedido->created_at->format('d/m/Y') }} </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Descricao</th>
                            <th>Qtd</th>
                            <th>Valor Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_pedido = 0;
                        @endphp
                        @foreach ($pedido->pedido_item as $item)
                            <tr>
                                <td>{{ $item->pedido_item_estoque->descricao }}</td>
                                <td >
                                    <div class="row" style="max-width: 100px;">
                                        <a href="#" style="width: 20px;{{ ($item->qtd <= 1) ? 'pointer-events: none;' : ''}}" onclick="diminuirItem({{ $item->id }})" data-toggle="popover" data-trigger="focus" title="Clique para diminuir">
                                            <i class='fas fa-minus-circle mt-2' style='font-size:20px; {{ ($item->qtd <= 1) ? 'color: gray;' : ''}}'></i>
                                        </a>
                                        <span id="qtd" class="text-center" style="width: 40px;" data-toggle="popover" data-trigger="focus" title="Clique para abrir editar">
                                            <a href="#" class="btn btn-light" onclick="abrirModal({{ $item->estoque_geral_id }})">
                                                {{ $item->qtd }}
                                            </a>
                                        </span>
                                        <a href="#" style="width: 20px;" onclick="addItem({{ $item->id }})"  data-toggle="popover" data-trigger="focus" title="Clique para aumentar">
                                            <i class='fas fa-plus-circle mt-2 ml-1' style='font-size:20px'></i>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <a href="#" onclick="removerItem({{ $pedido->id }}, {{ $item->estoque_geral_id }}, {{  $pedido->fornecedor->id }}, 0)" class="text-center">Remover Item</a>   
                                    </div>
                                </td>   
                                <td>
                                    R$ {{ number_format($item->pedido_item_estoque->preco, 2, ',', '.') }}
                                </td>
                                @php
                                    $total_item = $item->pedido_item_estoque->preco * $item->qtd;
                                    $total_pedido += $total_item;
                                @endphp
                                <td>
                                    R$ {{ number_format($total_item, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row border-bottom mb-3">
                    <div class="col offset-9">
                        <strong>Total do Pedido : </strong>
                        <span>R$ {{ number_format($total_pedido, 2, ',', '.') }} </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="/estoque/estoqueFornecedor/{{ $pedido->fornecedor->id }}" class="btn btn-info w-100">
                            Adicionar mais do Fornecedor
                        </a>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-success w-100" id="btnConcluir" onclick="conluir({{ $pedido->id }})">
                            Enviar Pedido
                        </a>
                    </div>
                    <div class="col">
                        <a href="/estoque/carrinhoEstoque/excluirPedido/{{ $pedido->id }}" class="btn btn-danger w-100">
                            Excluir Pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h3 class="card-title text-center">Não há pedido</h5>
    @endforelse

    <form id="form_remover" method="POST" action="{{ route("removerItemPedido") }}">
        @csrf
        @method('delete')
        <input type="hidden" name="pedido_id">
        <input type="hidden" name="estoque_geral_id">
        <input type="hidden" name="fornecedor_id">
        <input type="hidden" name="item">
    </form>
    <form id="form_add" method="POST" action="{{ route("addItemPedido") }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="item_id">
        <input type="hidden" name="quantidade0">
    </form>
    <form id="form_dim" method="POST" action="{{ route("dimItemPedido") }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="item_id">
        <input type="hidden" name="quantidade0">
    </form>

    <div class="modal fade" id="modalQtd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Quantidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="margin-left: 30%;">
                        <input type="hidden" name="item_id" id="item_id2">
                        <input type="hidden" name="pedido_id" id="pedido_id">
                        <div class="row">
                            <div class="col-7">
                                <label for="quantidade1">Quantidade Pedido</label>
                                <input type="number" id="quantidade1" name="qtd1" min="1" value="1" class="form-control" disabled>    
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-7">
                                <label for="quantidade">Quantidade</label>
                                <input type="number" id="quantidade" name="qtd" min="1" value="1" class="form-control">    
                            </div>
                        </div>                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" id="btnRemover0">Remover</button>
                    <button type="button" class="btn btn-primary" id="btnAdd0">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('enviarEmail') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Enviar para: <label id="labelEmail"></label> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="pedido_id2" id="pedido_id2">
                            <div class="row">
                                <div class="col">
                                    <label for="email">E-mail do Fornecedor</label>
                                    <input type="text" id="email" name="email" class="form-control" disabled>    
                                    <input type="hidden" id="email2" name="email2">    
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col">
                                    <label for="assunto">Assunto</label>
                                    <input type="text" id="assunto" name="assunto" class="form-control">    
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col">
                                    <label for="observacao">Observação</label>
                                    <textarea name="observacao" id="observacao" cols="30" rows="5" maxlength="200" class="form-control"></textarea>  
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success" id="btnEnviarEmail">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        var btnRemover0 = document.querySelector('#btnRemover0');
        var btnAdd0 = document.querySelector('#btnAdd0');

        function conluir(pedido_id) {
            var elementoLabel = document.querySelector('#labelEmail');
            elementoLabel.innerHTML = '';
            $.get('/api/enviarPedido/'+pedido_id, function(data) {
                dados = JSON.parse(data);

                var textoLabel = document.createTextNode(dados[0].fornecedor.nome);
                elementoLabel.appendChild(textoLabel);

                $('#pedido_id2').val(dados[0].id);
                $('#email').val(dados[0].fornecedor.email);
                $('#email2').val(dados[0].fornecedor.email);
                $('#assunto').val('Pedido de compras Ind. Inkasa');
            });

            $('#modalEmail').modal('show');
        }

        function removerItem(pedido_id, estoque_geral_id, fornecedor_id, item) {
            $('#form_remover input[name="pedido_id"]').val(pedido_id);
            $('#form_remover input[name="estoque_geral_id"]').val(estoque_geral_id);
            $('#form_remover input[name="fornecedor_id"]').val(fornecedor_id);
            $('#form_remover input[name="item"]').val(item);
            $('#form_remover').submit();
        }

        function addItem(estoque_geral_id, operacao) {
            $('#modalQtd').modal('hide');

            if(operacao == 0) {
                $quantidaM = $('#quantidade').val();
                //alert($quantidaM)
                $('#form_add input[name="quantidade0"]').val($quantidaM);
            } else {
                $('#form_add input[name="quantidade0"]').val(1);
            }

            $('#form_add input[name="item_id"]').val(estoque_geral_id);
            $('#form_add').submit();
        }

        function diminuirItem(estoque_geral_id, operacao) {
            $('#modalQtd').modal('hide');
            
            if(operacao == 0) {
                $quantidaM = $('#quantidade').val();
                $('#form_dim input[name="quantidade0"]').val($quantidaM);
            } else {
                $('#form_dim input[name="quantidade0"]').val(1);
            }

            $('#form_dim input[name="item_id"]').val(estoque_geral_id);
            $('#form_dim').submit();
        }

        function abrir(dados, id_item) {
            for(dado of dados) {
                if(dado.estoque_geral_id == id_item) {
                    $('#item_id2').val(dado.estoque_geral_id);
                    $('#pedido_id').val(dado.id);
                    $('#quantidade1').val(dado.qtd);

                    btnAdd0.setAttribute('onclick', 'addItem(' + dado.id + ', 0)');
                    btnRemover0.setAttribute('onclick', 'diminuirItem(' + dado.id + ', 0)');
                }
            }
            $('#modalQtd').modal('show');
        }

        function abrirModal(id_item) {
            axios.get('/api/pedidosAberto')
                .then(function(response) {
                    abrir(response.data, id_item);
                })
                .catch(function(erro) {
                    console.log('erro');
                });
        }

    </script>
@endsection


