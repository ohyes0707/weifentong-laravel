<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>工单详情</title>
 		@include('Home.common.head')
	</head>
	<body>
 		@include('Home.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Home.common.left')
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					<div class="form-group">
					    <label>
					    	选择公众号：					    	
					    </label>
					    <select name="gzh" class="form-control">
					    	<option value="0">请选择</option>
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="endDate" class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<div class="form-group">
					    <label>
					    	涨粉状态：					    	
					    </label>
					    <select name="fanState" class="form-control">
					    	<option value="0">请选择</option>
					    	<option value="已暂停">已暂停</option>
					    	<option value="涨粉中">涨粉中</option>
					    	<option value="已关闭">已关闭</option>
					    	<option value="已完成">已完成</option>
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	工单状态：					    	
					    </label>
					    <select name="orderState" class="form-control">
					    	<option value="0">请选择</option>
					    	<option value="审核通过">审核通过</option>
					    	<option value="审核失败">审核失败</option>
					    	<option value="审核中">审核中</option>
					    </select>						    
					</div>
					<input type="button" value="查询" class="find"/>
					<a class="add" href="addorder.html">+ 添加工单</a>	
				</form>
				<table class="table table-bordered table-responsive table-striped detail" id="orderTable">
					<tr>
						<th>公众号名称</th>
						<th>提交时间</th>
						<th>总涨粉量</th>
						<th>已涨粉</th>
						<th>日均涨粉</th>
						<th>当日取关率</th>
						<th>总取关率</th>
						<th>涨粉状态</th>
						<th>工单状态</th>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>已暂停</td>
						<td class="green">审核通过</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>涨粉中</td>
						<td class="green">审核通过</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>已暂停</td>
						<td class="red">审核失败</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>已关闭</td>
						<td class="green">审核通过</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>已完成</td>
						<td class="green">审核通过</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>已暂停</td>
						<td class="yellow">审核中</td>
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
			
			//选择日期
			$("#datetimeStart").datetimepicker({
				format: 'yyyy-mm-dd',
				minView:'month',
				language: 'zh-CN',
				autoclose:true,
			}).on("click",function(){
				$("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
			});
			$("#datetimeEnd").datetimepicker({
				format: 'yyyy-mm-dd',
				minView:'month',
				language: 'zh-CN',
				autoclose:true,
			}).on("click",function(){
				$("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
			});
			
			
		})
	</script>
</html>
