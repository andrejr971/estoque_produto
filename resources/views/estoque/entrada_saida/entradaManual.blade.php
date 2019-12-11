@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title">Entrada</h1>
                </div>
                <div class="col-3">
                    <a href="/estoque/ver" class="btn btn-outline-primary w-100">Ver Estoque</a>
                </div>
            </div>
        </div>
        <form action="{{ route('adicionarEntradaManual') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row mb-3">
                    <div class="w-100 bg-success mt-3 mb-3" style="height: 5px;"></div>
                    <div class="col">
                        <div class="form-group">
                            <label>Fornecedor <span style="color: red;">*</span></label>
                            <select name="fornecedor" id="fornecedor" class="form-control">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group xml">
                            <div class="row">
                                <div class="w-100 ml-3">
                                    <label>Nota Fiscal (DANFE)<span style="color: red;">*</span></label>
                                </div>
                                <div class="col">
                                    <input type="file" name="upFile" accept=".xml, .pdf" required>  
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success w-100">Finalizar Entrada</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="w-100 bg-dark mt-3 mb-3" style="height: 5px;"></div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Produto</label>
                            <select name="produto" id="produto" class="form-control" required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Quantidade</label>
                            <input type="number" name="qtd" id="qtd" value="1" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <a href="/estoque" class="btn btn-danger w-100">Cancelar</a>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-info w-100" id="add_list">Add Lista</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-7">
                        <label>Nota (Opcional)</label>
                        <textarea name="nota" id="nota" rows="3" maxlength="140" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <table class="table" id="tabelaLista">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Valor Un.</th>
                                <th>Valor</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
        
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modalEscolha" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal" id="formEntrada">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="tipoModal">Deseja continuar de onde parou?</h5>
                        </div>
                        <div class="modal-body">
                            <p><i>Nota:</i><br>
                            Irá Perder tudo o que você tinha feito da última vez</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" id="btnSim">Sim</button>
                            <button type="button" class="btn btn-outline-danger" id="btnNao">Não</button>
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

        var selectElement = document.querySelector('#fornecedor');
        var selectElement2 = document.querySelector('#produto');
        var elementoTable = document.querySelector('#tabelaLista tbody')

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

        $('#fornecedor').change(function(){
            selectElement2.innerHTML = '';
            fornecedorSel = $('#fornecedor option:selected').val();

            axios.get('/api/fornecedor')
                .then(function(response) {
                    //console.log(response.data)
                    for(teste of response.data) {
                        if(teste.id == fornecedorSel) {
                            for(t of teste.estoque) {
                                //console.log(t.descricao);
                                var optionElement = document.createElement('option');
                                var textOption = document.createTextNode(t.descricao);

                                optionElement.setAttribute('value', t.id);
                                optionElement.appendChild(textOption);

                                selectElement2.appendChild(optionElement);
                            }
                        }
                    }
                })
                .catch(function(erro) {
                    alert(erro);
                });
        });

        function carregamento() {
            axios.get('/api/add_list') 
                .then(function(response) {
                    carregarTabela(response.data);
                })
                .catch(function(erro) {
                    alert(erro);
                });
        }

        function formatNumber(num) {
            return (
                num
                .toFixed(2) // always two decimal digits
                .replace('.', ',') // replace decimal point character with ,
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            ); // use . as a separator
        }

        function remover(id) {
            $.ajax({
                type: 'DELETE',
                url: '/api/remover_list/' + id,
                context: this,
                success: function() {
                    carregamento();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function carregarTabela(dados) {
            elementoTable.innerHTML = '';
            for(dado of dados) {
                $('#fornecedor').val(dado.fornecedor_id);

                var trElemento = document.createElement('tr');
                var tdElemento1 = document.createElement('td');
                var tdElemento2 = document.createElement('td');
                var tdElemento3 = document.createElement('td');
                var tdElemento4 = document.createElement('td');
                var tdElemento5 = document.createElement('td');
                var tdElemento6 = document.createElement('td');

                var texto1 = document.createTextNode(dado.cod_prod);
                var texto2 = document.createTextNode(dado.nome);
                var texto3 = document.createTextNode(dado.qtd);
                var texto4 = document.createTextNode('R$ ' + formatNumber(dado.preco));
                let valorTotal = dado.qtd * dado.preco;
                var texto5 = document.createTextNode('R$ ' + formatNumber(valorTotal));

                var btnRemover = document.createElement('button');
                var textoBtn2 = document.createTextNode('Remover');
                btnRemover.setAttribute('onclick', 'remover(' + dado.id + ')');
                btnRemover.setAttribute('type', 'button');
                btnRemover.setAttribute('class', 'btn btn-outline-danger ml-2 w-100');
                btnRemover.appendChild(textoBtn2);
                
                tdElemento1.appendChild(texto1);
                tdElemento2.appendChild(texto2);
                tdElemento3.appendChild(texto3);
                tdElemento4.appendChild(texto4);
                tdElemento5.appendChild(texto5);
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

        function verificacao(cod_prod, frodo, fornecedor) {
            axios.get('/api/add_list') 
                .then(function(response) {
                    existe = 0;
                    fexiste = 0;
                    for(dados of response.data) {
                        if(dados.cod_prod == cod_prod) {
                            existe = 1;
                        } else if(dados.fornecedor_id != fornecedor) {
                            fexiste = 1;
                        }
                    }
                    
                    if(fexiste ==  0) {
                        if(existe == 0) {
                            $.ajax({
                                type: 'POST',
                                url: '/api/add_list',
                                data : frodo,
                                context: this,
                                success: function(data) {
                                    $('#qtd').val(1);
                                    carregamento();
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        } else {
                            alert('Item já adicionado na lista');
                        } 
                    } else {
                        alert('Só pode adicionar item, por um fornecedor por vez');
                    }
                })
                .catch(function(erro) {
                    alert(erro);
                });
        }

        $(document).ready(function() {
            $('#add_list').click(function() {
                frodo = {
                    produto : $('#produto').val(),
                    qtd : $('#qtd').val(),
                    nota : $('#nota').val(),
                    fornecedor : $('#fornecedor').val(),
                }

                verificacao($('#produto').val(), frodo, $('#fornecedor').val());
               
            });

            $('#btnSim').click(function() {
                carregamento();
                $('#modalEscolha').modal('hide');
            });

            
            $('#btnNao').click(function() {
                $.ajax({
                    type: 'DELETE',
                    url: '/api/remover_list',
                    context: this,
                    success: function() {
                        $('#modalEscolha').modal('hide');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        $(function() {
            axios.get('/api/add_list') 
                .then(function(response) {
                    var dados = response.data;
                    if(dados.length > 0) {
                        $('#modalEscolha').modal('show');
                    }
                })
                .catch(function(erro) {
                    alert(erro);
                });
        });
    </script>
@endsection