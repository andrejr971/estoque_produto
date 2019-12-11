@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title">Entrada</h1>
                </div>
                <div class="col-3">
                    <a href="/estoque/ver" class="btn btn-outline-primary w-100">Ver Estoque</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <h3>Itens a serem adicionados</h3>
                </div>
                <div class="col-3">
                    <a href="#" class="btn btn-info w-100" data-toggle="modal" data-target="#modalCategoria">Adicionar Categorias</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Un. Medida</th>
                        <th>Valor Un.</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($produtos); $i ++)
                        @if ($produtos[$i]['existe'] == 1)
                            <tr>
                                <td>{{ $produtos[$i]['codigo'] }}</td>
                                <td>{{ $produtos[$i]['nome'] }}</td>
                                <td>{{ $produtos[$i]['qtd'] }}</td>
                                <td>{{ $produtos[$i]['un_medida'] }}</td>
                                <td>R$ {{ number_format($produtos[$i]['valor_un'], 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($produtos[$i]['valor'], 2, ',', '.') }}</td>
                            </tr>
                        @else
                            <tr>
                                <td id="teste">{{ $produtos[$i]['codigo'] }}</td>
                                <td>{{ $produtos[$i]['nome'] }}</td>
                                <td>{{ $produtos[$i]['qtd'] }}</td>
                                <td>{{ $produtos[$i]['un_medida'] }}</td>
                                <td>R$ {{ number_format($produtos[$i]['valor_un'], 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($produtos[$i]['valor'], 2, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
 
    <div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="tipoModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/entrada/addItens" class="form-horizontal" id="formEntrada2" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="fornecedor_id" value="{{ $produtos[0]['fornecedor'] }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tipoModal">Escolha uma categoria p/ os itens</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group xml">
                            <div class="row">
                                <div class="w-100 ml-3">
                                    <label>Nota Fiscal (DANFE)<span style="color: red;">*</span></label>
                                </div>
                                <div class="col">
                                    <input type="file" name="upFile" accept=".xml, .pdf" required>  
                                </div>
                            </div>  
                        </div>
                        <input type="hidden" name="contProd" value="{{ count($produtos) }}">
                        @for ($i = 0; $i < count($produtos); $i ++)
                            @if ($produtos[$i]['existe'] == 0)
                                <div class="row mt-1">
                                    <div class="col-3">
                                        <label>Código</label>
                                        <input type="text" class="form-control" name="cod_prod{{ $i }}" value="{{ $produtos[$i]['codigo'] }}" >
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Categoria <span style="color: red;">*</span></label>
                                            <select name="categoria{{ $i }}" id="categoria{{ $i }}" class="form-control">
                                                @foreach ($grupos as $grupo)
                                                    <option value="{{ $grupo->id }}">{{ $grupo->descricao }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
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
        function categoria(cod_prod, fornecedor_id) {

        }
    </script>
@endsection