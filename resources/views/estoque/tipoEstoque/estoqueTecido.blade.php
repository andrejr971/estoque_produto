@extends('layout.index')

@section('conteudo')
    <div class="container mt-2">
        <h1 class="text-center">Estoque de Textil</h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="formChapas">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="tipo" name="tipo" value='4'>
                    <div class="row">
                        <div class="col">
                            <div class="form-group w-100">
                                <label>Descriçao Item <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="EX: TECIDO MOSTARDA" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group w-100">
                                <label>OC <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="EX: 000000" id="oc" name="oc" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group w-100">
                                <label>Metragem <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="metragem" name="metragem" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group w-100">
                                <label>Est. MIN <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="min" name="min" value="1" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group w-100">
                                <label>Est. Ideal <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="ideal" name="ideal" value="10" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group w-100">
                                <label>Código interno (automático)</label>
                                <input type="text" class="form-control" disabled required>
                            </div>
                        </div>
                        <div class="col-2">
                            <label>NCM<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="ncm" name="ncm" placeholder="8 Números" maxlength="8" required>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Fornecedor <span style="color: red;">*</span></label>
                                <select name="fornecedor" id="fornecedor" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Estante <span style="color: red;">*</span></label>
                                <select name="estante" id="estante" class="form-control">
                                    @foreach ($estantes as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group w-100">
                                <label>Un. Medida<span style="color: red;">*</span></label>
                                <select name="unidade" id="unidade" class="form-control">
                                    <option value="UN">UN</option>
                                    <option value="CX">CX</option>
                                    <option value="RL">RL</option>
                                    <option value="MT" selected>MT</option>
                                    <option value="LT">LT</option>
                                    <option value="ML">ML</option>
                                    <option value="KG">KG</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
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
                        <div class="col-3">
                            <div class="form-group w-100">
                                <label>Pedido<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="pedido" name="pedido" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group w-100">
                                <label>Preço<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="preco" name="preco" maxlength="8" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-outline-primary w-100">Cadastrar</button>
                        </div>
                        <div class="col">
                            <a href="/estoque" class="btn btn-outline-danger w-100">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelaChapas" class="table table-responsive-sm table-sm table-bordered table-striped mt-3">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Código</th>
                                <th>Metragem</th>
                                <th>Reservado Pedido</th>
                                <th>Estante</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
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

        var selectElement = document.querySelector('#fornecedor');
        var elementoTable = document.querySelector('#tabelaChapas tbody')

            axios.get('/api/fornecedor') 
                .then(function(response) {
                    carregarFornecedores(response.data);
                })
                .catch(function(erro) {
                    alert(erro);
                });
            
            function carregarFornecedores(dados) {
                for(dado of dados) {
                    var optionElement = document.createElement('option');
                    var textOption = document.createTextNode(dado.nome);

                    optionElement.setAttribute('value', dado.id);
                    optionElement.appendChild(textOption);

                    selectElement.appendChild(optionElement);
                }
            }

            function renderChapas(dados) {
                elementoTable.innerHTML = '';
                for(dado of dados) {
                    for(tipo of dado.fornecedores) {
                        var tipos = tipo.pivot.tipo_estoque_id; 
                    }

                    if(tipos == 4) {
                        var trElemento = document.createElement('tr');
                        var tdElemento1 = document.createElement('td');
                        var tdElemento2 = document.createElement('td');
                        var tdElemento3 = document.createElement('td');
                        var tdElemento4 = document.createElement('td');
                        var tdElemento5 = document.createElement('td');
                        var tdElemento6 = document.createElement('td');

                        var texto1 = document.createTextNode(dado.id);
                        var texto2 = document.createTextNode(dado.descricao);
                        var texto3 = document.createTextNode(dado.cod_item);
                        var texto4 = document.createTextNode(dado.metragem + ' ' + dado.un_medida);
                        var texto5 = document.createTextNode(dado.pedido);
                        
                        var texto6 = document.createTextNode(dado.estante);

                        tdElemento1.appendChild(texto1);
                        tdElemento2.appendChild(texto2);
                        tdElemento3.appendChild(texto3);
                        tdElemento4.appendChild(texto4);
                        tdElemento5.appendChild(texto5);
                        tdElemento6.appendChild(texto6);

                        trElemento.appendChild(tdElemento1);
                        trElemento.appendChild(tdElemento2);
                        trElemento.appendChild(tdElemento3);
                        trElemento.appendChild(tdElemento4);
                        trElemento.appendChild(tdElemento5);
                        trElemento.appendChild(tdElemento6);

                        elementoTable.appendChild(trElemento);
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

            function novoItem() {
                infla = {
                    nome : $('#nome').val(),
                    unidade : $('#unidade').val(),
                    ncm : $('#ncm').val(),
                    metragem : $('#metragem').val(),
                    min : $('#min').val(),
                    ideal : $('#ideal').val(),
                    estante : $('#estante').val(),
                    oc : $('#oc').val(),
                    reservado : $('input[name="reservado"]:checked').val(),
                    pedido : $('#pedido').val(),
                    preco : $('#preco').val(),
                    tipo : '4',
                    fornecedor : $('#fornecedor').val()
                }

                $.post('/api/estoque', infla, function() {
                    alert('Item Cadastrado');
                    chamarRender();   
                    limpezaInput();
                });
    
            }

            function limpezaInput() {
                $('#nome').val('');
                $('#ncm').val('');
                $('#metragem').val('');
                $('#min').val('');
                $('#ideal').val('');
                $('#oc').val('');
                $('#pedido').val('');
                $('#preco').val('');
            }

            $('#formChapas').submit(function(event) {
                event.preventDefault();

                if($('#id').val() != '') {
                    atualizarItem();
                } else {
                    novoItem();
                }
            });

            $(function() {
                chamarRender();
            })

    </script>
@endsection
