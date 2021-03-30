 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>修改密码</title>
		<script>
			var changePwd_url = "{{ URL::asset('agent/user/changeover') }}"
		</script>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('Agent/css/common.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('Agent/css/public.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('Agent/css/page.css') }}"/>
		
		<script src="{{ URL::asset('js/jquery-2.1.4.min.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('js/bootstrap.min.js') }}" type="text/javascript" charset="utf-8"></script>
		
	</head>
	<body>
		@include('Agent.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Agent.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="head">修改密码</div>
				<form action="" method="post" id="f_pwd" class="form">
					<div class="form-list clearfix">
						<label for="old-pwd">旧密码：</label><input type="password" id="old-pwd" name="old_pwd" class="text-input" onblur="pwdCheck()"/>
						<p class="tip pwdtip" style="display: none;">密码有误，请重新输入！</p>
					</div>
					
					<div class="form-list clearfix">
						<label for="new-pwd">新密码：</label><input type="password" id="new-pwd" name="new_pwd1" class="text-input" oninput="newpwd()"/>
						<p class="tip newtip" style="display: none;">密码至少为6位</p>
					</div>
					<div class="form-list clearfix">
						<label for="makesure">确认密码：</label><input type="password" id="makesure" name="new_pwd2" class="text-input" oninput="checkAgain()"/>
						<p class="tip againtip" style="display: none;">密码不一致，请重新输入！</p>
					</div>
					<input type="submit" value="确定" class="submit" onclick="changePwd()"/>
					<input type="button" value="取消" class="cancel" onclick="history.go(-1)"/>
				</form>	
				
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			//下拉菜单
			$('#navDropdown').on('show.bs.dropdown',function(){
				$('.top-caret').hide()
				$('.bottom-caret').show()
			})
			
			$('#navDropdown').on('hide.bs.dropdown',function(){
				$('.top-caret').show()
				$('.bottom-caret').hide()
			})
			$('.form').submit(function(){
				var $input=$('.text-input');
				var $tip=$('.tip:visible')
				for(var i=0,len=$input.length;i<len;i++){
					if($input.eq(i).val() == ''){
						alert('请完整填写信息');
						return false;
					}
				}
				if($tip.length > 0){
					alert('填写的信息有误')
					return false;
				}
				return true;
			})
		})
		
	</script>
	<script type="text/javascript">
		//左边菜单栏切换
		var a=false;
		function menuToggle(){
			a = !a;
			if(a){
				$('.close-folder').hide();
				$('.open-folder').show();
				$('.bottom-arrow').hide();
				$('.top-arrow').show();
				$('.menu-list').show();
			}else{
				$('.close-folder').show();
				$('.open-folder').hide();
				$('.bottom-arrow').show();
				$('.top-arrow').hide();
				$('.menu-list').hide();
			}
		}
		//修改密码
		function pwdCheck(){
			var pwd=$('#old-pwd').val();
			var token = $("input[name=_token]").val();
			$.post('changepwd',{'_token':token,'pwd':pwd},function(res){
				if(res.message=="原始密码错误") {
					//密码错误
					$('.pwdtip').show();
				}else{
					//密码正确
					$('.pwdtip').hide();
				}
			},'json')
		}
		//新密码检测
		function newpwd(){
			var pwd=$('#new-pwd').val();
			if(pwd.length < 6){
				$('.newtip').html('密码至少需要6位！').show()
			}else if(pwd.match(/^\d+$/)) {
		        $('.newtip').html('密码过于简单，请重新输入！').show();
		    }else{
		    	$('.newtip').hide();
		    }
		}
		//再次输入新密码检测
		function checkAgain(){
			var pwd1=$('#new-pwd').val();
			var pwd2=$('#makesure').val();
			if(pwd1 != pwd2){
				$('.againtip').show();
			}else{
				$('.againtip').hide();
			}
		}
		//提交修改密码
		function changePwd(){
			var token = $("input[name=_token]").val();
			var new_pwd = $("#new-pwd").val();
			var type = $(".pwdtip").css('display');
			$.post( changePwd_url,{'_token':token,'new_pwd':new_pwd,'type':type},function(res){
				if(res){
					alert(res);
					window.history.go(-1);
					//修改成功
					//alert('您的密码修已修改成功，即将跳转至首页。')
					//window.location.href='index.html';
				}else{
					//修改失败
				}
			})
		}
	</script>
</html>
