@push('style')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endpush

@push('depois-java')
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        $(function () {
            "use strict";
            $.get('/api/relComSaida', function(response) {
               // LINE CHART
               var line = new Morris.Bar({
                    element: 'morris-line-chart',
                    data: response,
                    xkey: 'label',
                    ykeys: ['value'],
                    labels: ['Quantidade'],
                    resize: true,
                    lineColors: ['#009efb'],
                });
            });
        });
    </script>
@endpush

<div class="card mt-3">
    <div class="card-body">
        <h4 class="card-title text-center">Relação de Saida por Categoria deste Mês</h4>
        <div id="morris-line-chart"></div>
    </div>
</div>
