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
                        <hr>
                            <div class="form-group" id="itens_relacionados">

                            </div>
                        <hr>
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

    <div class="modal fade" id="modalItens" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div id class="modal-header bg-info text-light">
                        <h5 class="modal-title" id="titleFornecedor">Itens Relacionados com o Fornecedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="tableFornecedorItens" class="table table-sm table-bordered table-striped table-responsive-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Itens</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                    </div>
            </div>
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
                                    <input type="text" class="form-control" id="descricao" name="descricao">
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
    <script src="{{ asset('/js/config.js') }}"></script>
@endsection