<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>代理管理-新增</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>	
		<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/common.css"/>
		<link rel="stylesheet" type="text/css" href="css/public.css"/>
		<link rel="stylesheet" type="text/css" href="css/page.css"/>
	
		<script src="js/jquery-2.1.4.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/bootstrap-datetimepicker.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<nav class="navbar" role="navigation" id="nav1">
		    <div class="container-fluid">
		    <div class="navbar-header">
		        <a class="navbar-brand" href="#"><img src="img/logo.png"/></a>
		    </div>
		    <div class="navbar-right">
		        <div class="dropdown" id="navDropdown">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		                15366669999
		                <b class="icon-caret">
		                	<img src="img/icon10.png" class="top-caret"/>
		                	<img src="img/icon18.png" class="bottom-caret" style="display: none;"/>
		                </b>
		            </a>
		            <ul class="dropdown-menu dropdown-menu-right">
		            	<li class="info">
							<a href="personinfo.html">个人信息</a>
						</li>
						<li class="change">
							<a href="changepwd.html">修改密码</a>
						</li>
		                <li class="exit"><a href="#">退出</a></li>
		            </ul>
		        </div>
		    </div>
		    </div>
		</nav>
		
		<div class="main clearfix">
			<!--左侧-->
			<div class="main-left">
				<div class="left-menu">
					<a href="javascript: menuToggle();" class="menu-header">
						<span class="icon-folder">
							<img src="img/icon.png" class="close-folder"/>
							<img src="img/icon2.png" class="open-folder" style="display: none;"/>
						</span>
						代理系统
						<span class="icon-arrow">
							<img src="img/icon8.png" class="bottom-arrow"/>
							<img src="img/icon7.png" class="top-arrow" style="display: none;"/>
						</span>
					</a>
					<ul class="menu-list" style="display: none;">
						<li>
							<a href="report.html">报备详情</a>
						</li>
						<li>
							<a href="workorder.html">工单详情</a>
						</li>
						<li>
							<a href="sales.html">销售统计</a>
						</li>
						<li class="active">
							<a href="agencyManage.html">代理管理</a>
						</li>
					</ul>
				</div>
			</div>
			
			<!--右侧-->
			<div class="main-right">
				<div class="head">新增代理</div>
				
				<form action="" method="post" class="form">
					<div class="form-list">
						<label>账号：</label><input type="input" name="account" placeholder="手机号码" class="text-input"/>
					</div>
					<div class="form-list">
						<label>密码：</label><input type="password" name="password" placeholder="初始密码默认为123456" class="text-input" disabled/>
					</div>
					<div class="form-list">
						<label>代理名称：</label><input type="input" name="agencyName" class="text-input"/>
					</div>
					<div class="form-list">
						<label>保底价：</label><input type="input" name="minPrice" class="text-input"/>
					</div>
					
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="cancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此代理？
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
			//下拉菜单
			$('#navDropdown').on('show.bs.dropdown',function(){
				$('.top-caret').hide()
				$('.bottom-caret').show()
			})
			
			$('#navDropdown').on('hide.bs.dropdown',function(){
				$('.top-caret').show()
				$('.bottom-caret').hide()
			})
			
			//弹窗
			$('.submit').click(function(){
				$('.myalert').show()
			})
			
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide();
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
		
	</script>
</html>
