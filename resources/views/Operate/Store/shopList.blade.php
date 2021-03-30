<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-门店列表</title>
		@include('Operate.common.head')
		<style type="text/css">
			.addalert .title{
				padding: 18px 0;
				font-size: 24px;
			}
			.add_input{
				width: 300px;
			    height: 34px;
			    border: 1px solid #ccc;
			    border-radius: 4px;
			    padding: 0 10px;
			    margin-top: 20px;
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
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<a href="shopAdd" class="add">+ 添加门店</a>
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>门店</th>
						<th>品牌</th>
						<th>区域</th>
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['desc']}}</td>
								<td>{{$v['brand_name']}}</td>
								<td>{{$v['area_name']}}</td>
								<td>
									<button type="button" class="btn btn-blue device_add" shop_id="{{$v['store_id']}}">添加设备</button>
								</td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
				<div class="addalert" style="display: none;">
					<div class="mask"></div>
					<div class="alertbox">
						<form action="macAdd" method="post">
							{{csrf_field()}}
							<input type="hidden" name="shop_id" />
							<div class="title">添加设备</div>
							<div>
								<input type="text" name="mac" class="add_input"/>
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认">
								<button type="button" class="btn btn-cancel">取消</button>
							</div>
						</form>
						
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
			
			$('.device_add').click(function(){
				$('.addalert').show()
			})
			$('.btn-cancel').click(function(){
				$('.addalert').hide()
			})
			$(".reset").click(function(){
				window.location.href = 'shop';
			})
			$(".device_add").click(function(){
				var shop_id = $(this).attr('shop_id');
				$("input[name=shop_id]").val(shop_id);
			})
		})
	</script>
</html>
