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
    </script>
    
@endsection
