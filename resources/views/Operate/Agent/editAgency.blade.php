<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>代理管理-代理列表-编辑</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<div class="header">编辑</div>
				
				<form action="" method="post" class="form">
					{{csrf_field()}}
					<input type="hidden" name="uid" @if(isset($list['id']))value="{{$list['id']}}"@endif/>
					<div class="form-list">
						<label>账号：</label><input type="input" name="mobile"  @if(isset($list['username']))value="{{$list['username']}}"@endif class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><label class="input-label"><input type="checkbox" name="password"/>重置为初始密码123456</label>
					</div>
					<div class="form-list">
						<label>昵称：</label><input type="input" name="name" @if(isset($list['nick_name']))value="{{$list['nick_name']}}"@endif class="text-input"/>
					</div>
					<div class="form-list">
						<label>保底价：</label><input type="input" name="minPrice" @if(isset($list['ti_money']))value="{{$list['ti_money']}}"@endif class="text-input"/>
					</div>
					<div class="form-list">
						<label>OEM：</label>
						<label class="label-radio l_radio"><input type="radio" name="oem" value="1" @if(isset($list['oem_ok']) && $list['oem_ok'] == 1) checked = 'checked'@endif/>支持</label>
						<label class="label-radio"><input type="radio" name="oem" value="0" @if(isset($list['oem_ok']) && $list['oem_ok'] == 0) checked = 'checked'@endif/>不支持</label>
					</div>
					
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否保存此修改？
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
			$('.menu-title').click(function(){
				var $this=$(this);
				var $menu=$this.parent('.menu-header');
				var $list=$this.siblings('.menu-list');
				if($list.is(':hidden')){
					$menu.addClass('open');
					$list.show();
				}else{
					$menu.removeClass('open');
					$list.hide();
				}
			})
			
			//弹窗
			$('.submit').click(function(){
				$('.myalert').show()
			})
			
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide();
			})
			
			//单选
			var l_radios = $('.label-radio');
	
			$.each(l_radios, function () {
		        var l = $(this), input = $(this).children("input[type='radio']");
		        if (input.prop('checked')) {
		            l.removeClass('offradio').addClass('onradio');
		        } else {
		            l.removeClass('onradio').addClass('offradio');
		        }
		        input.click(function () {
		            if (l.attr('class').indexOf('offradio') > -1) {
		                var inputName = $(this).attr('name');
		                var allCheckbox = $('input[name="' + inputName + '"]');
		                $.each(allCheckbox, function () {
		                    $(this).parent('label').removeClass('onradio').addClass('offradio');
		                });
		                l.removeClass('offradio').addClass('onradio');
		            }
		        });
		    });
		})
	</script>
</html>
