<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>微信关注报表</title>
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
							<a href="javascript: void(0)" class="on_radio">平台</a>
							<a href="getPublicSignalReport">公众号</a>
						</div>
					</div>
					
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startdate" class="form-control date" @if(isset($startdate))value="{{$startdate}}"@endif id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="enddate" class="form-control date" @if(isset($enddate))value="{{$enddate}}"@endif id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excel" value="0">
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail colspan-6">
					<tr>
						<th>日期</th>
						<th>成功关注</th>
						<th>流水</th>
						<th>微信关注</th>
						<th>微信关注流水</th>
						<th>关注增幅</th>
						<th>流水增幅</th>
						
					</tr>
					@foreach ($paginator as $key => $datalist)
						<tr>
							<td>{{$datalist['date_time']}}</td>
							<td>{{$datalist['follow_repeat']}}</td>
							<td>{{round($datalist['flowing_water'],2)}}</td>
							<td>{{$datalist['new_fans']}}</td>

                            @if (isset($datalist['color']))
                                <td style="color: {{$datalist['color']}}">{{round($datalist['new_fans_water'],2)}}</td>
                            @else
                                <td>{{round($datalist['new_fans_water'],2)}}</td>
                            @endif
                            @if (($datalist['follow_repeat']-$datalist['new_fans']) > 0)
						        <td class="red">{{$datalist['follow_repeat']-$datalist['new_fans']}}</td>
						    @elseif (($datalist['follow_repeat']-$datalist['new_fans']) < 0)
						    	<td class="green">{{$datalist['follow_repeat']-$datalist['new_fans']}}</td>
						    @elseif (($datalist['follow_repeat']-$datalist['new_fans']) == 0)
						    	<td>{{$datalist['follow_repeat']-$datalist['new_fans']}}</td>
						    @endif

							@if (($datalist['flowing_fans_water']) > 0)
						        <td class="red">{{round($datalist['flowing_fans_water'],2)}}</td>
						    @elseif (($datalist['flowing_fans_water']) < 0)
						    	<td class="green">{{round($datalist['flowing_fans_water'],2)}}</td>
						    @elseif (($datalist['flowing_fans_water']) == 0)
						    	<td>{{round($datalist['flowing_fans_water'],2)}}</td>
						    @endif

						    
							
						</tr>
					@endforeach
				</table>
				{{ $paginator->appends($termarray)->render() }}
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
			//日期选择
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
				window.location.href='getPlatformReport';
			})
			
			//左边列表栏缩略
			/*-----------------js修改部分------------------*/
			
			/*-----------------js修改部分------------------*/
			
			
			
			//渠道统计报表子渠道缩略
			$('table').delegate('.f_channel','click',function(){
				var $this=$(this);
				var code=$this.attr('channelId');
				var $sub=$('.sub_channel[fatherId="'+code+'"]')
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

			$(".find").click(function(){
				$("input[name=excel]").val(0);
				$("#f-report").attr('action','getPlatformReport');
				var startDate = new Date($('#datetimeStart').val()).getTime()
				var endDate = new Date($('#datetimeEnd').val()).getTime()
				var delta=parseInt((endDate-startDate)/1000/60/60/24);
				$("#f-report").submit();
				
			})
			$(".excel").click(function(){
				$("input[name=excel]").val(1);
				var excel = $("input[name=excel]").val();
				$("#f-report").submit();
			})
			
			
		})
	</script>
</html>
