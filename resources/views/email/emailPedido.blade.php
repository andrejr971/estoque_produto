<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        body {
            font-family: Arial, Helvetica, 'sans-serif';
            font-size: 1.2em;
        }

        h1 {
            text-align: center;
            font-size: 1.5em;
            border-bottom: 2px solid #545454;
        }

        h3 {
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr, tbody tr {
            border-bottom: 1px solid #545454;
        }

        thead tr th {
            font-weight: 700;
            text-transform: uppercase;
        }

        tbody tr td {
            text-align: center;
        }

    </style>
</head>
<body>
    <h1>{{ $dados[0]['assunto'] }}</h1>
    <h3>{{ ($dados[1]['obs'] !== null) ? $dados[1]['obs'] : ''}}</h3>
    
    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Código Item</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados['itens_pedido'] as $key => $item)
                <tr>
                    <td>{{ $item['pedido_item_estoque']['descricao'] }}</td>
                    <td>{{ $item['pedido_item_estoque']['ncm_item'] }}</td>
                    <td>{{ $item['qtd'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>