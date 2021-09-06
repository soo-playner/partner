<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(function() {
    var deposit_doughnut_options = {
        series: [79],
        chart: {
        height: 250,
        type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            hollow: {
              size: '60%',
            },
            dataLabels: {
                name: {
                    show: false
                },
                value: {
                    fontSize: '28px',
                    fontWeight: 'bold',
                    offsetY: 15
                },
            },
          },
        },
        legend: {
            
        },
        colors: ['#19d9b4'],
        labels: ['입금'],
        };

        var deposit_doughnut_chart = new ApexCharts(document.querySelector("#deposit_doughnut"), deposit_doughnut_options);
        deposit_doughnut_chart.render();

    var withdraw_doughnut_options = {
        series: [79],
        chart: {
        height: 250,
        type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            hollow: {
              size: '60%',
            },
            dataLabels: {
                name: {
                    show: false
                },
                value: {
                    fontSize: '28px',
                    fontWeight: 'bold'
                },
            },
          },
        },
        colors: ['#68c2f6'],
        labels: ['출금'],
        };

        var withdraw_doughnut_chart = new ApexCharts(document.querySelector("#withdraw_doughnut"), withdraw_doughnut_options);
        withdraw_doughnut_chart.render();
    });
</script>

<div id="deposit_doughnut"></div>
<div id="withdraw_doughnut"></div>
