
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>商家中心-子商户</title>
		@include('Business.common.head')
	</head>
	<body>
		@include('Business.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Business.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<div class="head task-head">子商户</div>
				<div class="addshop"><a href="getAddSubShop">+新增子商户</a></div>
				<table class="table-bordered table-responsive checktable">
					<tr>
						<th>子商户名称</th>
                                                <th>今日带粉</th>
						<th>取关数</th>
						<th>昨日带粉</th>
						<th>30天带粉</th>
						<th>操作</th>
					</tr>
                                        @foreach ($paginator as $value)
					<tr>
						<td>{{ $value['username'] }}</td>
						<td>{{ $value['newfans'] }}</td>
						<td>{{ $value['newcancelfans'] }}</td>
						<td>{{ $value['yesterdayfans'] }}</td>
						<td>{{ $value['monthfans'] }}</td>
						<td>
							<a href="getEditSubShop?bussid={{ $value['id'] }}" class="edit">编辑</a>
							<a href="getSubShopReport?bussid={{ $value['id'] }}" class="report">报表</a>
							<a href="getHistoryFans?bussid={{ $value['id'] }}" class="hisfans">历史涨粉</a>
						</td>
					</tr>
                                        @endforeach
				</table>
				
				{{ $paginator ->appends($termarray)->render() }}
				
			</div>
		</div>
		
		<div class="myalert" style="display: none;">
			<div class="mask"></div>
			<div class="alertbox">
				<a href="#" class="close">&times;</a>
				<div class="alertHead">提示</div>
				<div class="alertMain">
					请确认是否拒绝该任务？
				</div>
				<div class="alertbtn">
					<button class="blue-btn btn-sure">确定</button>
					<button class="goback btn-cancel">取消</button>
				</div>
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
			//弹框
			$('.refuse-btn').click(function(){
				$('.myalert').show();
			})
			$('.btn-sure').click(function(){
				//点击确认
				$('.myalert').hide()
			})
			$('.close,.btn-cancel').click(function(){
				//点击取消
				$('.myalert').hide()
			})
		})
	</script>
</html>
