<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>商家中心-子商户结算管理</title>
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
				<div class="head task-head">子商户结算管理</div>
				<form action="" method="post" class="form-inline checkform" role="form" id="f-history">
				{{csrf_field()}}
					<div class="form-group">
					    <label>
					    	子商户：					    	
					    </label>
					    <select name="subShop" class="form-control">
					    <option value="0">请选择</option>
					    @if(isset($paginator) && !empty($paginator))
						    @foreach ($paginator as $key => $namelist)
								
								@if(isset($subShop) && $subShop==$namelist['id'])
									<option selected value="{{$namelist['id']}}">{{$namelist['username']}}</option>
								@else
									<option  value="{{$namelist['id']}}">{{$namelist['username']}}</option>
								@endif
							@endforeach
					    @endif
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	提现状态：					    	
					    </label>
					    <select name="state" class="form-control">
							<option  value="0">请选择</option>
							@if(isset($state) && $state==1)
								<option selected value="1">已打款</option>
							@else
								<option  value="1">已打款</option>
							@endif
							@if(isset($state) && $state==2)
								<option selected value="2">审核失败</option>
							@else
								<option  value="2">审核失败</option>
							@endif

							@if(isset($state) && $state==4)
								<option selected value="4">未审核</option>
							@else
								<option  value="4">未审核</option>
							@endif
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startdate" class="form-control date" @if(isset($startDate))value="{{$startDate}}"@endif id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="enddate" class="form-control date" id="datetimeEnd" @if(isset($endDate))value="{{$endDate}}"@endif readonly /></label>
						
					</div>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
				</form>
				
				<table class="table-bordered table-responsive checktable">
					<tr>
						<th>时间</th>
						<th>子商户</th>
						<th>提现金额</th>
						<th>提现方式</th>
						<th>提现姓名</th>
						<th>提现账号</th>
						<th>提现状态</th>
						<th>操作</th>
					</tr>
					@if(isset($paginator) && !empty($paginator))
						@foreach ($paginator as $key => $datalist)
							@if(isset($datalist) && !empty($datalist))
							<tr>
								<td>{{date('Y-m-d',strtotime($datalist['create_date']))}}</td>
								<td>{{$datalist['username']}}</td>
								<td>{{$datalist['op_money']}}</td>
								@if ($datalist['tixian_type'] == 1)
							        <td>银行卡</td>
							    @elseif ($datalist['tixian_type'] == 0)
							    	<td>支付宝</td>
							   	@endif
								<td>{{$datalist['real_name']}}</td>
								<td>{{$datalist['tixian_account']}}</td>
								@if ($datalist['status'] == 1)
							        <td class="green">已打款</td>
							        <td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}">查看</a></td>
							    @elseif ($datalist['status'] == 2)
							    	<td class="red">审核失败</td>
							    	<td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}">查看</a></td>
							    @elseif ($datalist['status'] == 4)
							    	<td class="yellow">未审核</td>
							    	<td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}" class="audit">审核</a></td>
							    @endif
								
							</tr>
							@endif
						@endforeach
					@endif
					
				</table>
				@if(isset($paginator) && !empty($paginator))
				{{ $paginator->appends($termarray)->render() }}
				@endif
				
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
			$(".reset").click(function(){
				window.location.href='childManage';
			})
		})
	</script>
</html>
