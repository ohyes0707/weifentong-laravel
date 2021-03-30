<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>代理管理-代理列表-子代理</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<div class="head">所属代理：@if(isset($uname)){{$uname}}@endif</div>
				
				<table class="table-bordered table-responsive detail" style="margin-top: 20px;">
					<tr>
						<th>子代理名称</th>
						<th>报备</th>
						<th>授权</th>
						<th>报备完成</th>
						<th>工单</th>
						<th>订单</th>
						<th>总销售额</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['nick_name']}}</td>
								<td>{{$v['report']}}</td>
								<td>{{$v['auth']}}</td>
								<td>{{$v['report_success']}}</td>
								<td>{{$v['work']}}</td>
								<td>{{$v['order']}}</td>
								<td>{{$v['money']}}</td>
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
			
			$('.menu-title').click(function(){
				var $this=$(this);
				var $menu=$this.parent('.menu-header');
				var $list=$this.siblings('.menu-list');
				if($list.is(':hidden')){
					$menu.addClass('open');
					$list.show();
				}else{
					$menu.removeClass('open');
					$list.hide();
				}
			})
			
		})
	</script>
</html>
