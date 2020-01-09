@extends('layout.index')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.core.bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ui-autocomplete{
            z-index: 1050 !important;
        }
    </style>
@endpush

@section('conteudo')
    <div class="card">
        <!--<form id="formProduto" enctype="multipart/form-data">-->
            <div class="card-header">
                <h1 class="card-title">Produto: {{ $produto->descricao }} - id: {{ $produto->id }}</h1>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Gerais</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Materias</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false" onclick="calcularProd()">Valores e taxas</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        {{-- <form action="{{ route('salvarFornecido') }}" method="POST" enctype="multipart/form-data"> --}}
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    @csrf
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Detalhes do Produto</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="nome">Nome do Produto<span style="color: red;">*</span></label>
                                                <input type="text" name="nome" id="nome" value="{{ $produto->descricao }}" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="sku">SKU</label>
                                                        <input type="text" name="sku" id="sku" value="{{ $produto->sku }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="qtd">Quantidade<span style="color: red;">*</span></label>
                                                        <input type="text" name="qtd" id="qtd" value="{{ $produto->quantidade }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="categoria">Categoria<span style="color: red;">*</span></label>
                                                        <select class="custom-select" name="categoria" id="categoria">
                                                            @foreach ($categorias as $grupo)
                                                                <optgroup label="{{ $grupo->nome }}">
                                                                    @foreach ($grupo->categoria as $categoria)
                                                                        @if ($categoria->id == $produto->categoria_produto_id)
                                                                            <option value="{{ $categoria->id }}" selected>{{ $categoria->nome }}</option>
                                                                        @else
                                                                            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                                                        @endif
                                                                    @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="file" id="demo" class="dropify" name="imagem" src="{{ asset('/storage/'.$produto->img01) }}" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="2M" data-height="150">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Medidas e Obeservações</h5>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($produto->medidas as $medida)
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="largura">Largura (L)<span style="color: red;">*</span></label>
                                                            <input type="text" name="largura" id="largura" value="{{ $medida->largura }}" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="altura">Altura (A)<span style="color: red;">*</span></label>
                                                            <input type="text" name="altura" id="altura" value="{{ $medida->altura }}" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="profundidade">Profundidade (P)<span style="color: red;">*</span></label>
                                                            <input type="text" name="profundidade" id="profundidade" value="{{ $medida->profundidade }}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="obs">Obeservações</label>
                                                        <textarea name="obs" id="obs" value="{{ $produto->observacao }}" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer mt-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-outline-info w-100">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title">Relacionamento de Produto</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="javascript:void(0)" id="addMaterial" data-toggle="collapse" data-target="#divMaterial" class="btn btn-info w-100">Adicionar Material</a>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse m-3" id="divMaterial">
                                <div class="card card-body">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info text-info" onclick="abrirModal('M2')" id="pills-m2-tab">M <sup>2</sup></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2 text-info" onclick="abrirModal('M3')" id="pills-m3-tab">M <sup>3</sup></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2 text-info" onclick="abrirModal('MTL')" id="pills-mlienar-tab">MT Linear</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2 text-info" onclick="abrirModal('UN')" id="pills-unid-tab">Unid.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2 text-info" onclick="abrirModal('KG')" id="pills-kg-tab">KG</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2 text-info" onclick="abrirModal('LT')" id="pills-lt-tab">LT</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">

                                <table class="table mt-3" id="tabelaLista">
                                    <thead>
                                        <tr>
                                            <th>Descrição</th>
                                            <th>Materia Prima</th>
                                            <th data-breakpoints="xs">Quantidade</th>
                                            <th data-breakpoints="xs sm">Valor</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <nav id="paginator">
                                    <ul class="pagination">

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Preço</label>
                                    <input type="text" name="preco_prod" id="preco_prod" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>IPI</label>
                                    <input type="text" name="ipi" id="ipi" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Frete</label>
                                    <input type="text" name="frete" id="frete" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Markup</label>
                                    <input type="text" name="markup" id="markup" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--</form>-->
    </div>

    <div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterial">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida">
                <input type="hidden" name="produto_id" id="produto_id" value="{{ $produto->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descrição<span style="color: red;">*</span></label>
                                    <input type="text" name="desc2" id="nome2" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantidade<span style="color: red;">*</span></label>
                                    <input type="text" name="qtd2" id="qtd2" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="largura1">Largura<span style="color: red;">*</span></label>
                                    <input type="text" name="largura1" id="largura1" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="altura1">Altura<span style="color: red;">*</span></label>
                                    <input type="text" name="altura1" id="altura1" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricao" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaM()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="w-100" id="resultado">

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrição<span style="color: red;">*</span></label>
                                            <input type="text" name="descricao2" id="descricao2" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fornecedor<span style="color: red;">*</span></label>
                                            <input type="text" name="buscaFornecedor" id="fornecedorM2" class="form-control buscaFornecedor">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Largura<span style="color: red;">*</span></label>
                                            <input type="text" name="largura2" id="largura2" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Altura<span style="color: red;">*</span></label>
                                            <input type="text" name="altura2" id="altura2" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Valor<span style="color: red;">*</span></label>
                                            <input type="text" name="preco2" id="preco2" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalMaterialM3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterialM3">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida_m3">
                <input type="hidden" name="produto_id" id="produto_id_m3" value="{{ $produto->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descrição<span style="color: red;">*</span></label>
                                    <input type="text" name="nome_m3" id="nome_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantidade<span style="color: red;">*</span></label>
                                    <input type="text" name="qtd_m3" id="qtd_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="largura1">Largura<span style="color: red;">*</span></label>
                                    <input type="text" name="largura_m3" id="largura_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="altura1">Altura<span style="color: red;">*</span></label>
                                    <input type="text" name="altura_m3" id="altura_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="altura1">Profundidade<span style="color: red;">*</span></label>
                                    <input type="text" name="profundidade_m3" id="profundidade_m3" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricao_m3" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaM3()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="w-100" id="resultado_m3">

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrição<span style="color: red;">*</span></label>
                                            <input type="text" name="descricao_m3" id="descricao_m3" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fornecedor<span style="color: red;">*</span></label>
                                            <input type="text" name="buscaFornecedor" id="fornecedorM3" class="form-control buscaFornecedor">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Largura<span style="color: red;">*</span></label>
                                            <input type="text" name="larg_m3" id="larg_m3" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Altura<span style="color: red;">*</span></label>
                                            <input type="text" name="alt_m3" id="alt_m3" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Profundidade<span style="color: red;">*</span></label>
                                            <input type="text" name="prof_m3" id="prof_m3" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Valor<span style="color: red;">*</span></label>
                                            <input type="text" name="pre_m3" id="pre_m3" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalMaterialMTL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterialMTL">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida_mtl">
                <input type="hidden" name="produto_id" id="produto_id_mtl" value="{{ $produto->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descrição<span style="color: red;">*</span></label>
                                    <input type="text" name="nome_mtl" id="nome_mtl" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="largura1">Metragem <span style="color: red;">*</span></label>
                                    <input type="text" name="metragem_mtl" id="metragem_mtl" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricao_mtl" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaMTL()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="w-100" id="resultado_mtl">

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrição<span style="color: red;">*</span></label>
                                            <input type="text" name="descricao_mtl" id="descricao_mtl" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fornecedor<span style="color: red;">*</span></label>
                                            <input type="text" name="buscaFornecedor" id="fornecedorMtl" class="form-control buscaFornecedor">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Metragem <span style="color: red;">*</span></label>
                                            <input type="text" name="met_mtl" id="met_mtl" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Valor<span style="color: red;">*</span></label>
                                            <input type="text" name="pre_mtl" id="pre_mtl" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalMaterialUN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterialUN">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida_mtl">
                <input type="hidden" name="produto_id" id="produto_id_un" value="{{ $produto->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descrição<span style="color: red;">*</span></label>
                                    <input type="text" name="nome_un" id="nome_un" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="largura1">Quantidade <span style="color: red;">*</span></label>
                                    <input type="number" name="qtd_un" id="qtd_un" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricao_un" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaUN()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="w-100" id="resultado_un">

                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input tipo" type="radio" name="tipo[]" id="tipo1" value="1" required>
                                            <label class="form-check-label" for="tipo1">
                                                Unidade
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input tipo" type="radio" name="tipo[]" id="tipo2" value="2" required>
                                            <label class="form-check-label" for="tipo2">
                                                Rolo
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input tipo" type="radio" name="tipo[]" id="tipo3" value="3" required>
                                            <label class="form-check-label" for="tipo3">
                                                Mil
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input tipo" type="radio" name="tipo[]" id="tipo4" value="4" required>
                                            <label class="form-check-label" for="tipo4">
                                                PC
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input tipo" type="radio" name="tipo[]" id="tipo5" value="5" required>
                                            <label class="form-check-label" for="tipo5">
                                                Caixa
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrição<span style="color: red;">*</span></label>
                                            <input type="text" name="descricao_un" id="descricao_un" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fornecedor<span style="color: red;">*</span></label>
                                            <input type="text" name="buscaFornecedor" id="fornecedorUn" class="form-control buscaFornecedor">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Quantidade <span style="color: red;">*</span></label>
                                            <input type="text" name="qtd_unidade" id="qtd_unidade" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Valor<span style="color: red;">*</span></label>
                                            <input type="text" name="pre_un" id="pre_un" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalMaterialKG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterialKG">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida_kg">
                <input type="hidden" name="produto_id" id="produto_id_kg" value="{{ $produto->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descrição<span style="color: red;">*</span></label>
                                    <input type="text" name="nome_kg" id="nome_kg" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="largura1">Quantidade <span style="color: red;">*</span></label>
                                    <input type="text" name="qtd_kg" id="qtd_kg" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricao_kg" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaKG()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="w-100" id="resultado_kg">

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrição<span style="color: red;">*</span></label>
                                            <input type="text" name="descricao_kg" id="descricao_kg" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fornecedor<span style="color: red;">*</span></label>
                                            <input type="text" name="buscaFornecedor" id="fornecedorKg" class="form-control buscaFornecedor">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Quantidade <span style="color: red;">*</span></label>
                                            <input type="text" name="qtd_kilo" id="qtd_kilo" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Volume <span style="color: red;">*</span></label>
                                            <input type="text" name="vol_kg" id="vol_kg" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Valor<span style="color: red;">*</span></label>
                                            <input type="text" name="pre_kg" id="pre_kg" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalMaterialLT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterialLT">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida_lt">
                <input type="hidden" name="produto_id" id="produto_id_lt" value="{{ $produto->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descrição<span style="color: red;">*</span></label>
                                    <input type="text" name="nome_lt" id="nome_lt" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="largura1">Quantidade <span style="color: red;">*</span></label>
                                    <input type="text" name="qtd_lt" id="qtd_lt" class="form-control" required>
                                    <small><a href="javascript:void(0)" onclick="abrirModal('CALC')">Calcular Consumo</a></small>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom mb-2"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricao_lt" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaLT()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="w-100" id="resultado_lt">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrição<span style="color: red;">*</span></label>
                                            <input type="text" name="descricao_lt" id="descricao_lt" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fornecedor<span style="color: red;">*</span></label>
                                            <input type="text" name="buscaFornecedor" id="fornecedorLt" class="form-control buscaFornecedor">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Quantidade <span style="color: red;">*</span></label>
                                            <input type="text" name="qtd_litro" id="qtd_litro" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Volume <span style="color: red;">*</span></label>
                                            <input type="text" name="vol_lt" id="vol_lt" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Valor<span style="color: red;">*</span></label>
                                            <input type="text" name="pre_lt" id="pre_lt" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalCalc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <input type="hidden" name="un_medida" id="un_medida_lt">
            <input type="hidden" name="produto_id" id="produto_id_lt" value="{{ $produto->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Calcular Consumo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="text" name="buscaDescricao" id="buscaDescricao_litro" class="form-control buscaDescricao">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" onclick="buscaCalc()"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="w-100" id="resultado_litro">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Descrição<span style="color: red;">*</span></label>
                                        <input type="text" name="descricao_litro" id="descricao_litro" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fornecedor<span style="color: red;">*</span></label>
                                        <input type="text" name="buscaFornecedor" id="fornecedorLitro" class="form-control buscaFornecedor">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6 class="card-title">Dimensões da peça</h6>
                                    <div class="w-100 border-bottom mb-2"></div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Quantidade de Peças <span style="color: red;">*</span></label>
                                                <input type="text" name="quantidade_lt" id="quantidade_lt" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Altura <span style="color: red;">*</span></label>
                                                <input type="text" name="alt_lt" id="alt_lt" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Largura <span style="color: red;">*</span></label>
                                                <input type="text" name="larg_lt" id="larg_lt" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Profundidade <span style="color: red;">*</span></label>
                                                <input type="text" name="prof_lt" id="prof_lt" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6 class="card-title">Detalhes da mão de obra</h6>
                                    <div class="w-100 border-bottom mb-2"></div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Demãos <span style="color: red;">*</span></label>
                                                <input type="text" name="demaos" id="demaos" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Rendimento <span style="color: red;">*</span></label>
                                                <input type="text" name="rend" id="rend" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Volume <span style="color: red;">*</span></label>
                                                <input type="text" name="vol_litro" id="vol_litro" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor<span style="color: red;">*</span></label>
                                        <input type="text" name="pre_litro" id="pre_litro" class="form-control" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="calcular()" >Calcular</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalEditarMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formMaterialE">
                @csrf
                <input type="hidden" name="un_medidaE" id="un_medida">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="card-title">Medidas</h4>
                        <div class="w-100 border-bottom"></div>
                        <input type="hidden" name="parte_id" id="parte_id">
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Descricao<span style="color: red;">*</span></label>
                                    <input type="text" name="nomeE" id="nomeE" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantidade<span style="color: red;">*</span></label>
                                    <input type="text" name="qtdE" id="qtdE" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="largura1">Largura<span style="color: red;">*</span></label>
                                    <input type="text" name="larguraE" id="larguraE" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="altura1">Altura<span style="color: red;">*</span></label>
                                    <input type="text" name="alturaE" id="alturaE" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Material<span style="color: red;">*</span></label>
                                    <input type="text" name="descricaoE" id="descricaoE" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Largura<span style="color: red;">*</span></label>
                                    <input type="text" name="larguraMaterialE" id="larguraMaterialE" class="form-control"required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Altura<span style="color: red;">*</span></label>
                                    <input type="text" name="alturaMaterialE" id="alturaMaterialE" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Valor<span style="color: red;">*</span></label>
                                    <input type="text" name="precoE" id="precoE" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12" id="resultadoE">


                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('antes-java')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@endpush

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var medida = '';

        $('.dropify').dropify({
            messages: {
                default: 'Arraste ou solte uma imagem ou clique em',
                replace: 'Arraste ou solte uma imagem ou clique em',
                remove:  'Remover',
                error:   'Ops...'
            }
        });

        function calcularProd() {
            $.get('/api/estoque/busca/valorMaterial/' + @json($produto->id), function(response) {
                // console.log(response);
                $('#preco_prod').val(response);
            });
        }

        function calcular() {
            var altura = $('#alt_lt').val().replace(',', '.');
            var largura = $('#larg_lt').val().replace(',', '.');
            var profundidade = $('#prof_lt').val().replace(',', '.');
            var demaos = $('#demaos').val().replace(',', '.');
            var rend = $('#rend').val().replace(',', '.');
            var vol = $('#vol_litro').val();
            var preco = $('#pre_litro').val();
            var desc = $('#descricao_litro').val();
            var forn = $('#fornecedorLitro').val();
            var qtd = $('#quantidade_lt').val();

            if(profundidade == '') {
                var area = (altura * largura) * qtd;
            } else {
                var area = (altura * largura * profundidade) * qtd;
            }

            var consumo = area * demaos;
            consumo = consumo / rend;

            // console.log(consumo.toFixed(2));
            $('#fornecedorLt').val(forn);
            $('#descricao_lt').val(desc);
            $('#pre_lt').val(preco);
            $('#vol_lt').val(vol);
            $('#qtd_lt').val((consumo * 10).toFixed(2));

            $('#resultado_litro').append(conteudo);

            $('#descricao_litro').val('');
            $('#fornecedorLitro').val('');
            $('#qtd_litro').val('');
            $('#pre_litro').val('');
            $('#vol_litro').val('');

            $('#modalCalc').modal('hide');
        }

        function autoCompleFornecedor(dados) {
            $(".buscaFornecedor").autocomplete({
                source: dados
            });
        }

        function abrirModal(un_medida) {
            $.get('/api/fornecedor', function(response) {
                var dados = [];
                axios.get('/api/fornecedor')
                .then(function(response) {
                    for(dado of response.data) {
                        dados.push(dado.nome);
                    }
                    autoCompleFornecedor(dados);
                })
                .catch(function(erro) {
                    alert(erro);
                });
                if(un_medida == 'M2') {
                    filtroMedida('M2');
                    $('#modalMaterial').modal('show');
                } else if(un_medida == 'M3') {
                    filtroMedida('M3');
                    $('#modalMaterialM3').modal('show');
                } else if(un_medida == 'UN') {
                    filtroMedida('UN');
                    $('#modalMaterialUN').modal('show');
                } else if(un_medida == 'MTL') {
                    filtroMedida('MTL');
                    $('#modalMaterialMTL').modal('show');
                } else if(un_medida == 'KG') {
                    filtroMedida('KG');
                    $('#modalMaterialKG').modal('show');
                } else if(un_medida == 'LT') {
                    filtroMedida('LT');
                    $('#modalMaterialLT').modal('show');
                } else if(un_medida == 'CALC') {
                    filtroMedida('LT');
                    $('#modalCalc').modal('show');
                }
            });
        }

        function buscaM() {
            produto = {
                produto : $('#buscaDescricao').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado').append(conteudo);

                    $('#descricao2').val($('#buscaDescricao').val());
                    $('#largura2').val('');
                    $('#altura2').val('');
                    $('#preco2').val('');
                    $('#fornecedorM2').val('');
                } else {
                    $('#resultado').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao2').val(response[i].descricao);
                        $('#largura2').val(response[i].largura);
                        $('#altura2').val(response[i].altura);
                        $('#preco2').val(response[i].preco);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorM2').val(fornecedor.nome);
                        }
                    }
                }

                $('#buscaDescricao').val('')
            });
        }

        function buscaM3() {
            produto = {
                produto : $('#buscaDescricao_m3').val(),
                un_medida : medida
            }

            console.log(produto)

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado_m3').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado_m3').append(conteudo);

                    $('#descricao_m3').val(produto.produto);
                    $('#larg_m3').val('');
                    $('#alt_m3').val('');
                    $('#pre_m3').val('');
                    $('#fornecedorM3').val('');
                } else {
                    $('#resultado_m3').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao_m3').val(response[i].descricao);
                        $('#larg_m3').val(response[i].largura);
                        $('#alt_m3').val(response[i].altura);
                        $('#pre_m3').val(response[i].preco);
                        $('#prof_m3').val(response[i].profundidade);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorM3').val(fornecedor.nome);
                        }
                    }
                }
            });
            $('#buscaDescricao_m3').val('')
        }

        function buscaMTL() {
            produto = {
                produto : $('#buscaDescricao_mtl').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado_mtl').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado_mtl').append(conteudo);

                    $('#descricao_mtl').val(produto.produto);
                    $('#met_mtl').val('');
                    $('#fornecedorMtl').val('');
                } else {
                    $('#resultado_mtl').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao_mtl').val(response[i].descricao);
                        $('#met_mtl').val(response[i].metragem);
                        $('#pre_mtl').val(response[i].preco);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorMtl').val(fornecedor.nome);
                        }
                    }
                }
            });
            $('#buscaDescricao_mtl').val('')
        }

        function buscaUN() {
            produto = {
                produto : $('#buscaDescricao_un').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado_un').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado_un').append(conteudo);

                    $('#descricao_un').val(produto.produto);
                    $('#met_un').val('');
                    $('#fornecedorUn').val('');
                } else {
                    $('#resultado_un').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao_un').val(response[i].descricao);
                        $('#qtd_unidade').val(response[i].qtd);
                        $('#pre_un').val(response[i].preco);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorUn').val(fornecedor.nome);
                        }
                    }
                }
            });
            $('#buscaDescricao_un').val('')
        }

        function buscaKG() {
            produto = {
                produto : $('#buscaDescricao_kg').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado_kg').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado_kg').append(conteudo);

                    $('#descricao_kg').val(produto.produto);
                    $('#fornecedorKg').val('');
                } else {
                    $('#resultado_kg').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao_kg').val(response[i].descricao);
                        $('#qtd_kilo').val(response[i].qtd);
                        $('#pre_kg').val(response[i].preco);
                        $('#vol_kg').val(response[i].vol);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorKg').val(fornecedor.nome);
                        }
                    }
                }
            });
            $('#buscaDescricao_kg').val('')
        }

        function buscaLT() {
            produto = {
                produto : $('#buscaDescricao_lt').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado_lt').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado_lt').append(conteudo);

                    $('#descricao_lt').val(produto.produto);
                    $('#fornecedorLt').val('');
                } else {
                    $('#resultado_lt').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao_lt').val(response[i].descricao);
                        $('#pre_lt').val(response[i].preco);
                        $('#vol_lt').val(response[i].vol);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorLt').val(fornecedor.nome);
                        }
                    }
                }
            });
            $('#buscaDescricao_lt').val('')
        }

        function buscaCalc() {
            produto = {
                produto : $('#buscaDescricao_litro').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    $('#resultado_litro').html('');

                    var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>';

                    $('#resultado_litro').append(conteudo);

                    $('#descricao_litro').val(produto.produto);
                    $('#fornecedorLitro').val('');
                    $('#qtd_litro').val('');
                    $('#pre_litro').val('');
                    $('#vol_litro').val('');
                } else {
                    $('#resultado_lt').html('');

                    for (let i = 0; i < response.length; i++) {
                        $('#descricao_litro').val(response[i].descricao);
                        $('#qtd_litro').val(response[i].qtd);
                        $('#pre_litro').val(response[i].preco);
                        $('#vol_litro').val(response[i].vol);
                        for (fornecedor of response[i].fornecedores) {
                            $('#fornecedorLitro').val(fornecedor.nome);
                        }
                    }
                }
            });
            $('#buscaDescricao_litro').val('')
        }

        $('#largura2').val('');
        $('#altura2').val('');
        $('#preco2').val('');
        $('#larg_m3').val('');
        $('#alt_m3').val('');
        $('#pre_m3').val('');
        $('#prof_m3').val('');
        $('#profundidade_m3').val('');
        $('#larg_mtl').val('');
        $('#alt_mtl').val('');
        $('#pre_mtl').val('');

        function autoComple(dados) {
            $(".buscaDescricao").autocomplete({
                source: dados
            });
        }

        function filtroMedida(un_medida) {
            $('#resultado').html('');
            medida = un_medida;
            $('#un_medida').val(medida);
            var dados = [];
            axios.get('/api/estoque/busca/' + un_medida)
            .then(function(response) {
                for(dado of response.data) {
                    dados.push(dado.cod_item + '-' + dado.descricao);
                }
                autoComple(dados);
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

        function getItemProximo(dados) {
            i = dados.current_page + 1;

            if(dados.last_page == dados.current_page) {
                s = '<li class="page-item disabled">';
            } else {
                s = '<li class="page-item">';
            }

            s += '<a class="page-link"  pagina="' + i + '" href="javascript:void(0)" aria-label="Próximo">' +
                        '<span aria-hidden="true">&raquo;</span>' +
                        '<span class="sr-only">Próximo</span>' +
                    '</a>' +
                '</li>';

            return s;
        }

        function getItemAnterior(dados) {
            i = dados.current_page - 1;

            if(1 == dados.current_page) {
                item = '<li class="page-item disabled">';
            } else {
                item = '<li class="page-item">';
            }

            item += '<a class="page-link"  pagina="' + i + '" href="javascript:void(0)" aria-label="Anterior">' +
                        '<span aria-hidden="true">&laquo;</span>' +
                        '<span class="sr-only">Anterior</span>' +
                    '</a>' +
                '</li>';

            return item;
        }

        function getItem(dados, i) {
            if(i == dados.current_page) {
                item = '<li class="page-item active">';
            } else {
                item = '<li class="page-item">';
            }

            item += '<a class="page-link "  pagina="' + i + '" href="javascript:void(0)">' + i + '</a>' +
                '</li>';

            return item;
        }

        function renderPaginacao(dados) {
            $('#paginator>ul>li').remove();

            $('#paginator>ul').append(getItemAnterior(dados));

            n = dados.last_page;

            if(dados.current_page - n/2 <= 1) {
                inicio = 1;
            } else if(dados.last_page - dados.current_page < n) {
                inicio = dados.last_page - n + 1;
            } else {
                inicio = dados.current_page - n/2;
            }

            final = inicio + n - 1;

            for(let i = inicio; i <= final; i++) {
                item = getItem(dados, i);
                $('#paginator>ul').append(item);
            }

            $('#paginator>ul').append(getItemProximo(dados));

        }

        function renderLinha(tr) {
            return '<tr>' +
                        '<td>' + tr.nome + '</td>' +
                        '<td>' + tr.descricao + '</td>' +
                        '<td>' + tr.qtdItem + '</td>' +
                        '<td>' + 'R$ ' + formatNumber(tr.preco) + '</td>' +
                        '<td>' +
                            '<button type="button" class="btn btn-outline-dark" onclick="editar(' + tr.id + ')"><i class="far fa-edit"></i></button>'+
                            '<button type="button" class="btn btn-outline-danger ml-2" onclick="exluir(' + tr.id + ')"><i class="far fa-trash-alt"></i></button>'+
                        '</td>' +
                    '</tr>';
        }

        function renderTabela(dados) {
            $('#tabelaLista>tbody>tr').remove();

            for(let i = 0; i < dados.length; i++) {
                tr = renderLinha(dados[i]);

                $('#tabelaLista>tbody').append(tr);
            }

            $('.table').footable();
        }

        function carregarTabela(page) {
            $.get('/estoque/busca/verMaterialProd/'+@json($produto->id) , { page:page }, function(response) {
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarTabela($(this).attr('pagina'));
                });
            });
        }

        function editar(id){
            $.get('/estoque/busca/' + id, function(response) {
                $('#parte_id').val(id);
                $('#qtdE').val(response.qtdItem);
                $('#nomeE').val(response.nome);
                $('#larguraE').val(response.largura);
                $('#alturaE').val(response.altura);
                $('#descricaoE').val(response.descricao);
                $('#larguraMaterialE').val(response.larguraMaterial * 1000);
                $('#alturaMaterialE').val(response.alturaMaterial * 1000);
                $('#precoE').val('R$ ' + formatNumber(response.preco));

                $('#modalEditarMaterial').modal('show');
            });
        }

        function exluir(id) {
            $.ajax({
                type: 'DELETE',
                url: '/api/estoque/busca/' + id,
                dado: id,
                context:this,
                success: function() {
                    carregarTabela(1);
                    alert('Item Removido');
                    //itens(data);
                },
                error: function(erro) {
                    alert(erro);
                }
            });
        }

        $('#formMaterial').submit(function(e) {
            e.preventDefault();
            material = {
                un_medida : medida,
                produto_id : @json($produto->id),
                nome : $('#nome2').val(),
                descricao2 : $('#descricao2').val(),
                largura2 : $('#largura2').val(),
                altura2 : $('#altura2').val(),
                preco2 : $('#preco2').val(),
                altura1 : $('#altura1').val(),
                largura1 : $('#largura1').val(),
                profundidadeProd : $('#profundidade').val(),
                qtd2 : $('#qtd2').val(),
                medidaLargura1 : $('#medidaLargura1').val(),
                fornecedor : $('#fornecedorM2').val(),
            }

            $.post('/api/estoque/busca/materialProd', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                $('#resultado').html('');

                $('#medida').val('');
                $('#descricao2').val('');
                $('#largura2').val('');
                $('#altura2').val('');
                $('#preco2').val('');
                $('#altura1').val('');
                $('#largura1').val('');
                $('#profundidade').val('');
                $('#qtd2').val('');
                $('#fornecedor').val('');

                $('#modalMaterial').modal('hide');
            });
        });

        $('#formMaterialM3').submit(function(e) {
            e.preventDefault();
            material = {
                un_medida : medida,
                produto_id : @json($produto->id),
                nome : $('#nome_m3').val(),
                descricao_m3 : $('#descricao_m3').val(),
                largura_m3 : $('#largura_m3').val(),
                altura_m3 : $('#altura_m3').val(),
                pre_m3 : $('#pre_m3').val(),
                alt_m3 : $('#alt_m3').val(),
                larg_m3 : $('#larg_m3').val(),
                prof_m3 : $('#prof_m3').val(),
                profundidade_m3 : $('#profundidade_m3').val(),
                qtd_m3 : $('#qtd_m3').val(),
                fornecedor : $('#fornecedorM3').val(),
            }

            console.log(material)

            $.post('/api/estoque/busca/materialProdM3', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                $('#resultado_m3').html('');

                $('#produto_id_m3').val('');
                $('#nome_m3').val('');
                $('#descricao_m3').val('');
                $('#largura_m3').val('');
                $('#altura_m3').val('');
                $('#pre_m3').val('');
                $('#alt_m3').val('');
                $('#larg_m3').val('');
                $('#prof_m3').val('');
                $('#profundidade_m3').val('');
                $('#qtd_m3').val('');
                $('#fornecedorM3').val('');

                // console.log(response);

                $('#modalMaterialM3').modal('hide');
            });
        });

        $('#formMaterialMTL').submit(function(e) {
            e.preventDefault();
            material = {
                un_medida : medida,
                produto_id : @json($produto->id),
                nome : $('#nome_mtl').val(),
                descricao_mtl : $('#descricao_mtl').val(),
                pre_mtl : $('#pre_mtl').val(),
                met_mtl : $('#met_mtl').val(),
                fornecedor : $('#fornecedorMtl').val(),
                metragem : $('#metragem_mtl').val(),
            }

            $.post('/api/estoque/busca/materialProdMTL', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                $('#resultado_mtl').html('');

                $('#produto_id_mtl').val('');
                $('#nome_mtl').val('');
                $('#descricao_mtl').val('');
                $('#pre_mtl').val('');
                $('#met_mtl').val('');
                $('#fornecedorMtl').val('');

                // console.log(response);

                $('#modalMaterialMTL').modal('hide');
            });
        });

        $('#formMaterialUN').submit(function(e) {
            e.preventDefault();
            material = {
                un_medida : medida,
                produto_id : @json($produto->id),
                nome : $('#nome_un').val(),
                descricao_un : $('#descricao_un').val(),
                pre_un : $('#pre_un').val(),
                qtd : $('#qtd_un').val(),
                fornecedor : $('#fornecedorUn').val(),
                tipo : $('input[name="tipo[]"]:checked').val(),
            }
            $.post('/api/estoque/busca/materialProdUN', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                $('#resultado_un').html('');

                $('#produto_id_un').val('');
                $('#nome_un').val('');
                $('#descricao_un').val('');
                $('#pre_un').val('');
                $('#qtd_unidade').val('');
                $('#qtd_un').val('');
                $('#fornecedorUn').val('');

                // console.log(response);

                $('#modalMaterialUN').modal('hide');
            });
        });

        $('#formMaterialKG').submit(function(e) {
            e.preventDefault();
            material = {
                un_medida : medida,
                produto_id : @json($produto->id),
                nome : $('#nome_kg').val(),
                descricao_kg : $('#descricao_kg').val(),
                pre_kg : $('#pre_kg').val(),
                qtd : $('#qtd_kg').val(),
                volume : $('#vol_kg').val(),
                fornecedor : $('#fornecedorKg').val(),
            }
            $.post('/api/estoque/busca/materialProdKG', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                $('#resultado_kg').html('');

                $('#produto_id_kg').val('');
                $('#nome_kg').val('');
                $('#descricao_kg').val('');
                $('#pre_kg').val('');
                $('#qtd_kilo').val('');
                $('#qtd_kg').val('');
                $('#fornecedorKg').val('');

                // console.log(response);

                $('#modalMaterialKG').modal('hide');
            });
        });

        $('#formMaterialLT').submit(function(e) {
            e.preventDefault();
            material = {
                un_medida : medida,
                produto_id : @json($produto->id),
                nome : $('#nome_lt').val(),
                descricao_kg : $('#descricao_lt').val(),
                pre_kg : $('#pre_lt').val(),
                qtd : $('#qtd_lt').val(),
                volume : $('#vol_lt').val(),
                fornecedor : $('#fornecedorLt').val(),
            }
            // console.log(material)
            $.post('/api/estoque/busca/materialProdLT', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                $('#resultado_lt').html('');

                $('#produto_id_lt').val('');
                $('#nome_lt').val('');
                $('#descricao_lt').val('');
                $('#pre_lt').val('');
                $('#qtd_litro').val('');
                $('#qtd_lt').val('');
                $('#fornecedorLt').val('');

                // console.log(response);

                $('#modalMaterialLT').modal('hide');
            });
        });

        $('#formMaterialE').submit(function(e) {
            e.preventDefault();
            material = {
                qtd : $('#qtdE').val(),
                nome : $('#nomeE').val(),
                largura : $('#larguraE').val(),
                altura : $('#alturaE').val(),
                desc : $('#descricaoE').val(),
                larguraM : $('#larguraMaterialE').val(),
                alturaM : $('#alturaMaterialE').val(),
                preco : $('#precoE').val()
            }

            $.ajax({
                type: 'PUT',
                url: '/api/estoque/busca/up' + fornecedor.id,
                data : fornecedor,
                context: this,
                success: function(data) {
                    carregarFornecedores();
                    $('#modalFornecedor').modal('hide');
                    alert('Fornecedor Atualizado');
                },
                error: function(error) {
                    console.log(error);
                }
            });

            $.post('/api/estoque/busca/up', material, function(response) {
                alert('Item Add');
                carregarTabela(1);

                console.log(response)

                $('#resultado').html('');

                $('#medida').val('');
                $('#descricao2').val('');
                $('#largura2').val('');
                $('#altura2').val('');
                $('#preco2').val('');
                $('#altura1').val('');
                $('#largura1').val('');
                $('#profundidade').val('');
                $('#qtd2').val('');

                $('#modalMaterial').modal('hide');
            });
        });

        $(function() {
            carregarTabela(1);
        });

    </script>
@endsection
