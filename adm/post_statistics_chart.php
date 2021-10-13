<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
  .apexcharts-legends {
      display: inline-block !important;
  }
</style>

<script>
  $(function() {
    var options = {
        chart: {
            height: 250,
            type: "bar"
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'middle',
            style: {
                colors: ['#fff','#fff','#fff','#fff']
            },
        },
        plotOptions: {
            bar: {
                borderRadius: 5,
                dataLabels: {
                    position: 'top'
                }
            }
        },
        colors: ['#4f6de7','#68c2f6','#1adbe0','#19d9b4'],
        title: {
            text: '총 게시물 통계',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                fontFamily: 'Noto Sans KR',
                offsetY: 100
            }
        },
        series: [
            {
                name: '공지사항',
                data: [<?php echo $notice_sql_sum;?>]
            },
            {
                name: 'Q&A',
                data: [<?php echo $qa_sql_sum;?>]
            },
            {
                name: '자유게시판',
                data: [<?php echo $free_sql_sum;?>]
            },
            {
                name: '문의사항',
                data: [<?php echo $qa_sql_sum;?>]
            }
        ],
        legend: {
            show: true,
            position: 'right',
            offsetY: 30,
            itemMargin: {
                horizontal: 20
            },
            markers: {
                radius:10,
                offsetX:-3
            },
            width: 240,
            horizontalAlign: 'right',
            onItemClick: {
                toggleDataSeries: false
            }
        },
        xaxis: {
            labels: {
                show: false
            },
            categories: [<?php echo $notice_sql_sum;?>,[<?php echo $qa_sql_sum;?>],<?php echo $free_sql_sum;?>,[<?php echo $qa_sql_sum;?>]]
        },
        yaxis: {
            show: true
        }
    };

var chart = new ApexCharts(document.querySelector("#chartss"), options);

chart.render();
  });

$(function() {
    $('#chartss').find('div.apexcharts-legend').addClass('apexcharts-legends');
    $('#chartss').find('div[rel="2"]').css('margin','2px 32px');
});

// 총 게시물 합계
$(function() {
    var notice_val = $('g[seriesName="공지사항"]').find('path').attr('val');
    var qna_val = $('g[seriesName="QxA"]').find('path').attr('val')
    var free_val = $('g[seriesName="자유게시판"]').find('path').attr('val')
    var reply_val = $('g[seriesName="문의사항"]').find('path').attr('val')

    $('.notice_val').text(notice_val);
    $('.qa_val').text(qna_val);
    $('.free_val').text(free_val);
    $('.reply_val').text(reply_val);

});

</script>

<div id="chartss">
</div>