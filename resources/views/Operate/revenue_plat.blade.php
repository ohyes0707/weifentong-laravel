<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>营收报表</title>
		@include('Operate.common.head')
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/statistics.css') }}"/>
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<div class="r_form clearfix">
						<div class="f_radio">
							<a href="revenueCount_plat" class="on_radio">平台</a>
							<a href="revenueCount_wechat">公众号</a>
							<a href="revenueCount_buss">渠道</a>
						</div>
					</div>
					<div class="form-group">
					    <label>
					    	用户选择：					    	
					    </label>
					    <select name="user" class="form-control">
					    	<option value="0">全部</option>
							@if(isset($user) && $user==1)
								<option value="1" selected>新用户</option>
							@else
								<option value="1">新用户</option>
							@endif
							@if(isset($user) && $user==2)
								<option value="2" selected>老用户</option>
							@else
								<option value="2">老用户</option>
							@endif
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" @if(isset($startDate))value="{{$startDate}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excel" value="0">
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<input type="button" value="导出excel" class="excel"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail colspan-6">
					<tr>
						<th>日期</th>
						<th>成功关注</th>
						<th>流水</th>
						<th>成本</th>
						<th>实际利润</th>
						<th>扣量利润</th>
					</tr>
					@if(isset($data) && !empty($data))
						@foreach($data as $k=>$v)
							<tr>
								<td>{{$k}}</td>
								<td>{{$v['follow']}}</td>
								<td>{{$v['float']}}</td>
								<td>{{$v['cost']}}</td>
								<td>{{$v['float']-$v['cost']}}</td>
								<td>{{$v['rest']}}</td>
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
			$("#datetimeStart").datetimepicker({
		    	format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
//		        startDate:new Date()
		    }).on("click",function(){
		        $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
		    });
		    $("#datetimeEnd").datetimepicker({
		        format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
//		        startDate:new Date()
		    }).on("click",function(){
		        $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
		    });
		    
		    
		    
		    //左边列表栏缩略
			

			$(".reset").click(function(){
				window.location.href='revenueCount_plat';
			})
			$(".find").click(function(){
				$("input[name=excel]").val(0);
				$("#f-report").attr('action','revenueCount_plat');
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
		    
		})
	</script>
</html>
