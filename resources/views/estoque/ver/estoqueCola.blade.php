@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title"> Chapas no Estoque </h1>
                </div>
                <div class="col-3">
                    <a href="#" class="btn btn-outline-success w-100" data-toggle="modal" data-target="#modalTipo">Adicionar Item</a>
                </div>
                <div class="col-3">
                    <a href="/fornecedor" class="btn btn-outline-primary w-100"> Fornecedores </a>
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
            <table id="tabelaEstoque" class="table table-sm table-bordered table-striped table-responsive-sm">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Grupo</th>
                        <th>Código</th>
                        <th>QTD</th>
                        <th>Estante</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modalTipo" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" id="formTipo">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tipoModal">Escolha uma opção</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="1" checked>
                            <label class="form-check-label" for="tipo1">
                                Adicionar Estoque de Chapas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="2">
                            <label class="form-check-label" for="tipo2">
                                Adicionar Estoque de Inflamaveis
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo3" value="3">
                            <label class="form-check-label" for="tipo3">
                                Adicionar Estoque Geral
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo4" value="4">
                            <label class="form-check-label" for="tipo4">
                                Adicionar Estoque Tecido/Costura
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-outline-primary">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="editarModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" id="formEditar" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-light" id="tiruloEditar">Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="fornecedor_id" name="fornecedor_id">
                        <input type="hidden" id="tipo_estoque_id" name="tipo_estoque_id">
                        <input type="hidden" id="estoque_id" name="estoque_id">
                        <input type="hidden" id="cod1" name="cod_item">

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Descrição</label>
                                    <input type="text" class="form-control" id="nome" name="descricao">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">COD_ITEM</label>
                                    <input type="text" class="form-control" id="cod" name="cod_item" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="ean" id="labelEan">EAN - Código de barras</label>
                                    <input type="text" class="form-control" id="ean" name="ean_item">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Quantidade</label>
                                    <input type="number" class="form-control" name="qtd" id="qtd">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="min">Est. MIN</label>
                                    <input type="number" class="form-control" id="min" name="estoque_min">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Est. Ideal</label>
                                    <input type="number" class="form-control" name="estoque_max" id="ideal">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="ncm">NCM</label>
                                    <input type="text" class="form-control" id="ncm" name="ncm_item">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Fornecedor <span style="color: red;">*</span></label>
                                    <select name="fornecedor" id="fornecedor" class="form-control">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Un. Medida<span style="color: red;">*</span></label>
                                    <select name="un_medida" id="unidade" class="form-control">
                                        <option value="UN">UN</option>
                                        <option value="CX" selected>CX</option>
                                        <option value="RL">RL</option>
                                        <option value="MT">MT</option>
                                        <option value="LT">LT</option>
                                        <option value="ML">ML</option>
                                        <option value="KG">KG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Estante <span style="color: red;">*</span></label>
                                    <select name="estante" id="estante" class="form-control" required>
                                        @foreach ($estantes as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Largura<span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="largura" name="largura" maxlength="8" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Altura<span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="altura" name="altura" maxlength="8" required>
                                </div>    
                            </div>
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Espessura<span style="color: red;">*</span></label>
                                    <select name="espessura" id="espessura" class="form-control">
                                        <option value="4mm">4mm</option>
                                        <option value="6mm">6mm</option>
                                        <option value="9mm">9mm</option>
                                        <option value="12mm">12mm</option>
                                        <option value="15mm">15mm</option>
                                        <option value="18mm">18mm</option>
                                        <option value="25mm">25mm</option>
                                        <option value="35mm">35mm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Reservado<span style="color: red;">*</span></label>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="reservado" id="reservado1" value="1">
                                                <label class="form-check-label" for="reservado1">
                                                    Sim
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="reservado" id="reservado0" value="0">
                                                <label class="form-check-label" for="reservado0">
                                                    Não
                                                </label>
                                            </div>                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Pedido<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="pedido" name="pedido" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Volume<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="EX: 5L" id="volume" name="vol" maxlength="8" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group w-100">
                                    <label>Preço<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="preco" name="preco" maxlength="8" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-outline-danger" id="excluir">Excluir</button>
                        <button type="submit" class="btn btn-outline-primary">Atualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('#formTipo').submit(function(event) {
            event.preventDefault();

            if($('#tipo1').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueChapa") }}';
            } else if ($('#tipo2').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueInfla") }}';
            } else if ($('#tipo3').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueGeral") }}';
            } else if ($('#tipo4').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueTextil") }}';
            } else {
                alert('Selecione uma opção');
            }
        });

        var elementoTable = document.querySelector('#tabelaEstoque tbody');

        function ver(id) {
            axios.get('/api/estoque')
                .then(function(response) {
                    editar(response.data, id);
                })
                .catch(function(erro) {
                    alert(erro);
                });
            
            //$('#modalEditar').modal('show');
        }

        var selectElement = document.querySelector('#fornecedor');

        function carregarFornecedores(dados, id) {
            selectElement.innerHTML = '';
            for(dado of dados) {
                var optionElement = document.createElement('option');
                var textOption = document.createTextNode(dado.nome);

                optionElement.setAttribute('value', dado.id);
                optionElement.appendChild(textOption);

                selectElement.appendChild(optionElement);

                for(estoque of dado.estoque) {
                    if(id === estoque.id) {
                        $('#fornecedor').val($('option:contains("' + dado.id + '")').val());
                    }
                }
            }
        }

        function editar(dados, id) {

            axios.get('/api/fornecedor') 
                .then(function(response) {
                    carregarFornecedores(response.data, id);
                })
                .catch(function(erro) {
                    alert(erro);
                });

            for(dado of dados) {
                if(dado.id == id) {
                    $('#nome').val(dado.descricao);
                    $('#cod').val(dado.cod_item);
                    $('#cod1').val(dado.cod_item);
                    $('#estoque_id').val(dado.id);
                
                    if(dado.ean_item == null) {
                        $('#ean').val('');
                        $('#ean').prop('disabled', true);
                    } else {
                        $('#ean').prop('disabled', false);
                        $('#ean').val(dado.ean_item);
                    }

                    $('#qtd').val(dado.qtd);
                    $('#min').val(dado.estoque_min);
                    $('#ideal').val(dado.estoque_max);
                    $('#ncm').val(dado.ncm_item);

                    for(fornecedor of dado.fornecedores) { 
                        $('#fornecedor_id').val(fornecedor.id);
                        $('#tipo_estoque_id').val(fornecedor.pivot.tipo_estoque_id);
                    }
                    $('#unidade').val($('option:contains("' + dado.un_medida + '")').val());
                    
                    if(dado.estante == null) {
                        $('#estante').val('');
                        $('#estante').prop('disabled', true);
                    } else {
                        
                        $('#estante').prop('disabled', false);
                        $('#estante').val($('option:contains("' + dado.estante + '")').val());
                    }

                    if(dado.largura == null) {
                        $('#largura').val('');
                        $('#altura').val('');

                        $('#largura').prop('disabled', true);
                        $('#altura').prop('disabled', true);
                        $('#espessura').prop('disabled', true);
                    } else {
                        
                        $('#largura').prop('disabled', false);
                        $('#altura').prop('disabled', false);
                        $('#espessura').prop('disabled', false);

                        $('#largura').val(dado.largura);
                        $('#altura').val(dado.altura);
                        $('#espessura').val($('option:contains("' + dado.espessura + '")').val());
                    }

                    if(dado.reservado == null) {
                        $('#reservado1').prop('disabled', true);
                        $('#reservado0').prop('disabled', true);

                        $('#pedido').prop('disabled', true);
                    } else {
                        $('#reservado1').prop('disabled', false);
                        $('#reservado0').prop('disabled', false);

                        $('#pedido').prop('disabled', false);
                        if(dado.reservado == 1) {
                            $('#reservado1').filter('[value="1"]').attr('checked', true);
                        } else {
                            $('#reservado0').filter('[value="0"]').attr('checked', true);
                        } 

                        $('#pedido').val(dado.pedido);
                    }

                    if(dado.vol == null) {
                        $('#volume').val('');
                        $('#volume').prop('disabled', true);
                    } else {
                        $('#volume').prop('disabled', true);

                        $('#volume').val(dado.vol);
                    }

                    $('#preco').val(dado.preco);
                    var buttonExcluir = document.querySelector('#excluir');
                    buttonExcluir.setAttribute('onclick', 'remover(' + dado.id + ')');

                    var form = document.querySelector('#formEditar');
                    form.setAttribute('action', '/estoque/'+dado.id);

                }
            }

            $('#modalEditar').modal('show');
        }

        function remover(id) {
            teste = {
                fornecedor_id : $('#fornecedor_id')
            }
            $.ajax({
                type: 'DELETE',
                url: '/api/estoque/' + id,
                dado: fornecedor_id,
                context:this,
                success: function(data) {
                    $('#modalEditar').modal('hide');
                    chamarRender();
                    alert('Item Removido');
                },
                error: function(erro) {
                    alert(erro);
                }
            });
        }

        function renderChapas(dados) {
            //console.log(dados);
                elementoTable.innerHTML = '';
                for(dado of dados) {
                    for(tipo of dado.fornecedores) {
                        if(tipo.pivot.tipo_estoque_id === 2) {

                            var trElemento = document.createElement('tr');
                            var tdElemento1 = document.createElement('td');
                            var tdElemento2 = document.createElement('td');
                            var tdElemento3 = document.createElement('td');
                            var tdElemento4 = document.createElement('td');
                            var tdElemento5 = document.createElement('td');
                            var tdElemento6 = document.createElement('td');
                            var tdElemento7 = document.createElement('td');

                            var texto1 = document.createTextNode(dado.id);
                            var texto2 = document.createTextNode(dado.descricao);
                            var texto4 = document.createTextNode(dado.cod_item);
                            var texto5 = document.createTextNode(dado.qtd + ' ' + dado.un_medida);
                            for(tipo of dado.fornecedores) {
                                if(tipo.pivot.tipo_estoque_id === 1) {
                                    var texto3 = document.createTextNode('CHAPAS');
                                } else if (tipo.pivot.tipo_estoque_id === 2) {
                                    var texto3 = document.createTextNode('INFLAMÁVEIS'); 
                                } else if (tipo.pivot.tipo_estoque_id === 3) {
                                    var texto3 = document.createTextNode('GERAL'); 
                                } else {
                                    var texto3 = document.createTextNode('TEXTIL');
                                }
                            }

                            if(dado.estante === null) {
                                var texto6 = document.createTextNode('#');
                            } else {
                                var texto6 = document.createTextNode(dado.estante);
                            }

                            var btnEditar = document.createElement('button');
                            var textoBtn1 = document.createTextNode('Ver/Editar');
                            btnEditar.setAttribute('onclick', 'ver(' + dado.id + ')');
                            btnEditar.setAttribute('class', 'btn btn-outline-info w-100');
                            btnEditar.appendChild(textoBtn1);

                            /*var btnRemover = document.createElement('button');
                            var textoBtn2 = document.createTextNode('Remover');
                            btnRemover.setAttribute('onclick', 'remover(' + dado.id + ')');
                            btnRemover.setAttribute('class', 'btn btn-outline-danger ml-2');
                            btnRemover.appendChild(textoBtn2);*/

                            tdElemento1.appendChild(texto1);
                            tdElemento2.appendChild(texto2);
                            tdElemento3.appendChild(texto3);
                            tdElemento4.appendChild(texto4);
                            tdElemento5.appendChild(texto5);
                            tdElemento6.appendChild(texto6);
                            tdElemento7.appendChild(btnEditar);
                            //tdElemento7.appendChild(btnRemover);

                            trElemento.appendChild(tdElemento1);
                            trElemento.appendChild(tdElemento2);
                            trElemento.appendChild(tdElemento3);
                            trElemento.appendChild(tdElemento4);
                            trElemento.appendChild(tdElemento5);
                            trElemento.appendChild(tdElemento6);
                            trElemento.appendChild(tdElemento7);

                            elementoTable.appendChild(trElemento);
                        }
                    }
                }
        }

        function chamarRender() {
            axios.get('/api/estoque')
            .then(function(response) {
                renderChapas(response.data);
            })
            .catch(function(erro) {
                alert(erro);
            });
        }

        /*$('#formEditar').submit(function(event) {
            atualizarItem();
        });*/

        $(function() {
            chamarRender();
        })
    </script>
    
@endsection
