<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>订单列表</title>
		@include('Operate.common.head')
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
			.detail tr>th:nth-child(1){
				width: 18%;
			}
			.detail tr>th:nth-child(2){
				width: 18%;
			}
			#fanstimeEnd,#fanstimeStart{
				padding-right: 25px;
				background: url(/operate/img/calendars.png) no-repeat right 1px center;
				background-size: auto 28px;
				font-size: 16px;
			}
			.select_time{
				font-size: 20px;
				padding: 20px 0;
			}
			.export{
				width: 74px;
				height: 34px;
				border-radius: 4px;
				border: none;
				color: #fff;
				background: #3EA9F5;
				margin-top: 40px;
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
					{{ csrf_field() }}
					<div class="form-group position">
					    <label>
					    	选择公众号：					    	
					    </label>
						<input type="text" id="inputv" onkeyup="checkFunction()" name="wxName" @if(isset($post['wxName']))value="{{$post['wxName']}}"@endif class="form-control">
						<ul id="ul_hide">
							@if(isset($wx_list) && !empty($wx_list))
								@foreach($wx_list as $k=>$v)
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
					</div>
					<div class="form-group">
						@if(isset($post['startDate']))
							<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{$post['startDate']}}" readonly /></label>
						@else
							<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="" readonly /></label>
						@endif
						@if(isset($post['endDate']))
							<label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{$post['endDate']}}" readonly /></label>
						@else
							<label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="" readonly /></label>
						@endif
					</div>
					<div class="form-group">
					    <label>
					    	订单状态：
					    </label>
					    <select name="state" class="form-control">
					    	<option value="">请选择</option>
							@if(isset($post['state']) && $post['state'] == 2)
					    		<option selected value="2">已暂停</option>
							@else
								<option value="2">已暂停</option>
							@endif
							@if(isset($post['state']) && $post['state'] == 1)
								<option selected value="1">涨粉中</option>
							@else
								<option value="1">涨粉中</option>
							@endif
							@if(isset($post['state']) && $post['state'] == 3)
								<option selected value="3">已关闭</option>
							@else
								<option value="3">已关闭</option>
							@endif
							@if(isset($post['state']) && $post['state'] == 4)
								<option selected value="4">已完成</option>
							@else
								<option value="4">已完成</option>
							@endif
                                                        @if(isset($post['state']) && $post['state'] == 5)
								<option selected value="5">未设置</option>
							@else
								<option value="5">未设置</option>
							@endif
					    </select>
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="find reset"/>

				</form>
				<table class="table table-bordered table-responsive table-striped detail" id="reportTable">
					<tr>
						<th>公众号</th>
						<th>下单时间</th>
						<th>总涨粉量</th>
						<th>单价</th>
						<th>已涨粉</th>
						<th>当日涨粉量</th>
						<th>取关率</th>
						<th>订单状态</th>
						<th>操作</th>
					</tr>
					@if(isset($arr) && !empty($arr))
					@foreach($arr as $v)
					<tr>
						<td>{{$v['wx_name']}}</td>
						<td>{{$v['create_time']}}</td>
						<td>{{$v['o_total_fans']}}</td>
						<td>{{$v['o_per_price']}}</td>
						<td>{{$v['total_fans']}}</td>
						<td>{{$v['day_fans']}}</td>
						<td>{{$v['un_per']}}</td>
						@if($v['order_status'] == 6)
							<td class="colour_4">涨粉中</td>
						@elseif($v['order_status'] == 7)
							<td class="colour_1">已暂停</td>
						@elseif($v['order_status'] == 9)
							<td class="colour_3">已关闭</td>
						@elseif($v['order_status'] == 8)
							<td class="colour_3">已完成</td>
						@elseif($v['order_status'] == 5)
							<td class="colour_2">未设置</td>
						@endif
						<td>
							<button class="btn btn-blue edit" order_id="{{$v['order_id']}}" work_id="{{$v['work_id']}}">编辑</button>
							<button class="btn btn-blue fans_detail" order_id="{{$v['order_id']}}">粉丝详情</button>
						</td>
					</tr>
					@endforeach
					@endif
				</table>
				@if(isset($paginator))
				{{ $paginator->appends($post)->render() }}
				@endif
				<div class="myalert" style="display: none;">
					<div class="mask"></div>
					<div class="alertbox">
						<form action="fans" method="post" id="fans_form">
							{{csrf_field()}}
							<input type="hidden" name="order_id" value="">
							<p class="select_time">选择时间</p>
							<div class="form-group">
								<label class="datelabel"><input type="text" name="startDate" class="form-control date" id="fanstimeStart" readonly /></label>
								至
								<label class="datelabel"><input type="text" name="endDate" class="form-control date" id="fanstimeEnd" readonly /></label>

							</div>

							<input type="submit" value="导出" class="export"/>
						</form>
					</div>
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
		})
		$(".edit").click(function(){
			var work_id = $(this).attr('work_id');
			var order_id = $(this).attr('order_id');
			window.location.href = "{{ URL::asset('index.php/operate/order/detail') }}?work_id="+work_id+"&order_id="+order_id;
		})
		$(".pagination li").click(function(){
//			$(".pagination li").removeClass('active');
//			$(this).addClass('active');
//			alert(1)
		})
		$(".reset").click(function(){
			window.location.href = 'list';
		})
		/*-----------------------------------2017-10-18-------------------------------------*/
		$("#fanstimeStart").datetimepicker({
			format: 'yyyy-mm-dd',
			minView:'month',
			language: 'zh-CN',
			autoclose:true,
//		        startDate:new Date()
		}).on("click",function(){
			$("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
		});
		$("#fanstimeEnd").datetimepicker({
			format: 'yyyy-mm-dd',
			minView:'month',
			language: 'zh-CN',
			autoclose:true,
//		        startDate:new Date()
		}).on("click",function(){
			$("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
		});

		$('.fans_detail').click(function(){
			var order_id = $(this).attr('order_id');
			$("input[name=order_id]").val(order_id);
			$('.myalert').show()
		})
		$(".export").click(function(){
			$('.myalert').hide()
		})
	</script>
</html>
