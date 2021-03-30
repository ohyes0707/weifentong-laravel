<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>带粉中心-结算管理</title>
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
				<div class="balance clearfix">
					<div class="bal-left">
						<dl>
							<dt>您当前的账户余额（元）：</dt>
							<dd class="remain">{{$balance}}</dd>
							<dd class="withdraw"><a href="withdrawDeposit">提现</a><span>最低100元</span></dd>
						</dl>
					</div>
					<div class="bal-right">
						<dl>
							<dt>总金额（元）：</dt>
							<dd>{{$total}}</dd>
							<dt class="withdrawing">正在提现金额（元）：</dt>
							<dd>{{$withdrawals*0.95}}</dd>
						</dl>
					</div>
				</div>
				
				<form action="" method="post" class="form-inline checkform" role="form">
				{{csrf_field()}}
					<div class="head">结算明细</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startdate" class="form-control date" @if(isset($startDate))value="{{$startDate}}"@endif id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="enddate" class="form-control date" @if(isset($endDate))value="{{$endDate}}"@endif id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
				</form>
				
				<table class="table-bordered table-responsive checktable">
					<tr>
						<th>时间</th>
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
								<td>{{$datalist['op_money']*0.95}}</td>
								@if ($datalist['tixian_type'] == 1)
							        <td>银行卡</td>
							    @elseif ($datalist['tixian_type'] == 0)
							    	<td>支付宝</td>
							   	@endif
								<td>{{$datalist['real_name']}}</td>
								<td>{{$datalist['tixian_account']}}</td>
								@if ($datalist['status'] == 1)
							        <td class="green">已打款</td>
							    @elseif ($datalist['status'] == 2)
							    	<td class="red">审核失败</td>
							    @elseif ($datalist['status'] == 4)
							    	<td class="yellow">审核中</td>
							    @endif
								<td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}">查看</a></td>
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
				window.location.href='getParentBuss';
			})
		})
	</script>
	
</html>
