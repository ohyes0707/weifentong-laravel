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
				
				<table class="table-bordered table-responsive checktable init-table">
					<tr>
						<th>商家</th>
						<th>带粉数</th>
						<th>收益</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list['father'] as $k=>$v)
							<tr class="f_channel off_channel" channelId="{{$v['id']}}汇总">
								<td>{{$v['nick_name']}}（汇总）</td>
								<td>{{$v['total']['follow']}}</td>
								<td>{{sprintf('%.2f',$v['total']['num'])}}</td>
							</tr>
							@if(isset($v['count']) && !empty($v['count']))
								@foreach($v['count'] as $kk=>$vv)
									@if($vv['follow'] != 0)
									<tr class="sub_channel" fatherId="{{$v['id']}}汇总">
										<td>{{$vv['date']}}</td>
										<td>{{$vv['follow']}}</td>
										<td>{{sprintf('%.2f',$vv['num'])}}</td>
									</tr>
									@endif
								@endforeach
							@endif
						@endforeach
						@foreach($list['child'] as $k=>$v)
							@if($v['total']['follow'] != 0)
							<tr class="f_channel off_channel" channelId="{{$v['id']}}">
								<td>{{$v['nick_name']}}</td>
								<td>{{$v['total']['follow']}}</td>
								<td>{{sprintf('%.2f',$v['total']['num'])}}</td>
							</tr>
							@endif
							@if(isset($v['count']) && !empty($v['count']))
								@foreach($v['count'] as $kk=>$vv)
									@if($vv['follow'] != 0)
									<tr class="sub_channel" fatherId="{{$v['id']}}">
										<td>{{$vv['date']}}</td>
										<td>{{$vv['follow']}}</td>
										<td>{{sprintf('%.2f',$vv['num'])}}</td>
									</tr>
									@endif
								@endforeach
							@endif
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
			
			
			//表格缩略
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
			$(".reset").click(function(){
				window.location.href = 'fansEarn';
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
