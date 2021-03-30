<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>平台统计报表</title>
		@include('Operate.common.head')
	</head>
	<body>
		@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<input type="hidden" name="status" id="status" value=""/>
					<div class="r_form clearfix">
						<div class="f_radio">
							<a href="platCount?status=1" value="1" @if(isset($status) && $status==1)class="on_radio"@endif>次数</a>
							<a href="platCount?status=2" value="2" @if(isset($status) && $status==2)class="on_radio"@endif>人数</a>
						</div>
					</div>
					<div class="form-group">
					    <label>
					    	用户选择：
					    </label>
					    <select name="user" class="form-control">
					    	<option value="0">全部</option>
							@if(isset($user) && $user==1)
					    		<option value="1" selected>新用户</option>
							@else
								<option value="1">新用户</option>
							@endif
							@if(isset($user) && $user==2)
					    		<option value="2" selected>老用户</option>
							@else
								<option value="2">老用户</option>
							@endif
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" @if(isset($startDate))value="{{$startDate}}"@endif name="startDate" class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excel" value=""/>
					<input type="hidden" name="status" value="{{$status}}" class="status"/>
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail colspan-7" id="reportTable">
					<tr>
						<th>日期</th>
						<th>获取公众号</th>
						<th>成功获取公众号</th>
						<th>微信认证</th>
						<th>成功关注</th>
						<th>填充率</th>
					</tr>
					@if(isset($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['date_time']}}</td>
								<td>{{$v['sumgetwx']}}</td>
								<td>{{$v['getwx']}}</td>
								<td>{{$v['complet']}}</td>
								<td>{{$v['follow']}}</td>
								<td>
									@if($v['sumgetwx'] != 0)
										{{sprintf('%.2f',$v['getwx']/$v['sumgetwx']*100)}}%
									@endif
								</td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
			</div>
		</div>
		
		<div class="myalert" style="display: none;">
			<div class="mask"></div>
			<div class="alertbox">
				<a href="#" class="close">&times;</a>
				<div class="alertHead">提示</div>
				<div class="alertMain">
					
				</div>
				<div class="alertbtn">
					<button class="btn btn-sure">确定</button>
					<button class="btn btn-cancel">取消</button>
				</div>
			</div>
		</div>
		<div class="cause" style="display: none;">
			<div class="mask"></div>
			<div class="causeMain">
				<p>驳回原因</p>
				<textarea name="reason"></textarea>
				<span class="tip causeTip">原因必填</span>
				<div class="causebtn">
					<input type="button" value="确认" class="sure"/>
					<input type="button" value="取消" class="cancel" />	
				</div>
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
			
			
			//左边列表栏缩略
			/*-----------------js修改部分------------------*/
			
			/*-----------------js修改部分------------------*/

			$(".excel").click(function(){
				$('input[name=excel]').val(1);
				$("#f-report").submit();
			})
			$(".find").click(function(){
				var status = $(".on_radio").attr('value');
				$("#status").val(status);
				$("#f-report").attr('action','platCount');
				var startDate = new Date($('#datetimeStart').val()).getTime()
				var endDate = new Date($('#datetimeEnd').val()).getTime()
				var delta=parseInt((endDate-startDate)/1000/60/60/24);
				if(delta>29){
					alert('数据太多啦，请导出Excel查看')
				}else{
					$("#f-report").submit();
				}
			})
			$(".reset").click(function(){
				var status = $(".on_radio").attr('value');
				window.location.href='platCount?status='+status;
			})
		})
	</script>
</html>
