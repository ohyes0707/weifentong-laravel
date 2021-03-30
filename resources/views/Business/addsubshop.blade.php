
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>商家中心-子商户</title>
		@include('Business.common.head')
	</head>
	<body>
		@include('Business.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Business.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="header">新增子商户</div>
				
				<form action="" method="post" class="f-addshop">
					<div class="form-list">
						<label>子商户名称：</label>
						<input type="text" name="shopName" class="form-input" />
					</div>
					<div class="form-list">
						<label>密码：</label>
						<input type="password" name="password" class="form-input" placeholder="初始密码默认为123456" disabled/>
					</div>
					<div class="form-list">
						<label>结算一口价：</label>
						<input type="text" name="price" class="form-input" />
					</div>
					<div class="btns">
						<input type="button" value="确定" class="blue-btn" id="makesure"/>
						<input type="button" value="返回" class="goback" onclick="history.go(-1)"/>
					</div>
					<input type="hidden" name="_token"         value="{{  csrf_token()  }}"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="javascript:void(0)" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								请确认是否新增该子商户？
							</div>
							<div class="alertbtn">
								<input type="submit" name="submit" value="确认" class="blue-btn" id="submit"/>
								<button class="goback btn-cancel">取消</button>
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
			$('#makesure').click(function(){
				$('.myalert').show();
			})

			$('.close,.btn-cancel').click(function(){
				//点击取消
				$('.myalert').hide();
				return false;
			})
			
		})
	</script>
</html>
