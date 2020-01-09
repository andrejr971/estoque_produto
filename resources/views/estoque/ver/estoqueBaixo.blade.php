@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title"> Itens com baixo estoque </h1>
                </div>
                <div class="col-3">
                    <a href="{{ route("carrinhoPedido") }}" class="btn btn-outline-info w-100">
                        Pedidos
                    </a>
                </div>
                <div class="col-3">
                    <a href="/estoque/gerarPDF" target="blank" class="btn btn-outline-success w-100">Gerar Lista de Compra</a>
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
            <div id="tabela">

            </div>
        </div>
    </div>

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
    <form id="form_add" method="POST" action="{{ route("addTudoFornecedor") }}">
        @csrf
        <input type="hidden" name="fornecedor_id">
    </form>

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

        function pedirTudo(fornecedor_id) {
            $('#form_add input[name="fornecedor_id"]').val(fornecedor_id);
            $('#form_add').submit();
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

        var divTabela = document.querySelector('#tabela');

        function renderTabela(dados) {
            cont = 0;

            for(dado of dados) {
                var elementoH5 = document.createElement('h5');
                var elementoA = document.createElement('a');
                var elementoTabela = document.createElement('table');
                var elementoTabelaThead = document.createElement('thead');
                var elementoTabelaTbody = document.createElement('tbody');

                elementoTabela.setAttribute('class', 'table table-sm table-bordered table-striped table-responsive-sm');
                elementoTabelaThead.setAttribute('class', 'thead-light');

                var elementoTR = document.createElement('tr');
                var elementoth1 = document.createElement('th');
                var elementoth2 = document.createElement('th');
                var elementoth3 = document.createElement('th');
                var elementoth4 = document.createElement('th');
                var elementoth5 = document.createElement('th');
                var elementoth7 = document.createElement('th');

                var textoTh1 = document.createTextNode('Código');
                var textoTh2 = document.createTextNode('Descrição');
                var textoTh3 = document.createTextNode('Grupo');
                var textoTh4 = document.createTextNode('Qtd');
                var textoTh5 = document.createTextNode('Estante');
                var textoTh7 = document.createTextNode('#');

                elementoth1.appendChild(textoTh1);
                elementoth2.appendChild(textoTh2);
                elementoth3.appendChild(textoTh3);
                elementoth4.appendChild(textoTh4);
                elementoth5.appendChild(textoTh5);
                elementoth7.appendChild(textoTh7);

                elementoTR.appendChild(elementoth1);
                elementoTR.appendChild(elementoth2);
                elementoTR.appendChild(elementoth3);
                elementoTR.appendChild(elementoth4);
                elementoTR.appendChild(elementoth5);
                elementoTR.appendChild(elementoth7);

                elementoTabelaThead.appendChild(elementoTR);

                for(item of dado.estoque) {
                    if(item.qtd <= 1) {
                        var elementoTr = document.createElement('tr');
                        var elementoTd1 = document.createElement('td');
                        var elementoTd2 = document.createElement('td');
                        var elementoTd3 = document.createElement('td');
                        var elementoTd4 = document.createElement('td');
                        var elementoTd5 = document.createElement('td');
                        var elementoTd6 = document.createElement('td');

                        var textoT1 = document.createTextNode(item.cod_item);
                        var textoT2 = document.createTextNode(item.descricao);
                        if(item.pivot.tipo_estoque_id === 1) {
                            var textoT3 = document.createTextNode('CHAPAS');
                        } else if (item.pivot.tipo_estoque_id === 2) {
                            var textoT3 = document.createTextNode('INFLAMÁVEIS');
                        } else if (item.pivot.tipo_estoque_id === 3) {
                            var textoT3 = document.createTextNode('GERAL');
                        } else {
                            var textoT3 = document.createTextNode('TEXTIL');
                        }
                        var textoT4 = document.createTextNode(item.qtd);
                        if(item.estante == null) {
                            var textoT5 = document.createTextNode('#');
                        } else {
                            var textoT5 = document.createTextNode(item.estante);
                        }

                        var btnPedido = document.createElement('button');
                        var textoBtn2 = document.createTextNode('Pedir');
                        btnPedido.setAttribute('onclick', 'mostrarModal(' + item.id + ')');
                        btnPedido.setAttribute('class', 'btn btn-outline-info w-100');
                        btnPedido.appendChild(textoBtn2);

                        elementoTd1.appendChild(textoT1);
                        elementoTd2.appendChild(textoT2);
                        elementoTd3.appendChild(textoT3);
                        elementoTd4.appendChild(textoT4);
                        elementoTd4.appendChild(textoT4);
                        elementoTd5.appendChild(textoT5);
                        elementoTd6.appendChild(btnPedido);

                        elementoTr.appendChild(elementoTd1);
                        elementoTr.appendChild(elementoTd2);
                        elementoTr.appendChild(elementoTd3);
                        elementoTr.appendChild(elementoTd4);
                        elementoTr.appendChild(elementoTd5);
                        elementoTr.appendChild(elementoTd6);

                        elementoTabelaTbody.appendChild(elementoTr);
                    }
                }

                var textoH5 = document.createTextNode(dado.nome);
                var btnPedidoF = document.createElement('button');
                var textoPedido = document.createTextNode('Pedir Tudo');
                btnPedidoF.setAttribute('onclick', 'pedirTudo(' + dado.id + ')');
                btnPedidoF.setAttribute('class', 'btn btn-outline-info w-100');
                btnPedidoF.appendChild(textoPedido);

                var divRow = document.createElement('div');
                var divCol1 = document.createElement('div');
                var divCol2 = document.createElement('div');

                divRow.setAttribute('class', 'row');
                divCol1.setAttribute('class', 'col');
                divCol2.setAttribute('class', 'col-3 mb-2');

                elementoA.setAttribute('href', '/estoque/estoqueFornecedor/' + dado.id);
                elementoA.appendChild(textoH5);
                elementoH5.appendChild(elementoA);
                elementoH5.setAttribute('class', 'text-center border-bottom mt-3');

                divCol1.appendChild(elementoH5);
                divCol2.appendChild(btnPedidoF);
                divRow.appendChild(divCol1);
                divRow.appendChild(divCol2);

                elementoTabela.appendChild(elementoTabelaThead);
                elementoTabela.appendChild(elementoTabelaTbody);

                divTabela.appendChild(divRow);
                divTabela.appendChild(elementoTabela);
            }
        }

        function chamarRender() {
            axios.get('/api/fornecedor')
            .then(function(response) {
                return renderTabela(response.data);
            })
            .catch(function(erro) {
                alert(erro);
            });
        }

        $(function() {
            chamarRender();
        })
    </script>

@endsection
