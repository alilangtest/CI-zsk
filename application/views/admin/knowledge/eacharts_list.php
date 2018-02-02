<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .eachart1 { width:600px; height:400px;float:left;}
    .eachart2 { width:600px; height:400px;float:left;}
</style>
<body>
<div class='eachart1'><div id="container" style="width: 600px; height: 400px;"></div></div>
<div class='eachart2'><div id="container1" style="width: 600px; height: 300px;"></div></div>
</body>
    <script src="/public/js/highcharts.js"></script>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script>
        $(function () {
    // Create the chart   创建了柱状图
    Highcharts.chart('container', {
        chart: {
            type: 'column',//可以变成bar看看效果哦！
            style: {
                fontFamily: "微软雅黑",
                fontSize: '13px',
                // fontWeight: 'bold',
                color: '#006cee'
            }
        },
        title: {
            text: '山东云天安全部门人数统一览表'
        },
        // subtitle: {
        //     text: '点击可查看具体的版本数据，数据来源: <a href="https://netmarketshare.com">netmarketshare.com</a>.'
        // },
        xAxis: {
            type: 'category',
            gridLineColor:'red',
            gridLineDashStyle:'solid'
        },
        yAxis: {
            title: {
                text: '部门所属人数'
            },
            gridLineColor:'red',
            gridLineDashStyle:'Dot'
           
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        credits:{
            enabled: false // 禁用版权信息
        },
        // { name='战略部', y=2 }, { name='监控中心', y=9 }
        series: [{
            name: '浏览器品牌',
            colorByPoint: true,
            data: [
               <?php echo $list; ?>
            ]
        }]
    });

    //创建饼状图
    Highcharts.chart('container1', {
        
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            },
            style: {
                fontFamily: "微软雅黑",
                fontSize: '13px',
                // fontWeight: 'bold',
                color: '#006cee'
            }
        },
        credits:{
            enabled: false // 禁用版权信息
        },
        title: {
            text: '个人知识/部门知识/公司共享比例分布图'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '各项占比',
            data: [
               <?php echo $arr;?>
            ]
        }]
    });

});

    </script>
</html>