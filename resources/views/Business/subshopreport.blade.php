
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>商家中心-子商户-报表</title>
		@include('Business.common.head')
        </head>
	<body>
		<!--导航栏-->
		@include('Business.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Business.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="get" class="form-inline checkform" role="form">
					<div class="form-group">
                                            <label class="datelabel">选择时间：<input type="text" name="startdate" class="form-control date" id="datetimeStart" value="{{$termarray['startdate']}}" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="enddate" class="form-control date" id="datetimeEnd" value="{{$termarray['enddate']}}" readonly /></label>
						
					</div>
                                    <input type="text" name="bussid" hidden="" value="{{$termarray['bussid']}}"/>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<table class="table-bordered table-responsive checktable">
					<tr>
						<th>日期</th>
						<th>带粉数</th>
						<th>取关数</th>
						<th>取关率</th>
						<th>收益</th>
					</tr>
                                        @if($sumdata['date']!=null)
					<tr>
						<td>{{ $sumdata['date'] }}</td>
						<td>{{ $sumdata['sumfans'] }}</td>
						<td>{{ $sumdata['cancelfans'] }}</td>
						<td>{{ $sumdata['cancelrate'] }}%</td>
						<td>{{ $sumdata['money'] }}</td>
					</tr>
                                        @endif
                                        @foreach ($paginator as $value)
					<tr>
						<td>{{ $value['date'] }}</td>
						<td>{{ $value['sumfans'] }}</td>
						<td>{{ $value['cancelfans'] }}</td>
						<td>{{ $value['cancelrate'] }}%</td>
						<td>{{ $value['money'] }}</td>
					</tr>
                                        @endforeach
				</table>
				
				{{ $paginator ->appends($termarray)->render() }}
				
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
                        $('.excel').click(function(){
                                        $('.form-inline').attr("action", 'getSubShopReportExcel').submit();
                        })
                        
		        $(".reset").click(function(){
                            window.location.href='getSubShopReport?bussid={{$termarray['bussid']}}';
                        })
		})
	</script>
</html>
