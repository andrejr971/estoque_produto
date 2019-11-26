@extends('layout.index', ["current" => "fornecedor"])

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title"> Fornecedores </h1>
                </div>
                <div class="col-3">
                    <a href="#" class="btn btn-outline-success w-100" data-toggle="modal" data-target="#modalFornecedor" onclick="limparCampos()"> Novo Fornecedor </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="tableFornecedor" class="table table-sm table-bordered table-striped table-responsive-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Fornecedor</th>
                        <th>CNPJ</th>
                        <th>Contatos</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modalFornecedor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formFornecedor">
                    <div id class="modal-header bg-success text-light">
                        <h5 class="modal-title" id="titleFornecedor">Fornecedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class="form-group">
                            <label for="Nome">Fornecedor (Razão Social)</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Razão Social" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00) 0000-0000" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Fornecedor (Razão Social)</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="inscricao">Inscrição Estadual</label>
                                    <input type="text" class="form-control" id="inscricao" name="inscricao" placeholder="Inscrição Estadual" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cep">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" required>
                                </div>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="numero">Numero</label>
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero" required>
                                </div>                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="uf">UF</label>
                                    <select name="uf" class="form-control" id="uf">
                                        
                                    </select>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-outline-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('/js/config.js') }}"></script>
@endsection