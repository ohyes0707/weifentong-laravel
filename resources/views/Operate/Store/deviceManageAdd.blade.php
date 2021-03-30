<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-门店列表-添加门店</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<div class="header">添加门店</div>
				
				<form action="" method="post" class="form">
					{{csrf_field()}}
					<div class="form-list">
						<label>设备MAC：</label><input type="input" name="mac" class="text-input"/>
					</div>
					
					<div class="form-list">
						<label>所在区域：</label>
						<select name="area" class="text-input">
							<option value="0">请选择</option>
							@if(isset($area) && !empty($area))
								@foreach($area as $k=>$v)
									<option value="{{$v['id']}}">{{$v['nick_name']}}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-list">
						<label>所在品牌：</label>
						<select name="brand" class="text-input">
							<option value="0">请选择</option>
							@if(isset($brand) && !empty($brand))
								@foreach($brand as $k=>$v)
									<option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-list">
						<label>所在门店：</label><input type="input" name="shop" class="text-input"/>
					</div>
					
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此设备？
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认"/>
								<button type="button" class="btn btn-cancel">取消</button>
							</div>
						</div>
					</div>
				</form>
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
			
			$('.submit').click(function(){
				$('.myalert').show()
			})
			
			$('.btn-cancel').click(function(){
				$('.myalert').hide()
			})
			
		})
	</script>
</html>
