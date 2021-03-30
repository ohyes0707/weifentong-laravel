<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>个人信息</title>
		@include('Home.common.head')
	</head>
	<body>
		@include('Home.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		@include('Home.common.left')
			<!--右侧-->
			<div class="main-right">
				
				<div class="head">个人信息</div>
				<form action="" method="post" id="f_info" class="form">
					<div class="form-list">
						<label for="name">姓名：</label><input type="text" id="name" class="text-input" @if(isset($user_info['nick_name']))value="{{$user_info['nick_name']}}"@endif disabled/>
					</div>
					<div class="form-list">
						<label for="telephone">手机号码：</label><input type="text" id="telephone" class="text-input"  @if(isset($user_info['username']))value="{{$user_info['username']}}"@endif disabled/>
					</div>
					<div class="form-list">
						<label for="email">邮箱：</label><input type="email" id="email" class="text-input"  @if(isset($user_info['user_mail']))value="{{$user_info['user_mail']}}"@endif disabled/>
					</div>
					<input type="button" value="返回" class="goback btn-blue" onclick="javascript:history.back(-1);"/>
				</form>					
			</div>
		</div>
	</body>
</html>
