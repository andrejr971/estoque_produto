@extends('layout.index')

@section('conteudo')
    <div class="container mt-2">
        <h1 class="text-center">Estoque Chapas</h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="formChapas">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="tipo" name="tipo" value='1'>
                    <div class="row">
                        <div class="col">
                            <div class="form-group w-100">
                                <label>Descriçao Item <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="EX: BRANCO TX" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group w-100">
                                <label>Quantidade <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="qtd" name="qtd" required>
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
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group w-100">
                                <label>Un. Medida<span style="color: red;">*</span></label>
                                <select name="unidade" id="unidade" class="form-control">
                                    <option value="UN" selected>UN</option>
                                    <option value="CX">CX</option>
                                    <option value="RL">RL</option>
                                    <option value="MT">MT</option>
                                    <option value="LT">LT</option>
                                    <option value="ML">ML</option>
                                    <option value="KG">KG</option>
                                </select>
                            </div>
                        </div>
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
                                <label>Preço<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="preco" name="preco" maxlength="8" required>
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
                                <th>Quantidade</th>
                                <th>Fornecedor</th>
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

                    if(tipos == 1) {
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
                        var texto4 = document.createTextNode(dado.qtd);
                        for(fornecedor of dado.fornecedores) {
                            var texto5 = document.createTextNode(fornecedor.nome);
                        }

                        tdElemento1.appendChild(texto1);
                        tdElemento2.appendChild(texto2);
                        tdElemento3.appendChild(texto3);
                        tdElemento4.appendChild(texto4);
                        tdElemento5.appendChild(texto5);

                        trElemento.appendChild(tdElemento1);
                        trElemento.appendChild(tdElemento2);
                        trElemento.appendChild(tdElemento3);
                        trElemento.appendChild(tdElemento4);
                        trElemento.appendChild(tdElemento5);

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
                chapa = {
                    nome : $('#nome').val(),
                    unidade : $('#unidade').val(),
                    ncm : $('#ncm').val(),
                    qtd : $('#qtd').val(),
                    min : $('#min').val(),
                    ideal : $('#ideal').val(),
                    largura : $('#largura').val(),
                    altura : $('#altura').val(),
                    espessura : $('#espessura').val(),
                    preco : $('#preco').val(),
                    tipo : '1',
                    fornecedor : $('#fornecedor').val()
                }

                $.post('/api/estoque', chapa, function() {
                    alert('Item Cadastrado');
                    chamarRender();   
                    limpezaInput();
                });
    
            }

            function limpezaInput() {
                $('#nome').val('');
                $('#ncm').val('');
                $('#qtd').val('');
                $('#min').val('');
                $('#ideal').val('');
                $('#largura').val('');
                $('#altura').val('');
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
