<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>系统权限-管理员列表-编辑</title>
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
				<div class="header">编辑</div>
				
				<form action="" method="post" class="form">
					{!! csrf_field() !!}
					<div class="form-list">
						<label>用户名：</label><input type="input" name="username" value={{$data['username']}} class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><label class="input-label"><input type="checkbox" name="password"/>重置为初始密码123456</label>
					</div>
					<div class="form-list">
						<label>备注：</label><input type="input" name="remark" value={{$data['remark']}} class="text-input"/>
					</div>
					<div class="form-list">
						<label>角色：</label>
						<select name="role" class="text-input">
							@foreach($data['userGroup'] as $key=>$v)
								@if(isset($data['roleid']) && $data['roleid'] == $v['id'])
									<option selected value={{$v['id']}}>{{$v['title']}}</option>
								@else
									<option value={{$v['id']}}>{{$v['title']}}</option>

								@endif

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
