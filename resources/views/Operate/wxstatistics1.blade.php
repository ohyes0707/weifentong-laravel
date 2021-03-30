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
							<a href="getPlatformReport">平台</a>
							<a href="javascript: void(0)" class="on_radio">公众号</a>
						</div>
					</div>
					
					<div class="form-group  position">
					    <label>
					    	公众号：					    	
					    </label>
					    <!-- <select name="wx_id" class="form-control">
					    	<option value="0">全部</option>
					    	@if(isset($wx_name) && !empty($wx_name))
								@foreach($wx_name as $k=>$v)
									@if(isset($wx_id) && $wx_id==$v['xid'])
										<option selected value="{{$v['xid']}}">{{$v['wx_name']}}</option>
									@else
										<option value="{{$v['xid']}}">{{$v['wx_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select> -->	

						<input type="text" id="inputgzh" hidden name="wx_id" class="form-control" style="display: none" @if(isset($termarray['wx_id']))value="{{$termarray['wx_id']}}" @endif>
                        <input type="text" id="inputv" onkeyup="checkFunction()" name="wxName"  class="form-control" autocomplete="off" value="{{$termarray['wxname']}}">
                            <ul id="ul_hide">
                                @if(count($wx_name)>0)
                                    @foreach ($wx_name as $wx)
                                    <li class="option_obj" style="display: none;" tit="{{ $wx['xid'] }}">{{ $wx['wx_name'] }}</li>
                                    @endforeach
                                @endif
                            </ul>
					    <script>
							$(".option_obj").click(function(){
								var wxname = $(this).text();
                                var wxid = $(this).attr('tit');
								$("#inputv").val(wxname);
                                $("#inputgzh").val(wxid);
								$(".option_obj").hide();
							})

							function checkFunction(){
								var inputv,filter,ul,li,a,i;
								inputv = document.getElementById('inputv');
								filter = inputv.value.toUpperCase();
								ul =  document.getElementById('ul_hide');
								li = ul.getElementsByTagName('li');
								if(filter==''){
									$(".option_obj").hide();
									return false;
								}
								for(i=0;i<li.length;i++){
									var tt = li[i].innerHTML.toUpperCase().indexOf(filter);
									if(tt>=0){
										li[i].style.display = "";
									}else{
										li[i].style.display = "none";
									}
								}
							}
						</script>					    
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
				
				<!--全部公众号-->
				<table @if($wx_id)style="display: none;"@endif class="table-bordered table-responsive table-striped detail init-table colspan-6">
					<tr>
						<th>公众号</th>
						<th>成功关注</th>
						<th>流水</th>
						<th>微信关注</th>
						<th>微信关注流水</th>
						<th>关注增幅</th>
						<th>流水增幅</th>
						
					</tr>
					@if(isset($paginator) && !empty($paginator))
						@foreach ($paginator as $key => $datalist)
							@if(isset($datalist['order']))
							<tr class="f_channel off_channel" channelId="{{$datalist['order']['xid']}}">
								<td>{{$datalist['order']['wx_name']}}</td>
								<td>{{$datalist['order']['follow_repeat_sum']}}</td>
								<td>{{round($datalist['order']['flowing_water_sum'],2)}}</td>
								<td>{{$datalist['order']['wx_sum']}}</td>
								@if (isset($datalist['order']['color']))
									<td style="color: {{$datalist['order']['color']}}">{{round($datalist['order']['wx_water_sum'],2)}}</td>
								@else
									<td>{{round($datalist['order']['wx_water_sum'],2)}}</td>
								@endif

								@if (($datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']) > 0)
							        <td class="red">{{$datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']}}</td>
							    @elseif (($datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']) < 0)
							    	<td class="green">{{$datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']}}</td>
							    @elseif (($datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']) == 0)
							    	<td>{{$datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']}}</td>
							    @endif
								
								@if (($datalist['order']['flowing_fans_water']) > 0)
							        <td class="red">{{round($datalist['order']['flowing_fans_water'],2)}}</td>
							    @elseif (($datalist['order']['flowing_fans_water']) < 0)
							    	<td class="green">{{round($datalist['order']['flowing_fans_water'],2)}}</td>
							    @elseif (($datalist['order']['flowing_fans_water']) == 0)
							    	<td>{{round($datalist['order']['flowing_fans_water'],2)}}</td>
							    @endif

							    
							</tr>
							@endif
							@if(isset($datalist['list']) && !empty($datalist['list']))
								@foreach($datalist['list'] as $kk=>$vv)
									<tr class="sub_channel" fatherId="{{$vv['xid']}}">
										<td>{{$vv['date_time']}}</td>
										<td>{{$vv['follow_repeat']}}</td>
										<td>{{round($vv['flowing_water'],2)}}</td>
										<td>{{$vv['new_fans']}}</td>
										@if (isset($datalist['order']['color']))
											<td style="color: {{$datalist['order']['color']}}">{{round($vv['new_fans_water'],2)}}</td>
										@else
											<td>{{round($vv['new_fans_water'],2)}}</td>
										@endif

										@if (($vv['follow_repeat']-$vv['new_fans']) > 0)
									        <td class="red">{{$vv['follow_repeat']-$vv['new_fans']}}</td>
									    @elseif (($vv['follow_repeat']-$vv['new_fans']) < 0)
									    	<td class="green">{{$vv['follow_repeat']-$vv['new_fans']}}</td>
									    @elseif (($vv['follow_repeat']-$vv['new_fans']) == 0)
									    	<td>{{$vv['follow_repeat']-$vv['new_fans']}}</td>
									    @endif

										@if (($vv['flowing_fans_water']) > 0)
									        <td class="red">{{round($vv['flowing_fans_water'],2)}}</td>
									    @elseif (($vv['flowing_fans_water']) < 0)
									    	<td class="green">{{round($vv['flowing_fans_water'],2)}}</td>
									    @elseif (($vv['flowing_fans_water']) == 0)
									    	<td>{{round($vv['flowing_fans_water'],2)}}</td>
									    @endif

									    
									</tr>
								@endforeach
							@endif
						@endforeach
					@endif
					
				</table>
				
				<!--单个公众号-->
				<table @if(!$wx_id)style="display: none;"@endif class="table-bordered table-responsive table-striped detail colspan-7">
					<tr>
						<th>公众号</th>
						<th>日期</th>
						<th>成功关注</th>
						<th>流水</th>
						<th>微信关注</th>
						<th>微信关注流水</th>
						<th>关注增幅</th>
						<th>流水增幅</th>
						
					</tr>
					@if(isset($paginator) && !empty($paginator))
						@foreach($paginator as $key => $datalist)
							@if(isset($datalist['order']))
								<tr>
									<td rowspan="999">{{$datalist['order']['wx_name']}}</td>
									<td>汇总</td>
									<td>{{$datalist['order']['follow_repeat_sum']}}</td>
									<td>{{round($datalist['order']['flowing_water_sum'],2)}}</td>
									<td>{{$datalist['order']['wx_sum']}}</td>
									@if (isset($datalist['order']['color']))
										<td style="color: {{$datalist['order']['color']}}">{{round($datalist['order']['wx_water_sum'],2)}}</td>
									@else
										<td>{{round($datalist['order']['wx_water_sum'],2)}}</td>
									@endif

									@if (($datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']) > 0)
								        <td class="green">{{$datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']}}</td>
								    @elseif (($datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']) < 0)
								    	<td class="red">{{$datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']}}</td>
								    @elseif (($datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']) == 0)
								    	<td>{{$datalist['order']['follow_repeat_sum']-$datalist['order']['wx_sum']}}</td>
								    @endif
									
									@if ((round($datalist['order']['flowing_water_sum']-$datalist['order']['wx_water_sum'],2)) > 0)
								        <td class="green">{{round($datalist['order']['flowing_water_sum']-$datalist['order']['wx_water_sum'],2)}}</td>
								    @elseif (($datalist['order']['flowing_water_sum']-$datalist['order']['wx_water_sum']) < 0)
								    	<td class="red">{{round($datalist['order']['flowing_water_sum']-$datalist['order']['wx_water_sum'],2)}}</td>
								    @elseif (($datalist['order']['flowing_water_sum']-$datalist['order']['wx_water_sum']) == 0)
								    	<td>{{round($datalist['order']['flowing_water_sum']-$datalist['order']['wx_water_sum'],2)}}</td>
								    @endif

								    
								</tr>
							@endif
							@if(isset($datalist['list']) && !empty($datalist['list']))
								@foreach($datalist['list'] as $kk=>$vv)
									<tr>
										<td>{{$vv['date_time']}}</td>
										<td>{{$vv['follow_repeat']}}</td>
										<td>{{round($vv['flowing_water'],2)}}</td>
										<td>{{$vv['new_fans']}}</td>
										@if (isset($datalist['order']['color']))
											<td style="color: {{$datalist['order']['color']}}">{{round($vv['new_fans_water'],2)}}</td>
										@else
											<td>{{round($vv['new_fans_water'],2)}}</td>
										@endif

										@if (($vv['follow_repeat']-$vv['new_fans']) > 0)
									        <td class="green">{{$vv['follow_repeat']-$vv['new_fans']}}</td>
									    @elseif (($vv['follow_repeat']-$vv['new_fans']) < 0)
									    	<td class="red">{{$vv['follow_repeat']-$vv['new_fans']}}</td>
									    @elseif (($vv['follow_repeat']-$vv['new_fans']) == 0)
									    	<td>{{$vv['follow_repeat']-$vv['new_fans']}}</td>
									    @endif

										@if (($vv['flowing_water']-$vv['new_fans_water']) > 0)
									        <td class="green">{{round($vv['flowing_water']-$vv['new_fans_water'],2)}}</td>
									    @elseif (($vv['flowing_water']-$vv['new_fans_water']) < 0)
									    	<td class="red">{{round($vv['flowing_water']-$vv['new_fans_water'],2)}}</td>
									    @elseif (($vv['flowing_water']-$vv['new_fans_water']) == 0)
									    	<td>{{round($vv['flowing_water']-$vv['new_fans_water'],2)}}</td>
									    @endif


									</tr>
								@endforeach
							@endif
						@endforeach
					@endif
				</table>
				
				<p>备注：“微信关注流水”列，数字为蓝色则表示“多个订单取最低单价进行计算”。</p>
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
				window.location.href='getPublicSignalReport';
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
				$("#f-report").attr('action','getPublicSignalReport');
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
