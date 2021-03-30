 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>修改密码</title>
		<script>
			var changePwd_url = "{{ URL::asset('business/user/changeover') }}"
		</script>
		@include('Business.common.head')
	</head>
	<body>
		<!--导航栏-->
		@include('Business.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Business.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="header">修改密码</div>
				<form action="" method="post" id="f_pwd" class="f-addshop">
				{{csrf_field()}}
					<div class="form-list clearfix">
						<label for="old-pwd">旧密码：</label><input type="password" id="old-pwd" name="old_pwd" class="form-input" onblur="pwdCheck()"/>
						<p class="tip pwdtip" style="display: none;">您输入的旧密码有误，请核对后重新输入！</p>
					</div>
					
					<div class="form-list clearfix">
						<label for="new-pwd">新密码：</label><input type="password" id="new-pwd" name="new_pwd1" class="form-input" oninput="newpwd()"/>
						<p class="tip newtip" style="display: none;">密码至少为6位</p>
					</div>
					<div class="form-list clearfix">
						<label for="makesure">确认密码：</label><input type="password" id="makesure" name="new_pwd2" class="form-input"  oninput="checkAgain()"/>
						<p class="tip againtip" style="display: none;">两次输入的密码不一致，请核对后重新输入！</p>
					</div>
					<div class="btns">
						<input type="button" value="确定" class="submit" onclick="changePwd()"/>
						<input type="button" value="返回" class="goback" onclick="history.go(-1)">
					</div>
				</form>	
				
			</div>
		</div>
	</body>
	
</html>
