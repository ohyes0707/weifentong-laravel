<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>代理管理-代理列表-报表</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<div class="head">代理名称:@if(isset($uname)){{$uname}}@endif</div>
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" @if(isset($startDate))value="{{$startDate}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" class="uid" @if(isset($uid))value="{{$uid}}"@endif/>
					<input type="hidden" class="uname" @if(isset($uname))value="{{$uname}}"@endif/>
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<input type="button" value="导出excel" class="excel"/>
				</form>
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>时间</th>
						<th>成功关注</th>
						<th>取关数</th>
						<th>取关率</th>
						<th>销售额</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['date_time']}}</td>
								<td>{{$v['follow']}}</td>
								<td>{{$v['unfollow']}}</td>
								<td>
									@if($v['follow'] != 0)
										{{sprintf('%.2f',$v['unfollow']/$v['follow']*100)}}%
									@else
										0.00%
									@endif
								</td>
								<td>{{$v['cost']}}</td>
							</tr>
						@endforeach
					@endif
				</table>
			</div>
		</div>
		
		
	</body>
	<script type="text/javascript">
		$(function(){
			$("#datetimeStart").datetimepicker({
		    	format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
		    }).on("click",function(){
		        $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
		    });
		    $("#datetimeEnd").datetimepicker({
		        format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
		    }).on("click",function(){
		        $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
		    });

			$(".reset").click(function(){
				uid = $(".uid").val();
				uname = $(".uname").val();
				window.location.href='agentForm?uid='+uid+'&uname='+uname;
			})
			$(".excel").click(function(){
				$(".excels").val(1);
				$("#f-report").submit();
			})
			$(".find").click(function(){
				$(".excels").val(0);
				$("#f-report").submit();
			})
			
		})
	</script>
</html>
