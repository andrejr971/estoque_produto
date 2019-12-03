@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title"> Pedido para o Estoque </h1>
                </div>
            </div>
        </div>
    </div>
    @forelse ($pedidos as $pedido)
        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <h4 class="card-title"> Pedido: {{ $pedido->id }} </h3>
                    </div>
                    <div class="col">
                        <h4 class="card-title text-center"> <strong>Fornecedor: {{ $pedido->fornecedor->nome }}</strong> </h4>
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
                                        <a href="#" style="width: 30px;{{ ($item->qtd <= 1) ? 'pointer-events: none;' : ''}}" onclick="diminuirItem({{ $item->id }})">
                                            <i class='fas fa-minus-circle' style='font-size:20px; {{ ($item->qtd <= 1) ? 'color: gray;' : ''}}'></i>
                                        </a>
                                        <span class="text-center" style="width: 40px;">{{ $item->qtd }}</span>
                                        <a href="#" style="width: 30px;" onclick="addItem({{ $item->id }})">
                                            <i class='fas fa-plus-circle' style='font-size:20px'></i>
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
                <div class="row">
                    <div class="col offset-9">
                        <strong>Total do Pedido : </strong>
                        <span>R$ {{ number_format($total_pedido, 2, ',', '.') }} </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col offset-6 ">
                        <a href="#" class="btn btn-info w-100">
                            Adicionar mais do Fornecedor
                        </a>
                    </div>
                    <div class="col">
                        <a href="#" class="btn btn-success w-100">
                            Enviar/Finalizar
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
    </form>
    <form id="form_dim" method="POST" action="{{ route("dimItemPedido") }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="item_id">
    </form>
@endsection

@section('javascript')
    <script>
        function removerItem(pedido_id, estoque_geral_id, fornecedor_id, item) {
            $('#form_remover input[name="pedido_id"]').val(pedido_id);
            $('#form_remover input[name="estoque_geral_id"]').val(estoque_geral_id);
            $('#form_remover input[name="fornecedor_id"]').val(fornecedor_id);
            $('#form_remover input[name="item"]').val(item);
            $('#form_remover').submit();
        }

        function addItem(estoque_geral_id) {
            $('#form_add input[name="item_id"]').val(estoque_geral_id);
            $('#form_add').submit();
        }

        function diminuirItem(estoque_geral_id) {
            $('#form_dim input[name="item_id"]').val(estoque_geral_id);
            $('#form_dim').submit();
        }
        
    </script>
@endsection


