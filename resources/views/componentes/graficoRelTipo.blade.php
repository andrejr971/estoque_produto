@push('style')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endpush

@push('depois-java')
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        $(function () {
            "use strict";
            $.get('/api/relComEntrada', function(response) {
               // LINE CHART
                var line = new Morris.Line({
                    element: 'morris-line-chart',
                    resize: true,
                    data: response,
                    xkey: 'label',
                    ykeys: ['value'],
                    labels: ['Quantidade'],
                    gridLineColor: '#eef0f2',
                    lineColors: ['#009efb'],
                    parseTime: false,
                    lineWidth: 1,
                    hideHover: 'auto'
                });
            });
        });
    </script>
@endpush

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Relação de Entradas por Categoria deste Mês</h4>
        <div id="morris-line-chart"></div>
    </div>
</div>
