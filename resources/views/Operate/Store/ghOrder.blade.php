<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-公众号订单</title>
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
					    <select name="wx_id" class="form-control">
					    	<option value="">全部</option>
							@if(isset($wx_list) && !empty($wx_list))
								@foreach($wx_list as $k=>$v)
									@if(isset($wx_id) && $wx_id == $v['o_wx_id'])
										<option value="{{$v['o_wx_id']}}" selected>{{$v['wx_name']}}</option>
									@else
										<option value="{{$v['o_wx_id']}}">{{$v['wx_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="button" value="重置" class="reset"/>
					<a class="add" href="add">+ 新增订单</a>
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>公众号</th>
						<th>投放区域</th>
						<th>投放品牌</th>
						<th>总涨粉量</th>
						<th>当日涨粉量</th>
						<th>取关量</th>
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['wx_name']}}</td>
								<td>{{$v['area']}}</td>
								<td>{{$v['brand']}}</td>
								<td>{{$v['total_fans_old']+$v['sub_today']}}</td>
								<td>{{$v['sub_today']}}</td>
								<td>{{$v['un_subscribe_old']+$v['unsub_today']}}</td>
								<td>
									<input type="hidden" name="oid" value=""/>
									@if($v['order_status'] == 1)
										<button type="button" class="btn btn-red close_order status" oid = "{{$v['order_id']}}">暂停</button>
									@else
										<button type="button" class="btn btn-blue open_order status" oid = "{{$v['order_id']}}">开启</button>
									@endif
								</td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
				<div class="myalert" style="display: none;">
					<div class="mask"></div>
					<div class="alertbox">
						<a href="#" class="close">&times;</a>
						<div class="alertHead">提示</div>
						<div class="alertMain">
							请确认是否暂停该订单？
						</div>
						<div class="alertbtn">
							<input type="button" class="btn btn-sure" value="确认" />
							<button type="button" class="btn btn-cancel">取消</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>	
	</body>
	<script type="text/javascript">
		$(function(){
			
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
			
			$('.open_order').click(function(){
				$('.alertMain').text('请确认是否开启该订单？')
				$('.myalert').show()
			})

			$('.close_order').click(function(){
				$('.alertMain').text('请确认是否暂停该订单？')
				$('.myalert').show()
			})
			
			$('.btn-sure').click(function(){
				var oid = $("input[name=oid]").val();
				$('.myalert').hide()
				window.location.href='status?oid='+oid;
			})
			
			$('.btn-cancel').click(function(){
				$('.myalert').hide()
			})
			$('.reset').click(function(){
				window.location.href = 'order';
			})
			$(".status").click(function(){
				var oid = $(this).attr('oid');
				$("input[name=oid]").val(oid);
			})
		})
	</script>
</html>
