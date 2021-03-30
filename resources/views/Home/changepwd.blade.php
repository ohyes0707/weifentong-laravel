 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="_token" content="{{ csrf_token() }}"/>
		<title>修改密码</title>
		<script>
			var changePwd_url = "{{ URL::asset('home/user/changeover') }}"
		</script>
 		@include('Home.common.head')
	</head>
	<body>
		@include('Home.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		@include('Home.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="head">修改密码</div>
				<form action="" method="post" id="f_pwd" class="form">
					{{csrf_field()}}
					<div class="form-list clearfix">
						<label for="old-pwd">旧密码：</label><input type="password" id="old-pwd" class="text-input" onblur="pwdCheck()"/>
							<p class="tip pwdtip" style="display: none;">您输入的旧密码有误，请核对后重新输入！</p>
					</div>
					
					<div class="form-list clearfix">
						<label for="new-pwd">新密码：</label><input type="password" id="new-pwd" class="text-input" oninput="newpwd()"/>
						<p class="tip newtip" style="display: none;">密码至少为6位</p>
					</div>
					<div class="form-list clearfix">
						<label for="makesure">确认密码：</label><input type="password" id="makesure" class="text-input" oninput="checkAgain()"/>
						<p class="tip againtip" style="display: none;">两次输入的密码不一致，请核对后重新输入！</p>
					</div>
					<input type="button" value="确定" class="submit" onclick="changePwd()"/>
					<input type="button" value="取消" class="cancel" onclick="history.go(-1)"/>
				</form>
				
			</div>
		</div>
	</body>
</html>
