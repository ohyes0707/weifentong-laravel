<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>添加工单</title>
		@include('Home.common.head')	
	</head>
	<body>
 		@include('Home.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		@include('Home.common.left')	
			<!--右侧-->
			<div class="main-right">
				
				<div class="header">申请工单</div>
				<div class="process clearfix">
					<div class="step active">
						<img src="{{ URL::asset('home/img/icon_big3.png') }}"/>
						<p>申请报备</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big6.png') }}" class="icon-step"/>
					<div class="step active">
						<img src="{{ URL::asset('home/img/icon_big5.png') }}"/>
						<p>客户授权</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big4.png') }}"/>
						<p>审核下单</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big2.png') }}"/>
						<p>报备成功</p>
					</div>
				</div>
				
				<form action="" method="post" class="f_order">
					<div class="f_primary">
						<p class="f_head">基础设置（*必选）</p>
						<div class="f_con">
							
							<div class="f-line clearfix">
								<div class="f-group col-sm-12 col-md-6 col-lg-5">
									<label>
									 	选择公众号：
									    <select name="gzh" class="form-input" id="gzh">
										    <option value="0">请选择</option>
										</select>
										
									</label>
									<span class="gh-tip">（*必须报备成功才可以选择公众号）</span>
									    					    
								</div>
								<div class="f-group col-sm-12 col-md-6 col-lg-3">	
									<label>
										总涨粉量：<input type="number" class="form-input allfans" onblur="disableInput()"/>
									</label>  					    
								</div>
								<div class="f-group col-sm-12 col-md-6 col-lg-4">	
									<label>
										每日涨粉：<input type="number" class="form-input minimum" placeholder="保底量" disabled onblur="compare()"/>
									</label>
									<label>
										至 <input type="number" class="form-input maximum" placeholder="最高量" disabled onblur="compare()"/>
									</label>	
									<label>
										建议量：<input type="number" class="form-input suggest" disabled onblur="compare()"/>
									</label>
								</div>
							</div>
							
							<div class="f-line clearfix">
								<div class="f-group col-sm-12 col-md-6 col-lg-5">
									<label>
											单价：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" class="form-input price" disabled onblur="sum()"/>
										
									</label>
									<span class="price-tip">（单月所有订单的平均单价为：¥<em>0.50</em>）</span>
								</div>
								<div class="f-group col-sm-12 col-md-6 col-lg-3">	
									<label>
										打款金额：<input type="number" class="form-input sum" disabled onblur="calculate()"/>
									</label>  					    
								</div>
								<div class="f-group col-sm-12 col-md-6 col-lg-4">
									<label>
										投放时间：<input type="text" class="form-input" id="dateStart" readonly/>
									</label>
									<label>
										至 <input type="text" class="form-input" id="dateEnd" readonly/>
									</label>
								</div>
							</div>
							
							<div class="f-line clearfix">
								<div class="f-group col-sm-12 col-md-6 col-lg-5">
									<label>
										投放时段：&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="form-input" id="timeStart" data-date-format="hh:ii" data-link-format="hh:ii" readonly/>
									</label>
									<label>
										至 <input type="text" class="form-input" id="timeEnd" data-date-format="hh:ii" data-link-format="hh:ii" readonly/>
									</label>
								</div>
							</div>
							
							
						</div>
					</div>
					
					<div class="f_property">
						<p class="f_head">属性设置（如不选择，则默认全部）</p>
						<div class="f_con_2"> 
							<ul>
								<li class="t-sm bd-top">
									<div class="t-left col-sm-2">
										多选要求
									</div>
									<div class="t-right col-sm-10 clearfix" >
										<label class="label-radio fl">
											<input type="radio" name="multiple" value="满足全部" checked/>满足全部
										</label>
										<label class="label-radio fl">
											<input type="radio" name="multiple" value="满足其一" />满足其一
										</label>
										<div class="explain fl">
											<span></span>
											<div class="exbox">
												<p>满足其一：属性设置中的热点区域、粉丝标签满足其中一条</p>
												<p>满足全部：属性设置中的热点区域、粉丝标签全部满足</p>
											</div>
										</div>
									</div>
								</li>
								<li class="t-sm">
									<div class="t-left col-sm-2">
										性别要求
									</div>
									<div class="t-right col-sm-10">
										<label class="label-radio">
											<input type="radio" name="sex" value="全部" checked/>全部
										</label>
										<label class="label-radio">
											<input type="radio" name="sex" value="1" />男
										</label>
										<label class="label-radio">
											<input type="radio" name="sex" value="0" />女
										</label>
									</div>
								</li>
								<li class="t-lg clearfix">
									<div class="t-left col-sm-2">
												热点区域
									</div>
									<div class="t-right col-sm-10">
										<div class="sub-right chosen-show clearfix">
											<span>当前选择：</span>
											<a href="javascript: void(0);" class="clear">[清空已选]</a>
											<div class="city-chosen">
												<span>浙江/杭州<em></em></span>
												<span>南京<em></em></span>
												<span>北京<em></em></span>
											</div>
										</div>
										<div class="sub-right choose">
											<div class="btn btn-default">请选择目标区域 <img src="{{ URL::asset('home/img/icon10.png') }}" alt="" /></div>
										</div>
									</div>
								</li>
								<li class="t-lg clearfix">
									<div class="t-left col-sm-2">
												粉丝标签
									</div>
									<div class="t-right col-sm-10">
										<div class="sub-right chosen-show clearfix">
											<span>当前选择：</span>
											<a href="javascript: void(0);" class="clear">[清空已选]</a>
											<div class="label-chosen">
												<span>浙江/杭州<em></em></span>
												<span>南京<em></em></span>
												<span>北京<em></em></span>
											</div>
										</div>
										<div class="sub-right choose">
											<div class="btn btn-default">请选择目标区域 <img src="{{ URL::asset('home/img/icon10.png') }}" alt="" /></div>
										</div>
									</div>
								</li>
								<li class="clearfix bd-bottom scenes">
									<div class="t-left col-sm-2">
												场景
									</div>
									<div class="t-right col-sm-10">
										<div class="sceneslist">
											<label class="check-label">
												<input type="checkbox" name="scene"/>酒店
											</label>
											<label class="check-label">
												<input type="checkbox" name="scene"/>电影院
											</label>
											<label class="check-label">
												<input type="checkbox" name="scene"/>酒店
											</label>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="formbtn">
						<input type="button" value="提交" class="submit" onclick="addorder()"/>
						<input type="button" value="取消" class="cancel" onclick="history.go(-1)"/>
					</div>
				</form>
				
			</div>
		</div>
		
		<div class="myalert" style="display: none;">
			<div class="mask"></div>
			<div class="alertbox">
				<a href="#" class="close">&times;</a>
				<div class="alertHead">提示</div>
				<div class="alertMain">
					您输入的数值有误，建议量&lt;=保底量&lt;=最高量&lt;=总涨粉量。<br />请核对后重新输入！
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			
			//选择日期
			$("#dateStart").datetimepicker({
				format: 'yyyy-mm-dd',
				minView:'month',
				language: 'zh-CN',
				autoclose:true,
			}).on("click",function(){
				$("#dateStart").datetimepicker("setEndDate",$("#dateEnd").val())
			});
			$("#dateEnd").datetimepicker({
				format: 'yyyy-mm-dd',
				minView:'month',
				language: 'zh-CN',
				autoclose:true,
			}).on("click",function(){
				$("#dateEnd").datetimepicker("setStartDate",$("#dateStart").val())
			});
			$('#timeStart').datetimepicker({
		        language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 1,
				minView: 0,
				maxView: 1,
				forceParse: 0
		    }).on("click",function(){
				$("#timeStart").datetimepicker("setEndDate",$("#timeEnd").val())
			});
			$('#timeEnd').datetimepicker({
		        language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 1,
				minView: 0,
				maxView: 1,
				forceParse: 0
		    }).on("click",function(){
				$("#timeEnd").datetimepicker("setStartDate",$("#timeStart").val())
			});
			
			
		})
	</script>
</html>
