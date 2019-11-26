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
            <div class="row">
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
                                        <th>Autor</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-danger text-light">
                            <h2 class="card-title">Produtos com baixo Estoque</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-striped table-responsive-sm">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection