@extends('layout.index')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/3.1.6/footable.core.bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                <h1 class="card-title">Novo Produto Padrão Fornecido</h1>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Gerais</a>
                        @isset($resposta)
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Materias</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Valores e taxas</a>
                        @endisset
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form action="{{ route('salvarFornecido') }}" method="POST" enctype="multipart/form-data">
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
                                                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="sku">SKU</label>
                                                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="qtd">Quantidade<span style="color: red;">*</span></label>
                                                        <input type="text" name="qtd" id="qtd" value="{{ old('qtd') }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="categoria">Categoria<span style="color: red;">*</span></label>
                                                        <select class="custom-select" name="categoria" id="categoria">
                                                            <option selected>---</option>
                                                            @foreach ($categorias as $grupo)
                                                                <optgroup label="{{ $grupo->nome }}">
                                                                    @foreach ($grupo->categoria as $categoria)
                                                                        <option value="{{ $categoria->id || old('categoria') }}">{{ $categoria->nome }}</option>
                                                                    @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <input type="file" id="demo" class="dropify" name="imagem" value="{{ old('imagem') }}" data-allowed-file-extensions="jpeg jpg png" data-max-file-size="2M" data-height="150">
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
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="largura">Largura (L)<span style="color: red;">*</span></label>
                                                        <input type="text" name="largura" id="largura" value="{{ old('largura') }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="altura">Altura (A)<span style="color: red;">*</span></label>
                                                        <input type="text" name="altura" id="altura" value="{{ old('altura') }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="profundidade">Profundidade (P)<span style="color: red;">*</span></label>
                                                        <input type="text" name="profundidade" id="profundidade" value="{{ old('profundidade') }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="obs">Obeservações</label>
                                                        <textarea name="obs" id="obs" value="{{ old('obs') }}" class="form-control" rows="3"></textarea>
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
                            </form>
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
                                            <a class="btn btn-outline-info" onclick="filtroMedida('M2')" id="pills-m2-tab" data-toggle="modal" href="#modalMaterial">M <sup>2</sup></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2" onclick="filtroMedida('M3')" id="pills-m3-tab" data-toggle="modal" href="#modalMaterialM3">M <sup>3</sup></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2" onclick="filtroMedida('MTL')" id="pills-mlienar-tab" data-toggle="modal" href="#modalMaterial">MT Linear</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2" onclick="filtroMedida('UN')" id="pills-unid-tab" data-toggle="modal" href="#modalMaterial">Unid.</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2" onclick="filtroMedida('KG')" id="pills-kg-tab" data-toggle="modal" href="#modalMaterial">KG</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="btn btn-outline-info ml-2" onclick="filtroMedida('LT')" id="pills-lt-tab" data-toggle="modal" href="#modalMaterial">LT</a>
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
                        ...
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
                            <div class="col-md-6">
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
                            <div class="col-md-6" id="resultado" style="display: none">


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
            <form id="formMaterial">
                @csrf
                <input type="hidden" name="un_medida" id="un_medida">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quantidade<span style="color: red;">*</span></label>
                                    <input type="text" name="qtd_m3" id="qtd_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="largura1">Largura<span style="color: red;">*</span></label>
                                    <input type="text" name="largura_m3" id="largura_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="altura1">Altura<span style="color: red;">*</span></label>
                                    <input type="text" name="altura_m3" id="altura_m3" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="altura1">Profundidade<span style="color: red;">*</span></label>
                                    <input type="text" name="profundidade_m3" id="profundidade_m3" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title">Material</h4>
                        <div class="w-100 border-bottom"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="buscaDescricao">Descrição do Material<span style="color: red;">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="buscaDescricao" id="buscaDescricaoM3" class="form-control buscaDescricao">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaM3()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="resultado_m3" style="display: none">


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

        function buscaM() {
            produto = {
                produto : $('.buscaDescricao').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    if(medida == 'M2') {
                        $('#resultado').html('');
                        $('#resultado').attr('class', 'd-block col-md-12');

                        var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>' +
                            '<div class="row">' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Descricao<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="descricao2" id="descricao2" class="form-control" required value="' + $('#buscaDescricao').val() + '">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Largura<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="largura2" id="largura2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Altura<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="altura2" id="altura2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Valor<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="preco2" id="preco2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                            $('#resultado').append(conteudo);
                    }
                } else {
                    if(medida == 'M2') {
                        $('#resultado').html('');
                        $('#resultado').attr('class', 'd-block col-md-12');

                        for (let i = 0; i < response.length; i++) {
                            var conteudo = '<div class="row">' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Descricao<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="descricao2" id="descricao2" class="form-control" required value="' + response[i].descricao + '">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Largura<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="largura2" id="largura2" class="form-control" value="' + response[i].largura + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Altura<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="altura2" id="altura2" class="form-control" value="' + response[i].altura + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Valor<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="preco2" id="preco2" class="form-control" required value="' + response[i].preco + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
                        }

                        $('#resultado').append(conteudo);
                    }
                }

                $('.buscaDescricao').val('');
            });
        }

        function buscaM3() {
            produto = {
                produto : $('#buscaDescricaoM3').val(),
                un_medida : medida
            }

            $.get('/api/estoque/busca/material', produto, function(response) {

                if(response == '') {
                    if(medida == 'M3') {
                        $('#resultado_m3').html('');
                        $('#resultado_m3').attr('class', 'd-block col-md-12');

                        var conteudo = '<h6 class="card-title">Item não encontrado no estoque</h6>' +
                            '<div class="row">' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Descricao<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="descricao2" id="descricao2" class="form-control" required value="' + $('#buscaDescricao').val() + '">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Largura<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="largura2" id="largura2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Altura<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="altura2" id="altura2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Altura<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="altura2" id="altura2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                    '<div class="form-group">' +
                                        '<label>Valor<span style="color: red;">*</span></label>' +
                                        '<input type="text" name="preco2" id="preco2" class="form-control" required>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                            $('#resultado_m3').append(conteudo);
                    }
                } else {
                    if(medida == 'M3') {
                        $('#resultado_m3').html('');
                        $('#resultado_m3').attr('class', 'd-block col-md-12');

                        for (let i = 0; i < response.length; i++) {
                            var conteudo = '<div class="row">' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Descricao<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="descricao2" id="descricao2" class="form-control" required value="' + response[i].descricao + '">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Largura<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="largura2" id="largura2" class="form-control" value="' + response[i].largura + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Altura<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="altura2" id="altura2" class="form-control" value="' + response[i].altura + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Profundidade<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="profundidade" id="profundidade" class="form-control" value="' + response[i].profundidade + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-6">' +
                                        '<div class="form-group">' +
                                            '<label>Valor<span style="color: red;">*</span></label>' +
                                            '<input type="text" name="preco2" id="preco2" class="form-control" required value="' + response[i].preco + '" required>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';

                            $('#resultado_m3').append(conteudo);
                        }
                    }
                }

                $('#buscaDescricaoM3').val('');
            });
        }

        function autoComple(dados) {
            $(".buscaDescricao").autocomplete({
                source: dados
            });
        }

        function filtroMedida(un_medida) {
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
                        '<td>' + tr.qtd + '</td>' +
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
            $.get('/estoque/busca/verMaterialProd', { page:page }, function(response) {
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
            }

            $.post('/api/estoque/busca/materialProd', material, function(response) {
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
