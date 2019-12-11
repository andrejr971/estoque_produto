@extends('layout.index')

@push('style')
    <style>
        .usar_xml:checked ~ div.xml {
            display: block;
        }
        .xml {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('conteudo')
   <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title">Estoque</h1>
                </div>
                <div class="col">
                    <a href="/estoque/ver" class="btn btn-outline-primary w-100">Ver Estoque</a>
                </div>
                <div class="col">
                    <a href="{{ route('EstoqueGrupo') }}" class="btn btn-outline-dark w-100">Nova Categoria</a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-outline-success w-100" data-toggle="modal" data-target="#modalTipo">Entrada</a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-outline-danger w-100" data-toggle="collapse" data-target="#retirada" id="btnSaida">Saída</a>
                </div>
                <div class="col">
                    <div class="dropdown">
                        <button class="btn btn-outline-success w-100 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gerar Relatório
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('gerarPDFEntrada') }}">Entrada</a>
                            <a class="dropdown-item" href="#">Saída</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Entrada e Saída</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse mt-2 w-100" id="retirada">
                <div style="height: 5px;" class="bg-danger"></div>
                <div class="card card-body">                    
                    <h3 class="card-title text-center">Retirada do Estoque</h3>
                    <form action="{{ route('saidaEstoque') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-5">
                                <input type="text" name="saida" id="saida" placeholder="Código Interno ou Nome" class="form-control">
                            </div>
                            <div class="col-2">
                                <input type="number" name="qtd" id="qtd" value="1" class="form-control">
                            </div>
                            <div class="col">
                                <input type="text" name="nota" id="nota" placeholder="Nota" class="form-control">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-danger w-100" id="retirar">Retirar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-3 mb-3">
                <div class="col-4">
                    <div class="card">
                        <div style="height: 5px;" class="bg-primary"></div>
                        <div class="card-body" >
                            <h3 class="card-title text-center" id="itens"></h3>
                            <a href="/estoque/ver" class="btn btn-outline-primary w-100">Estoque</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div style="height: 5px;" class="bg-warning"></div>
                        <div class="card-body">
                            <h3 class="card-title text-center" id="chapas"></h3>
                            <a href="/estoque/verChapas" class="btn btn-outline-warning w-100">Estoque</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div style="height: 5px;" class="bg-info"></div>
                        <div class="card-body">
                            <h3 class="card-title text-center" id="inflamaveis"></h3>
                            <a href="/estoque/verInflamaveis" class="btn btn-outline-info w-100">Estoque</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <div class="card">
                        <div style="height: 5px;" class="bg-success"></div>
                        <div class="card-body">
                            <h3 class="card-title text-center" id="geral"></h3>
                            <a href="/estoque/verGeral" class="btn btn-outline-success w-100">Estoque</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div style="height: 5px;" class="bg-secondary"></div>
                        <div class="card-body">
                            <h3 class="card-title text-center" id="textil"></h3>
                            <a href="/estoque/verTecido" class="btn btn-outline-secondary w-100">Estoque</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div style="height: 5px;" class="bg-dark"></div>
                        <div class="card-body">
                            <h3 class="card-title text-center" id="outros"></h3>
                            <a href="/estoque/verTecido" class="btn btn-outline-dark w-100">Estoque</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-success text-light">
                            <h2 class="card-title">Ultimas Entradas</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-striped table-responsive-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fornecedor</th>
                                        <th>Item</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrada as $item)
                                        <tr>
                                            <td>{{ $item->fornecedores->nome }}</td>
                                            <td>{{ $item->estoque->descricao }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-success w-100">Ver mais</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-danger text-light">
                            <h2 class="card-title">Produtos com baixo Estoque</h2>
                        </div>
                        <div class="card-body">
                            <table id="tabelaBaixo" class="table table-sm table-bordered table-striped table-responsive-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>QTD/UN</th>
                                        <th>Fornecedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @foreach ($estoque as $item)
                                        @if ($item->qtd <= 1)
                                            <tr>
                                                <td>{{ $item->descricao }}</td>
                                                <td>{{ $item->qtd . ' '. $item->un_medida}}</td>
                                                @foreach ($item->fornecedores as $fornecedor)
                                                    <td>{{ $fornecedor->nome }}</td>
                                                @endforeach
                                            </tr>
                                            @php
                                                $cont ++;
                                                
                                                if($cont == 3) {
                                                    break;
                                                }
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="/estoque/verBaixo" class="btn btn-outline-danger w-100">Ver mais</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-secondary text-light">
                            <h2 class="card-title">Ordem de Compra (OC)</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-striped table-responsive-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Fornecedor</th>
                                        <th>QTD/UN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @foreach ($estoque as $item)
                                        @if ($item->qtd <= $item->estoque_min)
                                            <tr>
                                                <td>{{ $item->descricao }}</td>
                                                @foreach ($item->fornecedores as $fornecedor)
                                                    <td>{{ $fornecedor->nome }}</td>
                                                @endforeach
                                                <td>{{ $item->qtd . ' '. $item->un_medida}}</td>
                                            </tr>
                                            @php
                                                $cont ++;
                                                
                                                if($cont == 3) {
                                                    break;
                                                }
                                            @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-secondary w-100">Ver mais</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-warning text-light">
                            <h2 class="card-title">Produtos com baixo Estoque</h2>
                        </div>
                        <div class="card-body">
                            <table id="" class="table table-sm table-bordered table-striped table-responsive-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>QTD/UN</th>
                                        <th>Fornecedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-warning w-100">Ver mais</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTipo" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('entrada') }}" class="form-horizontal" id="formEntrada" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tipoModal">Escolha uma opção</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="xml" id="manual" value="1" checked>
                            <label class="form-check-label" for="manual">
                                Manual
                            </label>
                        </div>
                        <div class="form-check ">
                            <input class="form-check-input usar_xml" type="radio" name="xml" id="xml" value="2">
                            <label class="form-check-label" for="xml">
                                Usar XML
                            </label>
                            <div class="form-group xml">
                                <div class="row">
                                    <div class="col">
                                        <input type="file" name="upFile" accept=".xml">  
                                    </div>
                                </div>  
                            </div>
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

    <div class="modal fade" id="modalSaida" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" class="form-horizontal" id="formEntrada" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="tipoModal">Retirada do Estoque</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" name="saida" id="saida" placeholder="Código de barras ou Interno" class="form-control">
                                </div>
                                <div class="col">
                                    <input type="number" name="qtd" id="qtd" value="1" class="form-control">
                                </div>
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

