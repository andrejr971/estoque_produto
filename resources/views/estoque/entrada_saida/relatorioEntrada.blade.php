@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title">Relatório - Entradas</h1>
                </div>
                <div class="col-3">
                    <a href="/estoque/ver" class="btn btn-outline-primary w-100">Ver Estoque</a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6 m-2">
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
            <div class="col-lg-5 m-2">
                <div class="row">
                    <div class="col-lg-12">
                        @component('componentes.graficoRelTipo')
                        @endcomponent
                    </div>
                    <div class="col-lg-12">
                        @component('componentes.graficoRelMes')
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('antes-java')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

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
            $('#tabelaLista>tbody>tr').remove();

            for(let i = 0; i < dados.length; i++) {
                tr = renderLinha(dados[i]);
                $('#tabelaLista>tbody').append(tr);
            }
        }

        function filtrar(mes) {
            $.get('/api/filtrarEntrada/' + mes, { page : 1 }, function(response) {
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarEntrada2(mes, $(this).attr('pagina'));
                });
                $('#card_title').html('Entradas do mês: ' + mes);
            });
        }

        function carregarEntrada2(mes, pagina) {
            $.get('/api/filtrarEntrada/' + mes, { page : pagina }, function(response) {
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarEntrada2(mes, $(this).attr('pagina'));
                });
            });
        }

        function carregarEntrada(pagina) {
            $.get('/api/relEntrada', { page : pagina }, function(response) {
                renderTabela(response.data);
                renderPaginacao(response);

                $('#paginator>ul>li>a').click(function() {
                    carregarEntrada($(this).attr('pagina'));
                });
            });
        }

        $(document).ready(function() {
            carregarEntrada(1);
       });
    </script>
@endsection
