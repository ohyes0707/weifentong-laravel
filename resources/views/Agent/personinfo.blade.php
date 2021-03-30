<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>个人信息</title>
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
				
				<div class="head">个人信息</div>
				<form action="" method="post" id="f_info" class="form">
					<div class="form-list">
						<label for="name">姓名：</label><input type="text" id="name" class="text-input" value="mary" disabled/>
					</div>
					<div class="form-list">
						<label for="telephone">手机号码：</label><input type="text" id="telephone" class="text-input" value="15300002222" disabled/>
					</div>
					<input type="button" value="返回" class="goback btn-blue" onclick="javascript:history.back(-1);"/>
				</form>					
			</div>
		</div>
	</body>
	<script type="text/javascript">
		//下拉菜单
			$('#navDropdown').on('show.bs.dropdown',function(){
				$('.top-caret').hide()
				$('.bottom-caret').show()
			})
			
			$('#navDropdown').on('hide.bs.dropdown',function(){
				$('.top-caret').show()
				$('.bottom-caret').hide()
			})
			
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
	</script>
</html>
