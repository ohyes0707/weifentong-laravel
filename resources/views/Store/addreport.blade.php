<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>美业管理-公众号授权-新增公众号</title>
	@include('Operate.common.head')

</head>
<body>
@include('Operate.common.top')


<div class="main clearfix">
	<!--左侧-->
	@include('Operate.common.left')
			<!--右侧-->
	<div class="main-right">
		<div class="header">新增公众号</div>
		<form action="" method="post" class="form">
			{{csrf_field()}}
			<div class="form-list">
				<label>公众号：</label><input type="input" name="wxname" class="text-input"/>
			</div>
			<div class="form-list">
				<label>门店名称：</label><input type="input" name="shopname" class="text-input"/>
			</div>
			<div class="form-list">
				<label>联系人：</label><input type="input" name="contact" class="text-input"/>
			</div>
			<div class="form-list">
				<label>联系方式：</label><input type="input" name="contactWay" class="text-input"/>
			</div>
			<input type="button" value="确定" class="submit"/>
			<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
			<div class="myalert" style="display: none;">
				<div class="mask"></div>
				<div class="alertbox">
					<a href="#" class="close">&times;</a>
					<div class="alertHead">提示</div>
					<div class="alertMain">
						确认是否增加此公众号？
					</div>
					<div class="alertbtn">
						<input type="submit" class="btn btn-sure" value="确认"/>
						<button type="button" class="btn btn-cancel">取消</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
<script type="text/javascript">
	$(function(){
		$('.submit').click(function(){
			$('.myalert').show()
		})
		$('.btn-cancel').click(function(){
			$('.myalert').hide()
		})
	})
</script>
</html>
