<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href=" {{ asset('css/app.css') }} " >
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    
    @stack('style')
    
    <title>Teste</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Teste</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(Página atual)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/estoque">Estoque</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/fornecedor">Fornecedor</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pedidos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('carrinhoPedido') }}">Carrinho</a>
                        <a class="dropdown-item" href="{{ route('pedidosEstoqueEN') }}">Enviados</a>
                        <a class="dropdown-item" href="{{ route('pedidosEstoqueCP') }}">Autorizados</a>
                        <a class="dropdown-item" href="{{ route('pedidosEstoqueFP') }}">Finalizados</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('pedidosEstoqueOK') }}">Dar Baixa</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-3">
        @if (session('resul'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h3 class="text-center">{{ session('resul') }}</h3>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @hasSection ('conteudo')
            @yield('conteudo')
        @endif

    </div>
    
    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    @stack('antes-java')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
    @hasSection ('javascript')
        @yield('javascript')
    @endif
</body>
</html>