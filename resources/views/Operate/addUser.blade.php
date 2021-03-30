<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>系统权限-管理员列表-新增</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')


		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			</div>
			
			<!--右侧-->
			<div class="main-right">
				<div class="header">新增</div>

				<form action="" method="post" class="form">
					{!! csrf_field() !!}
					<div class="form-list">
						<label>用户名：</label><input type="input" name="username" class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><input type="password" name="password" placeholder="初始密码默认为123456" class="text-input" disabled/>
					</div>
					<div class="form-list">
						<label>备注：</label><input type="input" name="remark" placeholder="所有人姓名" class="text-input"/>
					</div>
					<div class="form-list">
						<label>角色：</label>
						<select name="role" class="text-input">
							@foreach($data['data'] as $key=>$v)
								<option value={{$v['id']}}>{{$v['title']}}</option>
							@endforeach
						</select>
					</div>
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此管理员？
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
