<script>
    jQuery(document).ready(function() {
        var ctx = document.getElementById('positiveChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels:  {!! $positiveChartLabels !!},
                datasets: [{
                    data: {!! $positiveChartData !!},
                    label: 'Nº noticias',
                    borderColor: 'rgb(27, 51, 12)',
                    backgroundColor: 'rgb(27, 51, 12)'
                }]
            }
        });

        var ctx = document.getElementById('sentimientosChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $sentimientosChartLabels !!},
                datasets: [{
                    type: 'bar',
                    label: 'Media puntuación por sentimiento (sobre 100)',
                    data: {!! $sentimientosChartDataPuntuacion !!},
                    borderColor: 'rgb(27, 51, 12)',
                    backgroundColor: 'rgb(27, 51, 12,0.7)'
                }, {
                    type: 'line',
                    label: 'Casos de detectados',
                    data: {!! $sentimientosChartDataCasos !!},
                    fill: false,
                    borderColor:  'rgb(121, 195, 69)'
                }]
            }
        });
    });
</script>