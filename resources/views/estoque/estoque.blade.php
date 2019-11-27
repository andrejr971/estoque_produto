@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title"> Itens no estoque</h1>
                </div>
                <div class="col-3">
                    <a href="#" class="btn btn-outline-success w-100" data-toggle="modal" data-target="#modalTipo">Adiciona Item</a>
                </div>
                <div class="col-3">
                    <a href="/fornecedor" class="btn btn-outline-primary w-100"> Fornecedores </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="tabelaEstoque" class="table table-sm table-bordered table-striped table-responsive-sm">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Grupo</th>
                        <th>Código</th>
                        <th>QTD</th>
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
@endsection

@section('javascript')
    <script>
        $('#formTipo').submit(function(event) {
            event.preventDefault();

            if($('#tipo1').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueChapa") }}';
            } else if ($('#tipo2').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueChapa") }}';
            } else if ($('#tipo3').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueChapa") }}';
            } else if ($('#tipo4').prop('checked')) {
                window.location.href = '{{ route("addItemEstoqueChapa") }}';
            } else {
                alert('Selecione uma opção');
            }
        });

        var elementoTable = document.querySelector('#tabelaEstoque tbody')

        function renderChapas(dados) {
                elementoTable.innerHTML = '';
                for(dado of dados) {
                    
                    var trElemento = document.createElement('tr');
                    var tdElemento1 = document.createElement('td');
                    var tdElemento2 = document.createElement('td');
                    var tdElemento3 = document.createElement('td');
                    var tdElemento4 = document.createElement('td');
                    var tdElemento5 = document.createElement('td');
                    var tdElemento6 = document.createElement('td');

                    var texto1 = document.createTextNode(dado.id);
                    var texto2 = document.createTextNode(dado.descricao);
                    var texto4 = document.createTextNode(dado.cod_item);
                    var texto5 = document.createTextNode(dado.qtd);
                    for(tipo of dado.fornecedores) {
                        if(tipo.pivot.tipo_estoque_id == 1) {
                            var texto3 = document.createTextNode('CHAPAS');
                        }
                    }

                    var btnEditar = document.createElement('button');
                    var textoBtn1 = document.createTextNode('Editar');
                    btnEditar.setAttribute('onclick', 'editar(' + dado.id + ')');
                    btnEditar.setAttribute('class', 'btn btn-outline-info');
                    btnEditar.appendChild(textoBtn1);

                    var btnRemover = document.createElement('button');
                    var textoBtn2 = document.createTextNode('Remover');
                    btnRemover.setAttribute('onclick', 'remover(' + dado.id + ')');
                    btnRemover.setAttribute('class', 'btn btn-outline-danger ml-2');
                    btnRemover.appendChild(textoBtn2);

                    tdElemento1.appendChild(texto1);
                    tdElemento2.appendChild(texto2);
                    tdElemento3.appendChild(texto3);
                    tdElemento4.appendChild(texto4);
                    tdElemento5.appendChild(texto5);
                    tdElemento6.appendChild(btnEditar);
                    tdElemento6.appendChild(btnRemover);

                    trElemento.appendChild(tdElemento1);
                    trElemento.appendChild(tdElemento2);
                    trElemento.appendChild(tdElemento3);
                    trElemento.appendChild(tdElemento4);
                    trElemento.appendChild(tdElemento5);
                    trElemento.appendChild(tdElemento6);

                    elementoTable.appendChild(trElemento);
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

            $(function() {
                chamarRender();
            })
    </script>
    
@endsection
