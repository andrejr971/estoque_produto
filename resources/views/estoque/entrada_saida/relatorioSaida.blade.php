@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title">Relatório - Saidas</h1>
                </div>
                <div class="col-3">
                    <a href="#" data-toggle="modal" data-target="#modalPDF" class="btn btn-outline-info w-100">Gerar PDF</a>
                </div>
                <div class="col-3">
                    <a href="/estoque/ver" class="btn btn-outline-primary w-100">Ver Estoque</a>
                </div>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-lg-6">
                @component('componentes.graficoRelTipoSaida')
                @endcomponent
            </div>
            <div class="col-lg-6">
                @component('componentes.graficoRelMesSaida')
                @endcomponent
            </div>
        </div>
        <div class="row m-2">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Filtrar por:</h4>
                        <h5 class="card-title">Fornecedor:</h5>
                        <hr>
                        <form name="Formfornecedor">
                            <div class="row ml-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="fornecedor" value="0" onclick="carregarEntrada(1)" id="fornecedor">
                                    <label class="form-check-label" for="fornecedor">
                                        Todos
                                    </label>
                                </div>
                            </div>
                            @foreach ($fornecedores as $fornecedor)
                                <div class="row ml-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fornecedor" value="{{ $fornecedor->id }}" onclick="filtroForn({{ $fornecedor->id }})" id="fornecedor{{ $fornecedor->id }}">
                                        <label class="form-check-label" for="fornecedor{{ $fornecedor->id }}">
                                            {{ $fornecedor->nome }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                        <h5 class="card-title mt-2">Categoria:</h5>
                        <hr>
                        <form>
                            <div class="row ml-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" onclick="filtroCat(0)" name="tipo" value="0" id="tipo" checked>
                                    <label class="form-check-label" for="tipo">
                                        TODAS
                                    </label>
                                </div>
                            </div>
                            @foreach ($categoria as $tipo)
                                <div class="row ml-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onclick="filtroCat({{ $tipo->id }})" name="tipo" value="{{ $tipo->id }}" id="tipo{{ $tipo->id }}">
                                        <label class="form-check-label" for="tipo{{ $tipo->id }}">
                                            {{ $tipo->descricao }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center" id="card_title">Entradas do mês: {{ date('m') }}</h3>
                        </div>
                        <div class="col-2">
                            <div class="row ">
                                <button type="button" class="btn btn-primary w-100" data-toggle="collapse" data-target="#collapseMes">Mês</button>
                            </div>
                        </div>
                    </div>
                    <div class="collapse mt-2 row" id="collapseMes">
                        <div class="card card-body">
                            <div class="btn-group w-100" role="group" aria-label="Grupo de botões com dropdown aninhado">
                                @php
                                    $i = date('m');
                                @endphp
                                @foreach ($meses as $key => $mes)
                                    <button type="button" class="btn btn-primary" onclick="filtrar({{ $i }})">{{ $mes }}</button>
                                    @php
                                        $i --;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm m-1" id="tabelaLista">
                        <thead>
                            <tr class="row">
                                <th class="col-4">Nome</th>
                                <th class="col-1">QTD</th>
                                <th class="col">Valor</th>
                                <th class="col">Entrada</th>
                                <th class="col">Nota</th>
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
    </div>

    <div class="modal fade" id="modalPDF" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('gerarPDFSaida') }}" method="POST" target="blank" class="form-horizontal" id="formFiltro">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tipoModal">Filtrar por:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5 class="card-title">Fornecedor:</h5>
                            <hr>
                            <div class="row ml-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fornecedorM[]" value="0" id="fornecedorM" checked>
                                    <label class="form-check-label" for="fornecedorM">
                                        Todos
                                    </label>
                                </div>
                            </div>
                            @foreach ($fornecedores as $fornecedor)
                                <div class="row ml-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fornecedorM[]" value="{{ $fornecedor->id }}" id="fornecedorM{{ $fornecedor->id }}" checked>
                                        <label class="form-check-label" for="fornecedorM{{ $fornecedor->id }}">
                                            {{ $fornecedor->nome }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <h5 class="card-title mt-2">Categoria:</h5>
                            <hr>
                            <div class="row ml-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tipoM[]" value="" id="tipoM" checked>
                                    <label class="form-check-label" for="tipoM">
                                        TODAS
                                    </label>
                                </div>
                            </div>
                            @foreach ($categoria as $tipo)
                                <div class="row ml-1">
                                    <div class="form-check">
                                        <input class="form-check-input tipo" type="checkbox" name="tipoM[]" value="{{ $tipo->id }}" id="tipoM{{ $tipo->id }}" checked>
                                        <label class="form-check-label" for="tipoM{{ $tipo->id }}">
                                            {{ $tipo->descricao }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
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
            tr.nota == null ? tr.nota = '#' : tr.nota;

            return '<tr class="row">' +
                        '<td class="col-4">' + tr.estoque.descricao + '</td>' +
                        '<td class="col-1">' + tr.qtd + '</td>' +
                        '<td class="col">' + 'R$ ' + formatNumber(tr.estoque.preco * tr.qtd) + '</td>' +
                        '<td class="col">' + tr.dia + '/' + tr.mes + '/' + tr.ano + '</td>' +
                        '<td class="col">' + tr.nota + '</td>' +
                    '</tr>';
        }

        function renderTabela(dados) {
            //$('input[name="tipo"]').attr('checked', false);

            $('#tabelaLista>tbody>tr').remove();

            for(let i = 0; i < dados.length; i++) {
                tr = renderLinha(dados[i]);
                $('#tabelaLista>tbody').append(tr);
            }
        }

        function filtrar(mes) {
            fornecedor_id = $('input[name="fornecedor"]:checked').val();
            categoria_id = $('input[name="tipo"]:checked').val();

            if(fornecedor_id == 0) {
                $.get('/api/filtrarSaida/' + mes, { page : 1 }, function(response) {
                    renderTabela(response.data);
                    renderPaginacao(response);

                    $('#paginator>ul>li>a').click(function() {
                        carregarEntrada2(mes, $(this).attr('pagina'));
                    });
                    $('#card_title').html('Entradas do mês: ' + mes);
                });
            } else {
                if(categoria_id > 0) {
                    $.get('/api/filtroRelatorioCategoriasMSaida/'+ fornecedor_id + '/' +  mes + '/' + categoria_id, { page : 1 }, function(response) {
                        renderTabela(response.data);
                        renderPaginacao(response);

                        $('#paginator>ul>li>a').click(function() {
                            carregarEntrada2(mes, $(this).attr('pagina'));
                        });
                        $('#card_title').html('Entradas do mês: ' + mes);
                    });
                } else {
                    $.get('/api/filtroRelatorioCategoriasMSaida/'+ fornecedor_id + '/' + mes, { page : 1 }, function(response) {
                        renderTabela(response.data);
                        renderPaginacao(response);

                        $('#paginator>ul>li>a').click(function() {
                            carregarEntrada2(mes, $(this).attr('pagina'));
                        });
                        $('#card_title').html('Entradas do mês: ' + mes);
                    });
                }
            }
        }

        function carregarEntrada2(mes, pagina) {
            $.get('/api/filtrarSaida/' + mes, { page : pagina }, function(response) {
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarEntrada2(mes, $(this).attr('pagina'));
                });
            });
        }

        function carregarEntrada(pagina) {
            //$('input[name="tipo"]').attr('checked', false);
            $('#tipo').filter('[value="0"]').attr('checked', true);
            $.get('/api/relSaida', { page : pagina }, function(response) {
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarEntrada($(this).attr('pagina'));
                });
            });
        }

        function filtroForn(id) {
            $.get('/api/filtroRelatorioSaida/'+ id, function(response) {
                $('input[name="tipo"]').attr('checked', false);
                $('#tipo').filter('[value="0"]').attr('checked', true);
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarEntrada($(this).attr('pagina'));
                });

            });
        }

        function filtroCat(id) {
            fornecedor_id = $('input[name="fornecedor"]:checked').val();

            if(fornecedor_id > 0) {
                //window.location.href = '/api/filtroRelatorioCat/'+ fornecedor_id + '/' + id;
                $.get('/api/filtroRelatorioCatSaida/'+ fornecedor_id + '/' + id, function(response) {
                    renderTabela(response.data);
                    renderPaginacao(response);

                    $('#paginator>ul>li>a').click(function() {
                        carregarEntrada($(this).attr('pagina'));
                    });

                });
            } else {
                $.get('/api/filtroRelatorioCategoriasSaida/'+ id, function(response) {
                    renderTabela(response.data);
                    renderPaginacao(response);

                    $('#paginator>ul>li>a').click(function() {
                        carregarEntrada($(this).attr('pagina'));
                    });

                });
            }
        }

        var qtdTipoM = document.querySelectorAll('input[name="tipoM[]"]').length;
        var qtdTipoF = document.querySelectorAll('input[name="fornecedorM[]"]').length;

        for (let i = 1; i <= qtdTipoM; i++) {
            $('#tipoM' + i).change(function() {
                if($('#tipoM' + i).prop('checked') == false) {
                    //alert()
                    $('#tipoM').prop('checked', false);
                }
            });
        }

        for (let i = 1; i <= qtdTipoF; i++) {
            $('#fornecedorM' + i).change(function() {
                if($('#fornecedorM' + i).prop('checked') == false) {
                    //alert()
                    $('#fornecedorM').prop('checked', false);
                }
            });
        }

        $('#fornecedorM').change(function() {
            if($('#fornecedorM').prop('checked') == true) {
                $('input[name="fornecedorM[]"]').prop('checked', true);
            } else {
                $('input[name="fornecedorM[]"]').attr('checked', false);
            }

        });

        $('#tipoM').change(function() {
            if($('#tipoM').prop('checked') == true) {
                $('input[name="tipoM[]"]').prop('checked', true);
            } else {
                $('input[name="tipoM[]"]').attr('checked', false);
            }

        });

        $(document).ready(function() {
            $('#fornecedor').filter('[value="0"]').attr('checked', true);
            $('#tipo').filter('[value="0"]').attr('checked', true);

            $('input[name="tipo"]').attr('checked', false);
            carregarEntrada(1);
        });
    </script>
@endsection
