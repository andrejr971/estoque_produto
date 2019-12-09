@extends('layout.index')

@section('conteudo')
    <div class="container mt-2">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Grupos</h1>
            </div>
            <div class="col-3">
                <a href="#" data-toggle="modal" data-target="#modalTipo" class="btn btn-outline-primary w-100"> Novo Grupo </a>
            </div>
        </div>
        
        <hr>
        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelaChapas" class="table table-responsive-sm table-sm table-bordered table-striped mt-3">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Grupo</th>
                                <th>Nota</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTipo" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" id="formTipo">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tipoModal">Novo Grupo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" nome="id">
                        <div class="form-group">
                            <label for="grupo">Nome do grupo</label>
                            <input type="text" class="form-control" id="grupo"  placeholder="Novo Grupo" required>
                        </div>
                        <div class="form-group">
                            <label>Nota</label>
                            <textarea name="nota" id="nota" class="form-control" rows="5"></textarea>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var elementoTable = document.querySelector('#tabelaChapas tbody')

            $('#formTipo').submit(function(event) {
                event.preventDefault();

                if($('#id').val() == '') {
                    grupo = {
                        grupo : $('#grupo').val(),
                        nota : $('#nota').val()
                    }

                    $.post('/api/novoGrupo', grupo, function() {
                        alert('Grupo Cadastrado');
                        $('#grupo').val('');
                        $('#nota').val('');
                        $('#modalTipo').modal('hide');
                        chamarRender(); 
                    });
                } else {
                    salvar($('#id').val());
                }
            });

            function salvar(id) {
                grupo = {
                    grupo : $('#grupo').val(),
                    nota : $('#nota').val()
                }

                $.ajax({
                type: 'PUT',
                url: '/api/novoGrupo/' + id,
                data : grupo,
                context: this,
                success: function(data) {
                    //carregarFornecedores();
                    $('#modalTipo').modal('hide');
                    chamarRender();
                    alert('Grupo Atualizado');
                },
                error: function(error) {
                    console.log(error);
                }
            });
            }

            function ver(id) {
                axios.get('/api/categoria') 
                .then(function(response) {
                    editarGrupo(response.data, id);
                })
                .catch(function(erro) {
                    alert(erro);
                });
            }

            function editarGrupo(dados, id) {
                for(dado of dados) {
                    if(dado.id == id) {
                        $('#id').val(dado.id);
                        $('#grupo').val(dado.descricao);
                        $('#nota').val(dado.nota);

                        $('#modalTipo').modal('show');
                    }
                }
            }

            function renderChapas(dados) {
                elementoTable.innerHTML = '';
                for(dado of dados) {
                    /*for(tipo of dado.fornecedores) {
                        var tipos = tipo.pivot.tipo_estoque_id; 
                    }*/
                    

                    //if(tipos == 4) {
                        var trElemento = document.createElement('tr');
                        var tdElemento1 = document.createElement('td');
                        var tdElemento2 = document.createElement('td');
                        var tdElemento3 = document.createElement('td');
                        var tdElemento4 = document.createElement('td');

                        var texto1 = document.createTextNode(dado.id);
                        var texto2 = document.createTextNode(dado.descricao);

                        if(dado.nota == null) {
                            var texto3 = document.createTextNode('#');
                        } else {
                            var texto3 = document.createTextNode(dado.nota);
                        }

                        var btnEditar = document.createElement('button');
                        var textoBtn1 = document.createTextNode('Ver/Editar');
                        btnEditar.setAttribute('onclick', 'ver(' + dado.id + ')');
                        btnEditar.setAttribute('class', 'btn btn-outline-info w-100');
                        btnEditar.appendChild(textoBtn1);

                        tdElemento1.appendChild(texto1);
                        tdElemento2.appendChild(texto2);
                        tdElemento3.appendChild(texto3);
                        tdElemento4.appendChild(btnEditar);

                        trElemento.appendChild(tdElemento1);
                        trElemento.appendChild(tdElemento2);
                        trElemento.appendChild(tdElemento3);
                        trElemento.appendChild(tdElemento4);
                        elementoTable.appendChild(trElemento);
                    //}
                }
            }

            function chamarRender() {
                axios.get('/api/categoria')
                .then(function(response) {
                    renderChapas(response.data);
                })
                .catch(function(erro) {
                    console.log(erro);
                });
            }

            $(function() {
                chamarRender();
            })

    </script>
@endsection
