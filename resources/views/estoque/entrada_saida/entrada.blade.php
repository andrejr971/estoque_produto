@extends('layout.index')

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
                    <a href="#" class="btn btn-outline-success w-100">Entrada</a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-outline-danger w-100">Saída</a>
                </div>
                <div class="col">
                    <div class="dropdown">
                        <button class="btn btn-outline-success w-100 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gerar Relatório
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Entrada</a>
                            <a class="dropdown-item" href="#">Saída</a>
                            <a class="dropdown-item" href="#">Entrada e Saída</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Compras deste mês</a>
                        </div>
                    </div>
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
@endsection

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

    </script>
@endsection