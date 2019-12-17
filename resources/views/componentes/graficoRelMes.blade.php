@push('style')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endpush

@push('depois-java')
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
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
            $.get('/api/relEntradaMes', function(response) {

                /*for (let i = 0; i < response.length; i++) {
                    xlabel.push(response[i].mes);
                    xvalor.push(response[i].qtd);
                }*/
                "use strict";
                /*var line = new Morris.Line({
                    element: 'grafico_bar',
                    resize: true,
                    data: response,
                    xkey: 'mes',
                    ykeys: ['qtd'],
                    labels: ['Quantidade'],
                    gridLineColor: '#2f3d4a',
                    lineColors: ['#009efb'],
                    parseTime: false,
                    lineWidth: 1,
                    hideHover: 'auto'
                });*/
                Morris.Donut({
                    element: 'grafico_bar',
                    resize: true,
                    data: response,
                    xkey: 'mes',
                    ykeys: ['qtd'],
                    labels: ['Quantidade'],
                    formatter: function (y) { return y + " qtd" }
                });
                /*Morris.Bar({
                    element: 'grafico_bar',
                    resize: true,
                    data: response,
                    xkey: 'mes',
                    ykeys: ['qtd'],
                    labels: ['Quantidade'],
                });
                /*Morris.line({
                    element: 'morris-area-chart',
                    data: response,
                    xkey: 'mes',
                    ykeys: ['tipo', 'qtd'],
                    labels: ['tipo', 'qtd'],
                    pointSize: 5,
                    fillOpacity: 0,
                    pointStrokeColors: ['#55ce63',  '#2f3d4a', '#009efb'],
                    behaveLikeLine: true,
                    parseTime: false,
                    gridLineColor: '#e0e0e0',
                    lineWidth: 3,
                    hideHover: 'auto',
                    lineColors: ['#55ce63',  '#2f3d4a', '#009efb'],
                    resize: true
                });*/
            });
        });
    </script>
@endpush

<div class="card mt-3">
    <div class="card-body">
        <h4 class="card-title text-center">Relação de Entradas por Mês</h4>
        <div id="grafico_bar"></div>
    </div>
</div>
