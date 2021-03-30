<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>实时数据表</title>
		@include('Operate.common.head')	
<!--                <link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/statistics.css') }}"/>-->
                <script src="{{ URL::asset('operate/js/highcharts.js') }}" type="text/javascript" charset="utf-8"></script>
        </head>
	<body>
		@include('Operate.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					<div class="r_form real-form clearfix">
						<div class="f_radio">
							<a href="javascript: void(0)" class="on_radio">平台数据</a>
							<a href="realtimedesc">渠道数据</a>
						</div>
					</div>
					
					
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>日期</th>
						<th>获取公众号</th>
						<th>成功获取公众号</th>
						<th>填充率</th>
						<th>微信认证</th>
						<th>认证率</th>
						<th>成功关注</th>
						<th>关注率</th>
					</tr>
					<tr>
						<td>2017-8-14</td>
						<td>500</td>
						<td>400</td>
						<td>80%</td>
						<td>300</td>
						<td>75%</td>
						<td>200</td>
						<td>66%</td>
					</tr>
				</table>
				
				<div id="container" style="min-width:400px;height:500px;border: 1px solid #ccc;"></div>
				
				
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });
                function activeLastPointToolip(chart) {
                    var points = chart.series[0].points;
                    chart.tooltip.refresh(points[points.length -1]);
                }
                $('#container').highcharts({
                    chart: {
                        type: 'spline',
                        animation: Highcharts.svg, // don't animate in old IE
                        marginRight: 10,
                        events: {
                            load: function () {
                                // set up the updating of the chart each second
                                var series = this.series[0],
                                    chart = this;

                                setInterval(function () {
                                var x,y;
                                    $.get('http://{{Config::get('config.API_URL')}}data/getSumPlatform/v1.0',function(result){

                                            //$.each(result, function(i,point) {
                                                x = (new Date()).getTime(); // current time
                                                y =result.data.follow;
                                                series.addPoint([x, y], true, true);
                                                activeLastPointToolip(chart)
                //                                var x = (new Date()).getTime(), // current time
                //                                y = Math.random();
                                            //});


                                    })


                                }, 5000);
                            }
                        }
                    },
                    title: {
                        text: '当日实时涨粉数据'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150
                    },
                    yAxis: {
                        allowDecimals:false,
                        title: {
                            text: '涨粉数'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                                Highcharts.numberFormat(this.y, 2);
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    exporting: {
                        enabled: false
                    },
                    series: [{
                        name: '实时涨粉数',
                        data: (function () {
                            // generate an array of random data
                            var hhd;
                            $.ajax({  
                                type : "get",  
                                url : "http://{{Config::get('config.API_URL')}}data/getSumPlatform/v1.0",  
                                async : false,//取消异步  
                                success : function(data){  
                                    hhd =data.data.follow;
                                }  
                            });                             

                            var data = [],
                            time = (new Date()).getTime(),
                            i;
                           for (i = -10; i <= 0; i += 1) {
                                data.push({
                                    x: time + i * 2000,
                                    y: hhd
                                });
//
                            }
                            return data;
                        }())
                    }]
                }, function(c) {
                    activeLastPointToolip(c)
                });
	</script>
        
        <script type="text/javascript">
            getData();
		
		setInterval(function(){
			getData();
		},5000)
		
		
		function getData(){
			var str='<tr><th>日期</th><th>获取公众号</th><th>成功获取公众号</th><th>填充率</th><th>微信认证</th><th>认证率</th><th>成功关注</th><th>关注率</th></tr>';
			$.ajax({
				type:"get",
				url:"http://{{Config::get('config.API_URL')}}data/getSumPlatform/v1.0",
				success: function(data){
					str+='<tr><td>'+data.data.date+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.getwx+'</td><td>'+data.data.fillrate+'%</td><td>'+data.data.complet+'</td><td>'+data.data.confirmrate+'%</td><td>'+data.data.follow+'</td><td>'+data.data.followate+'%</td></tr>'
					$('table.detail').html(str)
				}
			});
		}
        </script>
</html>
