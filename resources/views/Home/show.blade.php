@include('operate.common.header')

	<nav class="navbar" role="navigation" id="nav1">
		    <div class="container-fluid">
		    <div class="navbar-header">
		        <a class="navbar-brand" href="#"><img src="img/logo.png"/></a>
		    </div>
		    <div class="navbar-right">
		        <div class="dropdown" id="navDropdown">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		                username
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
						用户系统
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
						<li class="active">
							<a href="sales.html">销售统计</a>
						</li>
					</ul>
				</div>
			</div>
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					<div class="form-group">
					    <label>
					    	选择公众号：					    	
					    </label>
					    <select name="gzh" class="form-control" id="gzh">
					    	<option value="0">请选择</option>
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="button" value="查询" class="find"/>
				</form>
				<table class="table table-bordered table-responsive table-striped detail" id="saleTable">
					<tr>
						<th>公众号</th>
						<th>涨粉量</th>
						<th>单价</th>
						<th>销售额</th>
						<th>提成</th>
					</tr>
					<tr>
						<td>新世相</td>
						<td>10000</td>
						<td>0.8</td>
						<td>20000</td>
						<td>12.00</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<table class="table table-bordered table-responsive table-striped detail" id="totalTable">
					<tr>
						<th rowspan="2" style="line-height: 386%;">合计</th>
						<th>总涨粉量</th>
						<th>平均单价</th>
						<th>总销售额</th>
						<th>总提成</th>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				<ul class="pagination">
					<li><a href="#">1</a></li>
					<li><a href="#">&laquo;</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">6</a></li>
					<li><a href="#">7</a></li>
					<li class="active"><a href="#">8</a></li>
					<li><a href="#">9</a></li>
					<li><a href="#">10</a></li>
					<li><a href="#">11</a></li>
					<li><a href="#">12</a></li>
					<li><a href="#">13</a></li>
					<li><a href="#">14</a></li>
					<li><a href="#">&raquo;</a></li>
					<li><a href="#">20</a></li>
				</ul>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			$("#datetimeStart").datetimepicker({
		    	format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
//		        startDate:new Date()
		    }).on("click",function(){
		        $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
		    });
		    $("#datetimeEnd").datetimepicker({
		        format: 'yyyy-mm-dd',
		        minView:'month',
		        language: 'zh-CN',
		        autoclose:true,
//		        startDate:new Date()
		    }).on("click",function(){
		        $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
		    });
		})
	</script>
</html>
