<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script> 
<script type="text/javascript" charset="utf-8" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
    $(function() {
        var ctx = document.getElementById('postStatistics').getContext('2d');
        var postStatistics = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    '공지사항',
                    'Q&A',
                    '자유게시판',
                    '문의사항'
                ],
                datasets: [
                    {
                        data: [4, 10, 8, 3],
                        backgroundColor: [
                            '#506de8',
                            '#68c2f6',
                            '#19e0e5',
                            '#19d8b4'
                        ]
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false
                        },
                        scaleLabel: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            drawBorder: true,
                            display: true,
                        },
                        scaleLabel: {
                            display: false,
                        },
                        ticks: {
                            autoskip: true
                        }
                    }]
                }
            }
                
        });
    });
</script>
<canvas id="postStatistics"></canvas>