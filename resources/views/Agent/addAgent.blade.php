<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>新增代理</title>
		@include('Agent.common.head')
	</head>
	<body>
	@include('Agent.common.top')


		<div class="main clearfix">
			<!--左侧-->
			@include('Agent.common.left')

			<!--右侧-->
			<div class="main-right">
				<div class="header">新增代理</div>

				<form action="" method="get" class="form">
					{!! csrf_field() !!}
					<div class="form-list">
						<label>账号：</label><input type="input" name="username" class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><input type="password" name="password" placeholder="初始密码默认为123456" class="text-input" disabled/>
					</div>
					<div class="form-list">
						<label>代理名称：</label><input type="input" name="nick_name" placeholder="" class="text-input"/>
					</div>
					<div class="form-list">

						<label>保底价：</label><input type="input" name="ti_money" placeholder="" class="text-input"/>

					</div>
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="cancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此代理？
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
