@push('depois-java')
    <script>
        /*Morris.Bar({
            element: 'grafico_bar',
            data: [
                { y: 'HTML', a: 100},
                { y: '2007', a: 75},
                { y: '2008', a: 50}
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Series A']
        });*/
        $(function () {
            var xlabel = [];
            var xvalor = [];
            var xtipo = [];
            var arm = '';
            $.get('/api/relSaidaMes', function(response) {
                "use strict";
                Morris.Donut({
                    element: 'grafico_bar',
                    resize: true,
                    data: response,
                    xkey: 'mes',
                    ykeys: ['qtd'],
                    labels: ['Quantidade'],
                    formatter: function (y) { return y + " qtd" }
                });
            });
        });
    </script>
@endpush

<div class="card mt-3">
    <div class="card-body">
        <h4 class="card-title text-center">Relação de Saida por Mês</h4>
        <div id="grafico_bar"></div>
    </div>
</div>
