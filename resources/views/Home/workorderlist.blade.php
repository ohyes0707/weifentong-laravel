<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>工单列表</title>
		@include('Home.common.head')	
	</head>
	<body>
		@include('Home.common.top')
		<div class="main clearfix">
			<!--左侧-->
		@include('Home.common.left')
			
                		<!--右侧-->
			<div class="main-right">
				<form action="" method="get" class="form-inline" role="form" id="f-report">
					<div class="form-group">
                                            <input type="hidden" name="action" value="search"/>
					    <label>
					    	选择公众号：					    	
					    </label>
					    <select name="gzh" class="form-control">
					    	<option value="">请选择</option>
                                                @if(count($wx_name)>0)
                                                @foreach ($wx_name as $wx)
                                                <option value="{{ $wx['id'] }}"
                                                    @if ($gzh  == $wx['id'])
                                                        selected = "selected"
                                                    @endif
                                                        >{{ $wx['wx_name'] }}</option>
                                                @endforeach
                                                @endif
					    </select>					    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{ $startDate }}" readonly /></label>
						
						<label class="datelabel">至 <input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{ $endDate }}" readonly /></label>
						
					</div>
                                    	<div class="form-group">
					    <label>
					    	涨粉状态：					    	
					    </label>
					    <select name="fanstate" class="form-control">
					    	<option>请选择</option>
					    	<option value="1" 
                                                    @if ($fanstate  == 1)
                                                        selected = "selected"
                                                    @endif
                                                    >涨粉中</option>
                                                <option value="2" 
                                                    @if ($fanstate  == 2)
                                                        selected = "selected"
                                                    @endif
                                                    >已暂停</option>
					    	<option value="3" 
                                                    @if ($fanstate  == 3)
                                                        selected = "selected"
                                                    @endif
                                                    >已关闭</option>
					    	<option value="4" 
                                                    @if ($fanstate  == 4)
                                                        selected = "selected"
                                                    @endif
                                                    >已完成</option>
                                                <option value="5" 
                                                    @if ($fanstate  == 5)
                                                        selected = "selected"
                                                    @endif
                                                    >未设置</option>
					    </select>						    
					</div>

					<div class="form-group">
					    <label>
					    	审核状态：					    	
					    </label>
					    <select name="stat" class="form-control">
					    	<option value="" >请选择</option>
					    	<option value="1" 
                                                    @if ($stat  == 1)
                                                        selected = "selected"
                                                    @endif
                                                    >审核中</option>
                                                <option value="2" 
                                                    @if ($stat  == 2)
                                                        selected = "selected"
                                                    @endif
                                                    >审核失败</option>
					    	<option value="3" 
                                                    @if ($stat  == 3)
                                                        selected = "selected"
                                                    @endif
                                                    >审核通过</option>
					    	
					    </select>						    
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<a class="add" href="getworkorder">+ 添加工单</a>	
				</form>
				<table class="table table-bordered table-responsive table-striped detail" id="orderTable">
					<tr>
						<th>公众号名称</th>
						<th>提交时间</th>
						<th>总涨粉量</th>
						<th>单价</th>
						<th>已涨粉</th>
						<th>日均涨粉</th>
						<th>当日取关率</th>
						<th>总取关率</th>
						<th>涨粉状态</th>
						<th>工单状态</th>
						<th>操作</th>
					</tr>
					
                                        
                                        @foreach ($paginator as $value)
					<tr>
						<td>{{ $value['wx_name'] }}</td>
						<td>{{ $value['commit_time'] }}</td>
						<td>{{ $value['w_total_fans'] }}</td>
						<td>{{ $value['w_per_price'] }}</td>
                                                <td>{{ $value['total_fans'] }}</td>
                                                <td>{{ $value['day_fans'] }}</td>
 						@if($value['subscribe_today']==0)
                                                        <td>0</td>
                                                @elseif($value['subscribe_today']!=='-'&&$value['subscribe_today']!=0)
							<td>{{substr($value['un_subscribe_today']/$value['subscribe_today']*100,0,5)}}%</td>
                      
						@else
							<td>{{ $value['subscribe_today'] }}</td>
						@endif
                                                @if($value['total_fans']==0)
                                                 <td>0</td>
						@elseif($value['day_fans']!=='-')
							<td>{{substr($value['un_subscribe']/$value['total_fans']*100,0,4)}}%</td>
						@else
							<td>-</td>
						@endif
                                                <td>
							@if($value['order_status'] == 1)
								<span class="colour_4">涨粉中</span>
							@elseif($value['order_status'] == 2)
								<span class="colour_1">已暂停</span>
							@elseif($value['order_status'] == 3)
								<span class="colour_3">已关闭</span>
							@elseif($value['order_status'] == 4)
								<span class="colour_3">已完成</span>
                                                        @elseif($value['order_status'] == 5)
                                                        <span class="colour_2">未设置</span>
                                                        @else
                                                                -
							@endif
						</td>
                                                   @if ($value['w_status']  === 1)
                                                        <td class="colour_1">审核中</td>
                                                    @elseif ($value['w_status']  === 3)
                                                        <td class="colour_2">审核失败</td>
                                                    @elseif ($value['w_status'] === 2)
                                                        <td class="colour_3">审核通过</td>
                                                    @endif
                                                    
						<td>
                                                    <button text="{{ $value['id'] }}" class="btn btn-blue edit" >修改</button>
						</td>
					</tr>
                                        @endforeach
				</table>

				{{ $paginator ->appends(array('gzh'=>$gzh,'startDate'=>$startDate,'endDate'=>$endDate,'stat'=>$stat,'action'=>$action,'fanstate'=>$fanstate))->render() }}
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
			
                        
                        $(".reset").click(function(){ 
                            window.location.href='getworkorderlist';
                        }); 
			
		})
	</script>
</html>