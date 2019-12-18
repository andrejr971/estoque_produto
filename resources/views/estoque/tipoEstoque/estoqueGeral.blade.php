@extends('layout.index')

@section('conteudo')
    <div class="container mt-2">
        <h1 class="text-center">Cadastro Item</h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <form action="/api/estoque" class="form-horizontal" id="formChapas" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group w-100">
                                <label>Descriçao Item <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="EX: HOB811" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group w-100">
                                <label>EAN - Código de barras</label>
                                <input type="text" class="form-control" placeholder="EX: 000000000 00000" id="ean_item" name="ean_item">
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
                                <label>Código do Produto <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="EX: 000000" id="cod_prod" name="cod_prod" required>
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
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Grupo <span style="color: red;">*</span></label>
                                <select name="grupo" id="grupo" class="form-control">
                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                        <div class="col" style="display: none;" id="camposChapas">

                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Estante</label>
                                <select name="estante" id="estante" class="form-control">
                                    <option value=""></option>
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
                                    <option value=""></option>
                                    <option value="UN">UN</option>
                                    <option value="M2">M2</option>
                                    <option value="M3">M3</option>
                                    <option value="MTL">MTL</option>
                                    <option value="KG">KG</option>
                                    <option value="LT">LT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col" style="display: none;" id="camposMedidas">

                        </div>
                        <div class="col-3" id="divPreco">
                            <div class="form-group w-100">
                                <label>Preço<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="preco" name="preco" maxlength="8" required>
                            </div>
                        </div>
                        <div class="col" style="display: none;" id="camposTecido">

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

        <!--<div class="card mt-3">
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
                                <th>Estante</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>-->
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
        var selectElementGrupo = document.querySelector('#grupo');
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

                axios.get('/api/categoria')
                    .then(function(response) {
                        carregarGrupos(response.data);
                    })
                    .catch(function(erro) {
                        alert(erro);
                    });

                function carregarGrupos(dados) {
                    for(dado of dados) {
                        var optionElement = document.createElement('option');
                        var textOption = document.createTextNode(dado.descricao);

                        optionElement.setAttribute('value', dado.id);
                        optionElement.appendChild(textOption);

                        selectElementGrupo.appendChild(optionElement);
                    }
                }
            window.onload = createInput;
            var un_medida = document.querySelector('#unidade');
            var grupo = document.querySelector('#grupo');
            var divMedida = document.querySelector('#camposMedidas');

            function createInput() {
                grupo.onchange = function() {
                    $('#camposChapas').html('');
                    $('#camposChapas').attr('class', 'd-none');


                    $('#camposTecido').html('');
                    $('#camposTecido').attr('class', 'd-none');

                    if(this.value == 1) {
                        var divChapas = '<div class="form-group w-100">'+
                                '<label>Espessura<span style="color: red;">*</span></label>'+
                                '<select name="espessura" id="espessura" class="form-control">'+
                                    '<option value="4">4mm</option>'+
                                    '<option value="6">6mm</option>'+
                                    '<option value="9">9mm</option>'+
                                    '<option value="12">12mm</option>'+
                                    '<option value="15">15mm</option>'+
                                    '<option value="18">18mm</option>'+
                                    '<option value="25">25mm</option>'+
                                    '<option value="35">35mm</option>'+
                                '</select>'+
                            '</div>';

                        $('#camposChapas').attr('class', 'd-block');
                        $('#camposChapas').append(divChapas);
                    } else if(this.value == 4) {
                        var divTecido = '<div class="row">' +
                            '<div class="col">'+
                                '<div class="form-group w-100">'+
                                    '<label>Reservado<span style="color: red;">*</span></label>'+
                                    '<div class="row">'+
                                        '<div class="col">'+
                                            '<div class="form-check">'+
                                                '<input class="form-check-input" type="radio" name="reservado" id="reservado1" value="1">'+
                                                '<label class="form-check-label" for="reservado1">'+
                                                    'Sim'+
                                                '</label>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col">'+
                                            '<div class="form-check">'+
                                                '<input class="form-check-input" type="radio" name="reservado" id="reservado0" value="0">'+
                                                '<label class="form-check-label" for="reservado0">'+
                                                    'Não'+
                                                '</label>'+
                                        '</div>'  +
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col">'+
                                '<div class="form-group w-100">'+
                                    '<label>Pedido<span style="color: red;">*</span></label>'+
                                    '<input type="text" class="form-control" id="pedido" name="pedido" required>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                        $('#camposTecido').attr('class', 'd-block');
                        $('#camposTecido').append(divTecido);
                    }
                }
                un_medida.onchange = function() {
                    $('#camposMedidas').html('');
                    $('#divPreco').attr('class', 'col-3');

                    if(this.value == 'M2') {
                        var inputM = '<div class="row"><div class="col">' +
                            '<div class="form-group w-100">' +
                                '<label>Largura<span style="color: red;">*</span></label>' +
                                '<input type="text" class="form-control" id="largura" name="largura" maxlength="8" required>' +
                            '</div>'+
                        '</div>' +
                        '<div class="col">' +
                            '<div class="form-group w-100">' +
                                '<label>Altura<span style="color: red;">*</span></label>' +
                                '<input type="text" class="form-control" id="altura" name="altura" maxlength="8" required>' +
                            '</div>'+
                        '</div></div>';

                        $('#camposMedidas').attr('class', 'd-block');
                        $('#divPreco').attr('class', 'col-3');
                        $('#camposMedidas').append(inputM);

                    } else if(this.value == 'M3') {
                        var inputM = '<div class="row">' +
                            '<div class="col">' +
                                '<div class="form-group w-100">' +
                                    '<label>Largura<span style="color: red;">*</span></label>' +
                                    '<input type="text" class="form-control" id="largura" name="largura" maxlength="8" required>' +
                                '</div>'+
                            '</div>' +
                            '<div class="col">' +
                                '<div class="form-group w-100">' +
                                    '<label>Altura<span style="color: red;">*</span></label>' +
                                    '<input type="text" class="form-control" id="altura" name="altura" maxlength="8" required>' +
                                '</div>'+
                            '</div>' +
                            '<div class="col">' +
                                '<div class="form-group w-100">' +
                                    '<label>Profundidade<span style="color: red;">*</span></label>' +
                                    '<input type="text" class="form-control" id="profundidade" name="profundidade" maxlength="8" required>' +
                                '</div>'+
                            '</div>' +
                        '</div>';

                        $('#camposMedidas').attr('class', 'd-block');
                        $('#divPreco').attr('class', 'col');
                        $('#camposMedidas').append(inputM);
                    } else if (this.value == 'MTL') {
                        var inputM = '<div class="row"><div class="col">' +
                            '<div class="form-group w-100">' +
                                '<label>Largura<span style="color: red;">*</span></label>' +
                                '<input type="text" class="form-control" id="largura" name="largura" maxlength="8" required>' +
                            '</div>'+
                        '</div></div>';

                        $('#camposMedidas').attr('class', 'd-block');
                        $('#divPreco').attr('class', 'col-3');
                        $('#camposMedidas').append(inputM);
                    } else if (this.value == 'LT') {
                        var inputM = '<div class="row"><div class="col">' +
                            '<div class="form-group w-100">' +
                                '<label>Volume<span style="color: red;">*</span></label>' +
                                '<input type="text" class="form-control" id="volume" name="volume" maxlength="8" required>' +
                            '</div>'+
                        '</div></div>';

                        $('#camposMedidas').attr('class', 'd-block');
                        $('#divPreco').attr('class', 'col-3');
                        $('#camposMedidas').append(inputM);
                    }
                }
            }

            function limpezaInput() {
                $('#nome').val('');
                $('#ncm').val('');
                $('#qtd').val('');
                $('#min').val('');
                $('#ideal').val('');
                $('#preco').val('');
            }
    </script>
@endsection
