<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>订单查询</title>
		@include('Operate.common.head')
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
						<label class="datelabel">选择时间：<input type="text" name="date" @if(isset($date))value="{{$date}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
					</div>
					<input type="hidden" value="" class="excels" name="excel"/>
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<p>当日订单配置总涨粉量：@if(isset($total)){{$total}}@endif</p>
				
				<table class="table-bordered table-responsive table-striped detail">
					<tr>
						<th>订单名称</th>
						<th>地区属性</th>
						<th>性别</th>
						<th>日涨粉量</th>
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['wx_name']}}</td>
								<td>{{$v['hot_area']}}</td>
								<td>{{$v['sex']}}</td>
								<td>{{$v['day_fans']}}</td>
								<td><a href="detail?work_id={{$v['work_id']}}&order_id={{$v['order_id']}}">查看详情</a></td>
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
		    })

			
			//渠道统计报表子渠道缩略
			$('table').delegate('.f_channel','click',function(){
				var $this=$(this);
				var code=$this.attr('channelId');
				var $sub=$this.parents('table').find('.sub_channel[fatherId="'+code+'"]');
				if($sub.length>0){
					if($sub.is(':hidden')){
						$sub.show();
						$this.addClass('on_channel').removeClass('off_channel');
					}else{
						$sub.hide();
						$this.addClass('off_channel').removeClass('on_channel');
					}
				}
			})
			$("#datetimeStart").datetimepicker("setStartDate",new Date());
			$(".reset").click(function(){
				window.location.href='search';
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
