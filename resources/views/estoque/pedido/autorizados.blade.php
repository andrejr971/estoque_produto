@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-5">
                    <h1 class="card-title"> Pedidos para Pagamento </h1>
                </div>
                <div class="col">
                    <a href="{{ route('pedidosEstoqueEN') }}" class="btn btn-primary w-100">Enviados</a>
                </div>
                <div class="col">
                    <a href="{{ route('pedidosEstoqueFP') }}" class="btn btn-success w-100">Finalizados</a>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion mt-3" id="accordionExample">
        @forelse ($pedidos as $pedido)
            <div class="card">
                <div class="card-header" id="headingOne">
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#abrir{{ $pedido->id  }}" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="card-title"> Pedido: {{ $pedido->id }} </h5>
                            </button>
                        </div>
                        <div class="col">
                            <h5 class="card-title text-center"> 
                                <strong>Fornecedor: {{ $pedido->fornecedor->nome }}</strong>
                            </h5>
                        </div>
                        <div class="col">
                            <h5 class="card-title"> Criado em: {{ $pedido->created_at->format('d/m/Y') }} </h5>
                        </div>
                        <div class="col">
                                <button type="submit" class="btn btn-success w-100" onclick="finalizar({{ $pedido->id }})">
                                    Finalizar Pedido
                                </button>
                        </div>
                        <div class="col">
                            <div class="btn-group w-100 dropright">
                                <button type="button" class="btn btn-info">Anexo</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Anexo</span>
                                </button>
                                <div class="dropdown-menu">
                                    @empty($pedido->anexo)
                                        <a href="#" class="dropdown-item"> Não há Anexo</a>
                                    @else  
                                        <a class="dropdown-item" href="/storage/{{ $pedido->anexo }}" target="_blank">
                                            Nota
                                        </a>
                                    @endempty
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <a href="/estoque/carrinhoEstoque/excluirPedido/{{ $pedido->id }}" class="btn btn-danger w-100">
                                Excluir Pedido
                            </a>
                        </div>
                    </div>
                </div>
            
                <div id="abrir{{ $pedido->id  }}" class="collapse {{ (session('ativo') == $pedido->id) ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionExample">
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
                                    @if ($item->status === 'CP')
                                        <tr>
                                            <td>{{ $item->pedido_item_estoque->descricao }}</td>
                                            <td >
                                                <span id="qtd" class="text-center" style="width: 40px;" data-toggle="popover" data-trigger="focus" title="Clique para abrir editar">
                                                    <a href="#" class="btn btn-light">
                                                        {{ $item->qtd }}
                                                    </a>
                                                </span>
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
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row border-bottom mb-3">
                            <div class="col offset-9">
                                <strong>Total do Pedido : </strong>
                                <span>R$ {{ number_format($total_pedido, 2, ',', '.') }} </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h3 class="card-title text-center">Não há pedido</h5>
        @endforelse
    </div>

    <div class="modal fade" id="modalFinalizar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('pedidosEstoqueFpId') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="pedido_id" id="pedido">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Salvar Nota Fiscal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <input type="file" name="upFile" accept=".pdf, .xml">  
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success" id="btnEnviarEmail">Salvar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        function finalizar(pedido_id) {
            $('#pedido').val(pedido_id);
            //$('#formAutorizar').submit();*/

            $('#modalFinalizar').modal('show');
        }
    </script>
@endsection


