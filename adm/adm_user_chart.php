<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
  #chart {
    /* max-width: 1200px; */
    margin: 10px auto;
  }
  .apexcharts-toolbar {
    display: none
    
  }
</style>

<script>
  $(function() {
    var options = {
      chart: {
        height: 330,
        type: "area",
      },
      dataLabels: {
        enabled: false
      },
      title: {
        text: '이용자수 통계',
        style: {
          fontSize: '20px',
          fontWeight: 'bold',
          fontFamily: 'Noto Sans KR'
        }
      },
      series: [
        {
          type: 'area',
          name: '방문자',
          data: [40, 30, 28, 35, 20, 38, 50, 37, 18, 36, 17, 37]
        },
        {
          type: 'area',
          name: '프로그램 사용',
          data: [35, 28, 34, 39, 46, 40, 33, 24, 26, 24, 22, 20]
        }
      ],
      stroke: {
        width:3
      },
      legend: {
        position: 'top',
        offsetX: 380,
        offsetY: -50,
        fontSize: '16px',
        fontWeight: 'bold',
        fontFamily: 'Noto Sans KR',
        itemMargin: {
          horizontal: 10
        }
      },
      colors: ['#2a70e9','#764eed'],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'light',
          shadeIntensity: 1,
          opacityFrom: 0.8,
          opacityTo: 0.9,
          stops: [0, 90, 100],
        }
      },
      stroke: {
        curve : 'smooth'
      },
      xaxis: {
        categories: [
          "20.08",
          "20.09",
          "20.10",
          "20.11",
          "20.12",
          "21.01",
          "21.02",
          "21.03",
          "21.04",
          "21.05",
          "21.06",
          "21.07"
        ],
        tickPlacement: 'on'
      },
      yaxis: {
        show: false
      }
  };

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
  });
  
</script>

<div id="chart">
</div>
