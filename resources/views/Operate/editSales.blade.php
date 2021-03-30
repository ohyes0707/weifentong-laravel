<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>用户管理-销售列表-编辑</title>
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
						<label>手机号：</label><input type="input" name="mobile" @if(isset($list['username']))value="{{$list['username']}}"@endif class="text-input"/>
					</div>
					<div class="form-list">
						<label>姓名：</label><input type="input" name="name" @if(isset($list['nick_name']))value="{{$list['nick_name']}}"@endif class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><label class="input-label"><input type="checkbox" name="password"/>重置为初始密码123456</label>
					</div>
					<div class="form-list">
						<label>保底价：</label><input type="input" name="minPrice" @if(isset($list['ti_money']))value="{{$list['ti_money']}}"@endif class="text-input"/>
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
				$('.myalert').hide();
			})
			
		})
	</script>
</html>
