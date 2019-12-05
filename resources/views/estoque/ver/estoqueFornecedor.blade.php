@extends('layout.index')

@section('conteudo')
    @forelse ($estoque as $itens)
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2 class="card-title"> Fornecedor: {{ $itens->nome }} </h2>
                    </div>
                    <div class="col-3">
                        <a href="{{ route("carrinhoPedido") }}" class="btn btn-outline-info w-100">
                            Pedidos
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2">
                                    <label for="">Procurar</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control">    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-sm table-responsive-sm">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Descrição</th>
                                <th>Qtd</th>
                                <th>Estoque Min.</th>
                                <th>Preço</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itens->estoqueFilter as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->descricao }}</td>
                                    <td>{{ $item->qtd }} {{ $item->un_medida }}</td>
                                    <td>{{ $item->estoque_min }}</td>
                                    <td>{{ $item->preco }}</td>
                                    <td>
                                        <button onclick="mostrarModal({{ $item->id }})" class="btn btn-outline-info w-100">Pedir</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-damger alert-dismissible fade show" role="alert">
            <strong>Ops...</strong> Nenhum resultado encontrado
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforelse
    <div class="modal fade" id="modalQtd" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" id="formPedido">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tipoModal">Pedido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="estoque_id" id="estoque_id">
                            <input type="hidden" name="fornecedor_id" id="fornecedor_id">
                            <div class="row">
                                <div class="col">
                                    <label for="qtd">Quantidade</label>
                                    <input type="number" id="qtd" name="qtd" value="1" class="form-control">    
                                </div>
                                <div class="col">
                                    <label for="min">Estoque Min.</label>
                                    <input type="number" id="min" name="min" value="1" class="form-control" disabled>    
                                </div>  
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="usarMin">
                                <label class="form-check-label" for="usarMin">
                                    Usar estoque Minimo
                                </label>
                            </div>                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-outline-primary">Adicionar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
@endsection

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function mostrarModal(id) {
            axios.get('/api/estoque')
                .then( function(response) {
                    pedir(response.data, id);
                })
                .catch( function(erro) {
                    alert(erro);
                })
        }

        function pedir(dados, id) {
            for(dado of dados) {
                if(dado.id === id) {
                    $('#estoque_id').val(dado.id);
                    $('#min').val(dado.estoque_min);

                    for(f of dado.fornecedores) {
                        $('#fornecedor_id').val(f.id);
                    }
                }
            }
            $('#modalQtd').modal('show');
        }

        function verificacao(dados, item) {
            console.log(dados);
            let teste = parseInt(item.estoque_geral_id);
            if(dados === 0) {
                $.post('{{ route("addApiPedido") }}', item, function() {
                    alert('Item Add');

                    $('#modalQtd').modal('hide');
                });
            } else {
                alert('Item já está na lista');
                $('#modalQtd').modal('hide');
            }
        }

        $('#formPedido').submit(function(event) {
            event.preventDefault();

            if($('#usarMin').prop('checked')) {
                item = {
                    estoque_geral_id : $('#estoque_id').val(),
                    fornecedor_id : $('#fornecedor_id').val(),
                    qtd : $('#min').val()
                }
            } else {
                item = {
                    estoque_geral_id : $('#estoque_id').val(),
                    fornecedor_id : $('#fornecedor_id').val(),
                    qtd : $('#qtd').val()
                }
            }

            axios.get('/api/pedidosAberto/'+item.estoque_geral_id)
                .then(function(response) {
                    verificacao(response.data, item);
                })
                .catch(function(erro) {
                    console.log(erro);
                });

        });
    </script>
    
@endsection
