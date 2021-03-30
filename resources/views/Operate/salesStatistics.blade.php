<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>销售报表</title>
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
					<div class="form-group">
					    <label>
					    	销售代表：					    	
					    </label>
					    <select name="sales" class="form-control">
					    	<option value="0">全部</option>
							@if(isset($user) && !empty($user))
								@foreach($user as $k=>$v)
									@if($sales == $v['uid'])
										<option value="{{$v['uid']}}" selected>{{$v['nick_name']}}</option>
									@else
										<option value="{{$v['uid']}}">{{$v['nick_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" @if(isset($startDate))value="{{$startDate}}"@endif class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="endDate" @if(isset($endDate))value="{{$endDate}}"@endif class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="hidden" name="excels" class="excels" value=""/>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail colspan-6" id="reportTable">
					<tr>
						<th>销售代表</th>
						<th>成功关注</th>
						<th>取关数</th>
						<th>取关率</th>
						<th>平均单价</th>
						<th>销售额</th>
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['nick_name']}}</td>
								<td>{{$v['follow']}}</td>
								<td>{{$v['unfollow']}}</td>
								<td>
									@if($v['follow'] != 0)
										{{sprintf('%.2f',$v['unfollow']/$v['follow']*100)}}%
									@else
										0.00%
									@endif
								</td>
								<td>{{sprintf('%.2f',$v['price'])}}</td>
								<td>{{$v['cost']}}</td>
								<td><a href="/operate/user/saleForm?uid={{$v['o_uid']}}&uname={{$v['nick_name']}}&startDate={{$startDate}}&endDate={{$endDate}}">查看详情</a></td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator}}
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
			$(".reset").click(function(){
				uid = $(".uid").val();
				window.location.href='statistics';
			})
			$(".excel").click(function(){
				$(".excels").val(1);
				$("#f-report").submit();
			})
			$(".find").click(function(){
				$(".excels").val(0);
				$("#f-report").submit();
			})
			
		})
	</script>
</html>