@push('antes-java')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush

@section('javascript')
    <script>
        const tabelaElemento = document.querySelector('#tabelaBaixo tbody');

        axios.get('/api/estoque')
                .then(function(response) {
                    countItens(response.data);
                })
                .catch(function(erro) {
                    alert(erro);
                });

        function countItens(contador) {
            let cont1 = 0;
            let cont2 = 0;
            let cont3 = 0;
            let cont4 = 0;
            let cont5 = 0;

            for(cont of contador) {

                for(tipo of cont.fornecedores) {
                    if(tipo.pivot.tipo_estoque_id == 1) {
                        cont1 ++;
                    } else if(tipo.pivot.tipo_estoque_id == 2) {
                        cont2 ++;
                    } else if(tipo.pivot.tipo_estoque_id == 3) {
                        cont3 ++;
                    } else if(tipo.pivot.tipo_estoque_id == 4) {
                        cont4 ++;
                    } else {
                        cont5 ++;
                    }
                }
            }

            var valor = 'Total : ' + contador.length;
            var valor1 = 'Chapas : ' + cont1;
            var valor2 = 'Inflamáveis : ' + cont2;
            var valor3  = 'Geral : ' + cont3;
            var valor4  = 'Textil : ' + cont4;
            var valor5  = 'Outros : ' + cont5;

            $('#itens').append(valor);
            $('#chapas').append(valor1);
            $('#inflamaveis').append(valor2);
            $('#geral').append(valor3);
            $('#textil').append(valor4);
            $('#outros').append(valor5);
        }

        function autoComple(dados) {
            $("#saida" ).autocomplete({
                source: dados
            });
        }

        $(document).ready(function() {
            $('#btnSaida').click(function() {
                var dados = [];

                axios.get('/api/estoque')
                .then(function(response) {
                    for(dado of response.data) {
                        if(dado.qtd > 1) {
                            dados.push(dado.cod_item + ' - ' + dado.descricao);
                        }
                    }
                    autoComple(dados);
                })
                .catch(function(erro) {
                    alert(erro);
                });
            });
        });
        
    </script>
@endsection