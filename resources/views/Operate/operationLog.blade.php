<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>订单列表-操作日志</title>
		@include('Operate.common.head')
		<style type="text/css">
			.detail tr>th:nth-child(1){
				width: 25%;
			}
			.detail tr>th:nth-child(3){
				width: 18%;
			}
		</style>
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
					<div class="form-group">
					    <label>
					    	操作人：					    	
					    </label>
					    <select name="uid" class="form-control">
					    	<option value="">全部</option>
							@if(isset($user))
								@foreach($user as $k=>$v)
									@if(isset($uid) && $uid == $v['operator_id'])
										<option value="{{$v['operator_id']}}" selected>{{$v['operator']}}</option>
									@else
										<option value="{{$v['operator_id']}}">{{$v['operator']}}</option>
									@endif
								@endforeach
							@endif
					    </select>
					</div>
					<div class="form-group">
						<label class="datelabel">操作时间：<input type="text" @if(isset($startDate))value="{{$startDate}}"@endif name="start_date" class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" @if(isset($endDate))value="{{$endDate}}"@endif name="end_date" class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" value="{{$order_id}}" name="order_id">
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>操作时间</th>
						<th>操作项</th>
						<th>操作人</th>
					</tr>
					@if(isset($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['datetime']}}</td>
								<td>{{$v['action']}}</td>
								<td>{{$v['operator']}}</td>
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
			
			//左边菜单栏缩略
//			$('.menu-title').click(function(){
//				var $this=$(this);
//				var $menu=$this.parent('.menu-header');
//				var $list=$this.siblings('.menu-list');
//				if($list.is(':hidden')){
//					$menu.addClass('open');
//					$list.show();
//				}else{
//					$menu.removeClass('open');
//					$list.hide();
//				}
//			})

			$(".reset").click(function(){
				var order_id = $('input[name=order_id]').val();
				window.location.href = 'log?order_id='+order_id;
			})
		})
	</script>
</html>
