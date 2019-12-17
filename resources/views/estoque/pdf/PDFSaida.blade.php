<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf" content="{{ csrf_token() }}">

    <title>Emissão de PDF</title>
    <style>
        body {
            font-family: 'Arial', Helvetica, sans-serif;
        }

        .container {
            max-width: 1100px;
            display: block;
            margin: 0 auto;
        }

        .card-header {
            width: 100%;
            height: 50px;
            border-radius: 5px;
            background-color: #545454;
        }

        .card-header h1 {
            margin-top: 0px;
            text-align: center;
            color: #fff;
        }

        table {
            margin: 15px auto;
            /*border: 2px solid #545454;*/
            border-radius: 5px;
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr th{
            border-bottom: 2px solid #545454;
        }

        table tbody tr td{
            border-bottom: 1px solid #545454;

            padding: 0;
        }

    </style>
  </head>
  <body>
    <div class="container">
            <div class="card-header">
                <h1> Relação de Entrada - {{ date('d/m/Y') }}</h1>
            </div>
            @empty($entrada)
                <h2 style="margin-left: 350px;">Não foi feita nenhuma saida</h2>
            @else
                <table id="tabelaEstoque" class="table table-sm table-bordered table-striped table-responsive-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Descrição</th>
                            <th>Código</th>
                            <th>QTD</th>
                            <th>Fornecedores</th>
                            <th>Data/Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrada as $key => $item)
                            <tr>
                                <td>{{ $entrada[$key]['estoque']['descricao'] }}</td>
                                <td>{{ $entrada[$key]['estoque']['cod_prod'] }}</td>
                                <td>{{ $entrada[$key]['qtd'] }}</td>
                                <td>{{ $entrada[$key]['fornecedores']['nome'] }}</td>
                                <td>{{ $entrada[$key]['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endempty
        </div>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</body>
</html>
