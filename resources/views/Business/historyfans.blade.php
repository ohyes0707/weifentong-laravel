
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>商家中心-子商户</title>
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
				<div class="head task-head">历史涨粉</div>
				<form action="" method="get" class="form-inline checkform" role="form" id="f-history">
					<div class="form-group">
					    <label>
					    	公众号：					    	
					    </label>
                                            
					    <select name="gzh" class="form-control">
					    	<option value="">请选择</option>
                                                @foreach ($wxlist as $value)
					    	<option value="{{$value['wx_id']}}"
                                                        @if($termarray['gzh']==$value['wx_id'])
                                                        selected=
                                                        @endif
                                                        >{{$value['wx_name']}}</option>
					    	@endforeach
					    </select>						    
					</div>
					<div class="form-group">
                                            <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{$termarray['startdate']}}" readonly /></label>
						
                                            <label class="datelabel">至 <input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{$termarray['enddate']}}" readonly /></label>
						
					</div>
                                        <input type="type" value="{{$termarray['bussid']}}" name="bussid" hidden/>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<table class="table-bordered table-responsive checktable">
					<tr>
						<th>时间</th>
						<th>公众号</th>
						<th>成功关注</th>
						<th>取关量</th>
						<th>取关率</th>
					</tr>
                                        @if(count($paginator)>0)
                                        @foreach ($paginator as $value)
					<tr>
						<td>{{ $value['date'] }}</td>
						<td>{{ $value['username'] }}</td>
						<td>{{ $value['sumfans'] }}</td>
						<td>{{ $value['cancelfans'] }}</td>
						<td>{{ $value['cancelrate'] }}%</td>
					</tr>
                                        @endforeach
                                        @endif
				</table>
				
				{{ $paginator ->appends($termarray)->render() }}
				
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
                        
                        $('.excel').click(function(){
                                    $('.form-inline').attr("action", 'getHistoryFansExcel').submit();
                        })	
		        $(".reset").click(function(){
                            window.location.href='getHistoryFans?bussid={{$termarray['bussid']}}';
                        })
		})
	</script>
</html>
