<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>渠道统计报表查看详情</title>
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
				<div class="header">所属渠道：@if(isset($post['buss'])){{$post['buss']}}@endif</div>
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<input type="hidden" name="bid" id="bid" @if(isset($post['bid']))value="{{$post['bid']}}"@endif/>
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
						
						<label class="datelabel">至 <input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excel" value="0">
					<input type="hidden" name="buss" @if(isset($post['buss']))value="{{$post['buss']}}"@endif>
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail init-table colspan-8">
					<tr>
						<th>渠道名称</th>
						<th>获取公众号</th>
						<th>成功获取公众号</th>
						<th>填充率</th>
						<th>微信认证</th>
						<th>认证率</th>
						<th>成功关注</th>
						<th>关注率</th>
						<th>点击完成</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							@if($v['sumgetwx'] != 0)
								@if($k == 'father')
									<tr class="f_channel off_channel" channelId="{{$v['id']}}_f">
										<td>{{$v['nick_name']}}(汇总)</td>
								@else
									<tr class="f_channel off_channel" channelId="{{$v['id']}}">
										<td>{{$v['nick_name']}}</td>
								@endif
									<td>{{$v['sumgetwx']}}</td>
									<td>{{$v['getwx']}}</td>
									<td>{{$v['tc_per']}}</td>
									<td>{{$v['complet']}}</td>
									<td>{{$v['rz_per']}}</td>
									<td>{{$v['follow']}}</td>
									<td>{{$v['gz_per']}}</td>
									<td>{{$v['end']}}</td>
								</tr>
								@if(isset($v['data']) && !empty($v['data']))
									@foreach($v['data'] as $kk=>$vv)
										@if($vv['sumgetwx'] != 0)
											@if($k == 'father')
												<tr class="sub_channel" fatherId="{{$v['id']}}_f" channelId="{{$v['id']}}">
											@else
												<tr class="sub_channel" fatherId="{{$v['id']}}" channelId="{{$v['id']}}">
											@endif
												<td>{{$vv['date_time']}}</td>
												<td>{{$vv['sumgetwx']}}</td>
												<td>{{$vv['getwx']}}</td>
												<td>{{$vv['tc_per']}}</td>
												<td>{{$vv['complet']}}</td>
												<td>{{$vv['rz_per']}}</td>
												<td>{{$vv['follow']}}</td>
												<td>{{$vv['gz_per']}}</td>
												<td>{{$vv['end']}}</td>
											</tr>
										@endif
									@endforeach
								@endif
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
			$(".excel").click(function(){
				$("input[name=excel]").val(1);
				$("#f-report").submit();
			})
			$(".find").click(function(){
				$("input[name=excel]").val(0);
				$("#f-report").attr('action','bussCount_detail');
				var startDate = new Date($('#datetimeStart').val()).getTime()
				var endDate = new Date($('#datetimeEnd').val()).getTime()
				var delta=parseInt((endDate-startDate)/1000/60/60/24);
				if(delta>29){
					alert('数据太多啦，请导出Excel查看')
				}else{
					$("#f-report").submit();
				}
			})
			$(".reset").click(function(){
				var bid = $("#bid").val();
				var bname = $("input[name=buss]").val();
				window.location.href='bussCount_detail?bid='+bid+'&buss='+bname;
			})
			
			
		})
	</script>
</html>
