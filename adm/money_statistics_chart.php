<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(function() {
    var deposit_doughnut_options = {
        series: [79],
        chart: {
            height: 300,
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
        title: {
            text: '총 입출금 통계',
            // floating: true,
            align: 'left',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                fontFamily: 'Noto Sans KR',
                offsetY: 0
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            fontSize: '16px',
            fontWeight: 'bold',
            offsetY: -10,
            markers: {
                width:0,
                height:0
            },
            onItemClick: {
                toggleDataSeries: false
            },
        },
        colors: ['#19d9b4'],
        labels: ['입금'],
        };

        var deposit_doughnut_chart = new ApexCharts(document.querySelector("#deposit_doughnut"), deposit_doughnut_options);
        deposit_doughnut_chart.render();

    var withdraw_doughnut_options = {
        series: [62],
        chart: {
            height: 300,
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
        title: {
            text: '출금통계',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                fontFamily: 'Noto Sans KR',
                color: '#fff'
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            fontSize: '16px',
            fontWeight: 'bold',
            offsetY: -10,
            markers: {
                width:0,
                height:0
            },
            onItemClick: {
                toggleDataSeries: false
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
