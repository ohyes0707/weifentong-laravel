<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>销售统计</title>
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
					    <label>
					    	选择公众号：					    	
					    </label>
					    <select name="gzh" class="form-control" id="gzh">
					    	<option value="0">请选择</option>
							@if(isset($wx_list) && !empty($wx_list))
								@foreach($wx_list as $v)
									@if(isset($post['gzh']) && $post['gzh'] == $v)
										<option value="{{$v}}" selected>{{$v}}</option>
									@else
										<option value="{{$v}}">{{$v}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" @if(isset($start_date))value="{{$start_date}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" @if(isset($end_date))value="{{$end_date}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excel">
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<input type="button" value="导出excel" class="excel" />
				</form>
				<table class="table-bordered table-responsive detail init-table" id="saleTable">
					<tr>
						<th>公众号</th>
						<th>成功关注</th>
						<th>取关数</th>
						<th>取关率</th>
						<th>平均单价</th>
						<th>销售额</th>
					</tr>
					@if(isset($list) && !empty($list))
						<tr>
							<td>合计</td>
							<td>{{$follow}}</td>
							<td>{{$unfollow}}</td>
							<td>
								@if($follow != 0)
									{{sprintf('%.2f',$unfollow/$follow*100)}}%
								@else
									0.00%
								@endif
							</td>
							<td>{{$avg_price}}</td>
							<td>{{$money}}</td>
						</tr>
						@foreach($list as $k=>$v)
							@if(isset($v['data']) && !empty($v['data']))
								<tr class="f_channel off_channel" channelid="{{$v['order_id']}}">
									<td>{{$v['wx_name']}}</td>
									<td>{{$v['follow']}}</td>
									<td>{{$v['unfollow']}}</td>
									<td>
										@if($v['follow'] != 0)
											{{sprintf('%.2f',$v['unfollow']/$v['follow']*100)}}%
										@else
											0.00%
										@endif
									</td>
									<td>{{sprintf('%.2f',$v['price'])}}</td>
									<td>{{$v['money']}}</td>
								</tr>
								@foreach($v['data'] as $kk=>$vv)
									<tr class="sub_channel" fatherid="{{$v['order_id']}}">
										<td>{{$vv['date_time']}}</td>
										<td>{{$vv['follow']}}</td>
										<td>{{$vv['unfollow']}}</td>
										<td>
											@if($vv['follow'] != 0)
												{{sprintf('%.2f',$vv['unfollow']/$vv['follow']*100)}}%
											@else
												0.00%
											@endif
										</td>
										<td>{{$vv['price']}}</td>
										<td>{{$vv['money']}}</td>
									</tr>
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
			//下拉菜单
			$('#navDropdown').on('show.bs.dropdown',function(){
				$('.top-caret').hide()
				$('.bottom-caret').show()
			})
			
			$('#navDropdown').on('hide.bs.dropdown',function(){
				$('.top-caret').show()
				$('.bottom-caret').hide()
			})
			
			//选择时间
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
//				window.location.href='list';
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
				$("#f-report").submit();
			})
		})
	</script>
	<script type="text/javascript">
		//左边菜单栏切换
		var a=false;
		function menuToggle(){
			a = !a;
			if(a){
				$('.close-folder').hide();
				$('.open-folder').show();
				$('.bottom-arrow').hide();
				$('.top-arrow').show();
				$('.menu-list').show();
			}else{
				$('.close-folder').show();
				$('.open-folder').hide();
				$('.bottom-arrow').show();
				$('.top-arrow').hide();
				$('.menu-list').hide();
			}
		}
	</script>
</html>
