<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>渠道统计报表</title>
		@include('Operate.common.head')
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/statistics.css') }}"/>
		<style>
			.position{
				position: relative;
			}
			#ul_hide{
				position: absolute;
				right: 0;
				z-index: 999;
				background: #fff;
				border: 1px solid #ccc;
				border-radius: 4px;
				width: auto;
				box-sizing: content-box;

			}
			#ul_hide li{
				padding: 0 10px;
				min-width: 100px;
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
					<input type="hidden" name="status" id="status" value=""/>
					<div class="r_form clearfix">
						<div class="f_radio">
							<a href="bussCount?status=1" value="1" @if(isset($status) && $status==1)class="on_radio"@endif>次数</a>
							<a href="bussCount?status=2" value="2" @if(isset($status) && $status==2)class="on_radio"@endif>人数</a>
						</div>
					</div>
					<div class="form-group position">
					    <label>
					    	父渠道名称：					    	
					    </label>
						<input type="text" id="inputv" onkeyup="checkFunction()" name="buss" @if(isset($post['buss']))value="{{$post['buss']}}"@endif class="form-control">
						<ul id="ul_hide">
							@if(isset($buss) && !empty($buss))
								@foreach($buss as $k=>$v)
									<li class="option_obj" style="display: none;">{{$v['nick_name']}}</li>
								@endforeach
							@endif
						</ul>
						<script>
							$(".option_obj").click(function(){
								var wxname = $(this).text();
								$("#inputv").val(wxname);
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
					    {{--<select name="buss" class="form-control">--}}
					    	{{--<option value="0">全部</option>--}}
							{{--@if(isset($buss) && !empty($buss))--}}
								{{--@foreach($buss as $v)--}}
									{{--@if(isset($post['buss']) && $post['buss']==$v['id'])--}}
					    				{{--<option selected value="{{$v['id']}}">{{$v['nick_name']}}</option>--}}
									{{--@else--}}
										{{--<option value="{{$v['id']}}">{{$v['nick_name']}}</option>--}}
									{{--@endif--}}
								{{--@endforeach--}}
							{{--@endif--}}
					    {{--</select>						    --}}
					</div>
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
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							@if($v['sumgetwx'] != 0)
								<tr class="f_channel off_channel" channelId="{{$v['buss_id']}}">
									<td>{{$v['nick_name']}}</td>
									<td>{{$v['sumgetwx']}}</td>
									<td>{{$v['getwx']}}</td>
									<td>
										@if($v['sumgetwx']!=0)
											{{sprintf('%.2f',$v['getwx']/$v['sumgetwx']*100).'%'}}
										@else
											0.00%
										@endif
									</td>
									<td>{{$v['complet']}}</td>
									<td>
										@if($v['getwx']!=0)
											{{sprintf('%.2f',$v['complet']/$v['getwx']*100).'%'}}
										@else
											0.00%
										@endif
									</td>
									<td>{{$v['follow']}}</td>
									<td>
										@if($v['complet']!=0)
											{{sprintf('%.2f',$v['follow']/$v['complet']*100).'%'}}
										@else
											0.00%
										@endif
									</td>
									<td>{{$v['end']}}</td>
									<td><a href="bussCount_detail?bid={{$v['buss_id']}}&startDate={{$startDate}}&endDate={{$endDate}}&buss={{$v['nick_name']}}">查看详情</a></td>
								</tr>
								@if(isset($v['child']) && $v['child']!='')
									@foreach($v['child'] as $kk=>$vv)
										@if($vv['sumgetwx'] != 0)
										<tr class="sub_channel" fatherId="{{$v['buss_id']}}" channelId="{{$vv['buss_id']}}">
											<td>{{$vv['nick_name']}}</td>
											<td>{{$vv['sumgetwx']}}</td>
											<td>{{$vv['getwx']}}</td>
											<td>
												@if($vv['sumgetwx']!=0)
													{{sprintf('%.2f',$vv['getwx']/$vv['sumgetwx']*100).'%'}}
												@else
													0.00%
												@endif
											</td>
											<td>{{$vv['complet']}}</td>
											<td>
												@if($vv['getwx']!=0)
													{{sprintf('%.2f',$vv['complet']/$vv['getwx']*100).'%'}}
												@else
													0.00%
												@endif
											</td>
											<td>{{$vv['follow']}}</td>
											<td>
												@if($vv['complet']!=0)
													{{sprintf('%.2f',$vv['follow']/$vv['complet']*100).'%'}}
												@else
													0.00%
												@endif
											</td>
											<td>{{$vv['end']}}</td>
											<td><a href="bussCount_detail?bid={{$vv['buss_id']}}&startDate={{$startDate}}&endDate={{$endDate}}&buss={{$vv['nick_name']}}&child=1">查看详情</a></td>
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
				var status = $(".on_radio").attr('value');
				$("#status").val(status);
				$("#f-report").submit();
			})
			$(".find").click(function(){
				$("input[name=excel]").val(0);
				var status = $(".on_radio").attr('value');
				$("#status").val(status);
//				$("#f-report").attr('action','bussCount');
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
				var status = $(".on_radio").attr('value');
				window.location.href='bussCount?status='+status;
			})
			
			
		})
	</script>
</html>
