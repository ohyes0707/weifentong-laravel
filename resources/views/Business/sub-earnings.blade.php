<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>带粉中心-带粉收益</title>
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
				<form action="" method="post" class="form-inline checkform" role="form" id="f-report">
					{{csrf_field()}}
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" @if(isset($startDate))value="{{$startDate}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excel" value="0">
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<table class="table-bordered table-responsive checktable">
					<tr>
						<th>时间</th>
						<th>带粉数</th>
						<th>收益</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['date']}}</td>
								<td>{{$v['follow']+0}}</td>
								<td>{{sprintf('%.2f',$v['num'])}}</td>
							</tr>
						@endforeach
					@endif
				</table>

				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
			$(".reset").click(function(){
				window.location.href = 'fansEarn_child';
			})
			$(".find").click(function(){
				$("input[name=excel]").val(0);
				var startDate = new Date($('#datetimeStart').val()).getTime()
				var endDate = new Date($('#datetimeEnd').val()).getTime()
				var delta=parseInt((endDate-startDate)/1000/60/60/24);
				if(delta>29){
					alert('数据太多啦，请导出Excel查看');
				}else{
					$("#f-report").submit();
				}
			})
			$(".excel").click(function(){
				$("input[name=excel]").val(1);
				var excel = $("input[name=excel]").val();
				$("#f-report").submit();
			})
			var day=new Date();
			day.setTime(day.getTime()-24*60*60*1000)
			var yesterday=day.getFullYear()+'-'+(day.getMonth()+1)+'-'+day.getDate()
			$("#datetimeEnd").datetimepicker("setEndDate",yesterday);
		})
	</script>
</html>
