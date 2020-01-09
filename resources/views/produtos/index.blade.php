@extends('layout.index')

@section('conteudo')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h1 class="card-title">Produtos Padrão</h1>
                </div>
                <div class="col-3">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalTipoProduto" class="btn btn-outline-primary w-100">Adicionar Produto</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @empty($produtos)
                <h5>Não há produtos Cadastrados</h5>
            @else
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Tipo</th>
                            <th>Descricao</th>
                            <th>Preço</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td>{{ $produto->img01 }}</td>
                                <td>#</td>
                                <td>{{ $produto->descricao }}</td>
                                <td>{{ $produto->preco }}</td>
                                <td>#</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endempty
        </div>
    </div>

    <div class="modal fade" id="modalTipoProduto" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formTipo">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="TituloModalLongoExemplo">Escolha o Tipo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($tipo_produtos as $tipo)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="{{ $tipo->id }}" name="tipo" id="tipo{{ $tipo->id }}">
                                <label class="form-check-label" for="tipo{{ $tipo->id }}">
                                    {{ $tipo->nome }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>

        $('#formTipo').submit(function(e) {
            e.preventDefault();

            if($('#tipo1').prop('checked')) {
                window.location.href = '{{ route("criarFornecido") }}';
            } else if($('#tipo2').prop('checked')) {
                alert();
            } else if($('#tipo3').prop('checked')) {
                alert();
            } else {
                alert('Por favor, selecione uma das opções');
            }
        });
    </script>
@endsection
