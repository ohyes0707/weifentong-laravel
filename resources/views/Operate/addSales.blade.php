<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>用户管理-销售列表-新增销售</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<div class="header">新增销售</div>
				
				<form action="" method="post" class="form">
					{{csrf_field()}}
					<div class="form-list">
						<label>手机号：</label><input type="input" name="mobile" placeholder="手机号码" class="text-input"/>
					</div>
					<div class="form-list">
						<label>姓名：</label><input type="input" name="name" class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><input type="password" name="password" placeholder="初始密码默认为123456" class="text-input" disabled/>
					</div>
					<div class="form-list">
						<label>保底价：</label><input type="input" name="minPrice" class="text-input"/>
					</div>
					
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此销售代表？
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认"/>
								<button class="btn btn-cancel">取消</button>
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
				$('.myalert').hide()
			})
			
		})
	</script>
</html>
