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
        <div class="row">
            <div class="col-8">
                <div class="m-2">
                    <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contato</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">...</div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                    </div>
                </div>
                <table class="table table-sm m-2" id="tabelaLista">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nome</th>
                            <th>QTD</th>
                            <th>Valor Un.</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itens as $item)
                            <tr>
                                <td>{{ $item->estoque->cod_prod }}</td>
                                <td>{{ $item->estoque->descricao }}</td>
                                <td>{{ $item->qtd }}</td>
                                <td>R$ {{ number_format($item->estoque->preco, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($item->qtd * $item->estoque->preco, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col">
                <div class="w-100 bg-dark">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate officiis, perferendis illum doloribus illo minima a rem. Voluptas cumque dolore nostrum dolores pariatur consequuntur illo repellat praesentium est odit. Ullam.
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
    </script>
@endsection