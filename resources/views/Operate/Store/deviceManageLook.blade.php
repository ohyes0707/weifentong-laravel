<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-设备列表</title>
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
					    	设备MAC：					    	
					    </label>
					    <select name="mac" class="form-control">
					    	<option value="">全部</option>
							@if(isset($mac_list) && !empty($mac_list))
								@foreach($mac_list as $k=>$v)
									@if(isset($mac) && $mac == $v['mac_id'])
										<option value="{{$v['mac_id']}}" selected>{{$v['mac']}}</option>
									@else
										<option value="{{$v['mac_id']}}">{{$v['mac']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	选择区域：					    	
					    </label>
					    <select name="area" class="form-control">
					    	<option value="">全部</option>
							@if(isset($area_list) && !empty($area_list))
								@foreach($area_list as $k=>$v)
									@if(isset($area) && $area == $v['bid'])
										<option value="{{$v['bid']}}" selected>{{$v['nick_name']}}</option>
									@else
										<option value="{{$v['bid']}}">{{$v['nick_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	选择品牌：					    	
					    </label>
					    <select name="brand" class="form-control">
					    	<option value="">全部</option>
							@if(isset($brand_list) && !empty($brand_list))
								@foreach($brand_list as $k=>$v)
									@if(isset($brand) && $brand == $v['brand_id'])
										<option value="{{$v['brand_id']}}" selected>{{$v['brand_name']}}</option>
									@else
										<option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	选择门店：					    	
					    </label>
					    <select name="store" class="form-control">
					    	<option value="">全部</option>
							@if(isset($store_list) && !empty($store_list))
								@foreach($store_list as $k=>$v)
									@if(isset($store) && $store == $v['store_id'])
										<option value="{{$v['store_id']}}" selected>{{$v['store']}}</option>
									@else
										<option value="{{$v['store_id']}}">{{$v['store']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>设备MAC</th>
						<th>品牌</th>
						<th>门店</th>
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['dev_mac']}}</td>
								<td>{{$v['brand_id']}}</td>
								<td>{{$v['desc']}}</td>
								<td>
									<button type="button" class="btn btn-red btn_delete" mac_id="{{$v['id']}}">删除</button>
								</td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
				<form method="post" action="macDel" class="macDel">
					{{csrf_field()}}
					<input type="hidden" name="mac_id">
				</form>
				<div class="myalert" style="display: none;">
					<div class="mask"></div>
					<div class="alertbox">
						<a href="#" class="close">&times;</a>
						<div class="alertHead">提示</div>
						<div class="alertMain">
							请确认是否删除该设备？
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
			$('.btn_delete').click(function(){
			    var mac_id = $(this).attr('mac_id');
			    $("input[name=mac_id]").val(mac_id);
				$('.myalert').show()
			})
			$('.btn-sure').click(function(){
				$(".macDel").submit();
				$('.myalert').hide()
			})
			$('.btn-cancel').click(function(){
				$('.myalert').hide()
			})

			$(".reset").click(function(){
			    window.location.href = 'macList';
			})
		})
	</script>
</html>
