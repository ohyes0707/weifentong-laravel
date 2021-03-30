<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>订单详情</title>
		@include('Home.common.head')
	</head>
	<body>
		@include('Home.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Home.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{ csrf_field() }}
					<div class="form-group">
					    <label>
					    	选择公众号：					    	
					    </label>
					    <select name="gzh" class="form-control">
					    	<option value="">请选择</option>
							@foreach($wx_list as $k)
								@if(isset($post['gzh']) && $post['gzh']==$k['o_wx_id'])
									<option selected value="{{$k['o_wx_id']}}">{{$k['wx_name']}}</option>
								@else
									<option value="{{$k['o_wx_id']}}">{{$k['wx_name']}}</option>
								@endif
							@endforeach
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" @if(isset($post['startDate']))value="{{$post['startDate']}}"@endif readonly /></label>
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" @if(isset($post['endDate']))value="{{$post['endDate']}}"@endif readonly /></label>
					</div>
					<div class="form-group">
					    <label>
					    	涨粉状态：					    	
					    </label>
					    <select name="state" class="form-control">
					    	<option value="">请选择</option>
							@if(isset($post['state']) && $post['state'] == 2)
								<option selected value="2">已暂停</option>
							@else
								<option value="2">已暂停</option>
							@endif
							@if(isset($post['state']) && $post['state'] == 1)
								<option selected value="1">涨粉中</option>
							@else
								<option value="1">涨粉中</option>
							@endif
							@if(isset($post['state']) && $post['state'] == 3)
								<option selected value="3">已关闭</option>
							@else
								<option value="3">已关闭</option>
							@endif
							@if(isset($post['state']) && $post['state'] == 4)
								<option selected value="4">已完成</option>
							@else
								<option value="4">已完成</option>
							@endif
					    </select>
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>				
				</form>
				
				<table class="table table-bordered table-responsive table-striped detail" id="reportTable">
					<tr>
						<th>公众号</th>
						<th>提交时间</th>
						<th>总涨粉量</th>
						<th>已涨粉</th>
						<th>日均涨粉</th>
						<th>当日取关率</th>
						<th>总取关率</th>
						<th>涨粉状态</th>
					</tr>
					@foreach($arr as $v)
					<tr>
						<td>{{$v['wx_name']}}</td>
						<td>{{$v['create_time']}}</td>
						<td>{{$v['o_total_fans']}}</td>
						<td>{{$v['total_fans']}}</td>
						<td>{{$v['day_fans']}}</td>
						@if($v['day_fans']!=0)
							<td>{{substr($v['un_subscribe_today']/$v['day_fans']*100,0,5)}}%</td>
						@else
							<td>0</td>
						@endif
						@if($v['o_total_fans']!=0)
							<td>{{substr($v['un_subscribe']/$v['o_total_fans']*100,0,4)}}%</td>
						@else
							<td>0</td>
						@endif
						<td>
							@if($v['order_status'] == 1)
								涨粉中
							@elseif($v['order_status'] == 2)
								暂停
							@elseif($v['order_status'] == 3)
								关闭
							@elseif($v['order_status'] == 4)
								完成
							@endif
						</td>
					</tr>
					@endforeach
				</table>
				{{ $paginator->appends($post)->render() }}
				
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			
			//选择日期
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
			
			
		})
	</script>
</html>
