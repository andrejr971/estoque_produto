@push('depois-java')
    <script>
        Morris.Bar({
            element: 'grafico_bar',
            data: [
                { y: 'HTML', a: 100},
                { y: '2007', a: 75},
                { y: '2008', a: 50}
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Series A']
        });
    </script>
@endpush

<div class="card mt-3">
    <div class="card-body">
        <h4 class="card-title text-center">Relação de Entradas por Categoria deste Mês</h4>
        <div id="grafico_bar"></div>
    </div>
</div>
