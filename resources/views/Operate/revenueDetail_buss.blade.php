<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>营收报表</title>
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
				<div class="header">所属渠道：@if(isset($post['bname'])){{$post['bname']}}@endif</div>
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<input type="hidden" name="bid" @if(isset($bid) && !empty($bid))value="{{$bid}}"@endif>
					<div class="form-group position">
					    <label>
					    	公众号：				    	
					    </label>
						<input type="text" id="inputv" onkeyup="checkFunction()" name="wx_id" @if(isset($wx_id))value="{{$wx_id}}"@endif class="form-control">
						<ul id="ul_hide">
							@if(isset($wx_name) && !empty($wx_name))
								@foreach($wx_name as $k=>$v)
									<li class="option_obj" style="display: none;">{{$v['wx_name']}}</li>
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
					    {{--<select name="wx_id" class="form-control">--}}
					    	{{--<option value="0">全部</option>--}}
							{{--@if(isset($wx_name) && !empty($wx_name))--}}
								{{--@foreach($wx_name as $k=>$v)--}}
									{{--@if(isset($wx_id) && $wx_id==$v['o_wx_id'])--}}
										{{--<option selected value="{{$v['o_wx_id']}}">{{$v['wx_name']}}</option>--}}
									{{--@else--}}
										{{--<option value="{{$v['o_wx_id']}}">{{$v['wx_name']}}</option>--}}
									{{--@endif--}}
								{{--@endforeach--}}
							{{--@endif--}}
					    {{--</select>--}}
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" @if(isset($startDate))value="{{$startDate}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="bname" @if(isset($post['bname']))value="{{$post['bname']}}"@endif>
					<input type="hidden" name="excel" value="0">
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<!--全部公众号-->
				<table @if($wx_id)style="display: none;"@endif class="table-bordered table-responsive table-striped detail init-table colspan-5">
					<tr>
						<th>公众号</th>
						<th>成功关注</th>
						<th>实际关注</th>
						<th>流水</th>
						{{--<th>扣量利润</th>--}}
					</tr>
					@if(isset($data) && !empty($data))
						@foreach($data as $k=>$v)
							@if(isset($v['count']))
								<tr class="f_channel off_channel" channelId="{{$v['o_wx_id']}}">
									<td>{{$v['wx_name']}}</td>
									<td>{{$v['count']['follow']}}</td>
									<td>{{$v['count']['real_follow']}}</td>
									<td>{{$v['count']['float']}}</td>
									{{--<td>{{$v['count']['rest']}}</td>--}}
								</tr>
							@endif
							@if(isset($v['list']) && !empty($v['list']))
								@foreach($v['list'] as $kk=>$vv)
									@if($vv['follow'] != 0)
									<tr class="sub_channel" fatherId="{{$v['o_wx_id']}}">
										<td>{{$vv['date_time']}}</td>
										<td>{{$vv['follow']}}</td>
										<td>{{$vv['real_follow']}}</td>
										<td>{{$vv['float']}}</td>
										{{--<td>{{$vv['rest']}}</td>--}}
									</tr>
									@endif
								@endforeach
							@endif
						@endforeach
					@endif
				</table>
				
				
				<!--单个公众号-->
				<table @if(!$wx_id)style="display: none;"@endif class="table-bordered table-responsive table-striped detail colspan-6">
					<tr>
						<th>公众号</th>
						<th>日期</th>
						<th>成功关注</th>
						<th>实际关注</th>
						<th>流水</th>
						{{--<th>扣量利润</th>--}}
					</tr>
					@if(isset($data) && !empty($data))
						@foreach($data as $k=>$v)
							@if(isset($v['count']) && $v['wx_name']==$wx_id)
							<tr>
								<td rowspan="999">{{$v['wx_name']}}</td>
								<td>汇总</td>
								<td>{{$v['count']['follow']}}</td>
								<td>{{$v['count']['real_follow']}}</td>
								<td>{{$v['count']['float']}}</td>
								{{--<td>{{$v['count']['rest']}}</td>--}}
							</tr>
							@endif
							@if(isset($v['list']) && !empty($v['list']) && $v['wx_name']==$wx_id)
								@foreach($v['list'] as $kk=>$vv)
									<tr>
										<td>{{$vv['date_time']}}</td>
										<td>{{$vv['follow']}}</td>
										<td>{{$vv['real_follow']}}</td>
										<td>{{$vv['float']}}</td>
										{{--<td>{{$vv['rest']}}</td>--}}
									</tr>
								@endforeach
							@endif
						@endforeach
					@endif
				</table>


				@if(isset($paginator) && !$wx_id)
					{{$paginator->appends($post)->render()}}
				@endif
			</div>
		</div>
		
		<div class="myalert" style="display: none;">
			<div class="mask"></div>
			<div class="alertbox">
				<a href="#" class="close">&times;</a>
				<div class="alertHead">提示</div>
				<div class="alertMain">
					
				</div>
				<div class="alertbtn">
					<button class="btn btn-sure">确定</button>
					<button class="btn btn-cancel">取消</button>
				</div>
			</div>
		</div>
		<div class="cause" style="display: none;">
			<div class="mask"></div>
			<div class="causeMain">
				<p>驳回原因</p>
				<textarea name="reason"></textarea>
				<span class="tip causeTip">原因必填</span>
				<div class="causebtn">
					<input type="button" value="确认" class="sure"/>
					<input type="button" value="取消" class="cancel" />	
				</div>
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
//		        startDate:new Date()
		    }).on("click",function(){
		        $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
		    });
		    $("#datetimeEnd").datetimepicker({
		        format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
//		        startDate:new Date()
		    }).on("click",function(){
		        $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
		    });
		    
		    
		    //左边列表栏缩略
			

			

			/*-----------------js修改部分------------------*/
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
			/*-----------------js修改部分------------------*/
			$(".reset").click(function(){
				var bid = $("input[name=bid]").val();
				var bname = $("input[name=bname]").val();
				window.location.href='revenueDetail_buss?bid='+bid+'&bname='+bname;
			})
			$(".find").click(function(){
				$("input[name=excel]").val(0);
				$("#f-report").attr('action','revenueDetail_buss');
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
		    
		})
	</script>
</html>
