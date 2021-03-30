<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>报备详情</title>
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
                    {!! csrf_field() !!}
					<div class="form-group">
					    <label>
					    	选择公众号：					    	
					    </label>
                        <select name="wxName" class="form-control">
					    	<option value="">全部</option>
                            @foreach($wxlist as $v)
                            <option  @if(isset($post['wxName'])&&($v['wx_name']==$post['wxName']))selected="selected"@endif value="{{$v['wx_name']}}">{{$v['wx_name']}}</option>
                            @endforeach
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：
                            @if(isset($post['startDate']))
                                <input type="text" value="{{$post['startDate']}}" name="startDate" class="form-control date" id="datetimeStart" readonly />
                            @else
                                <input type="text" name="startDate" class="form-control date" id="datetimeStart" readonly />
                            @endif
                        </label>
						
						<label class="datelabel">至&nbsp;
                            @if(isset($post['endDate']))
                                <input type="text" value="{{$post['endDate']}}" name="endDate" class="form-control date" id="datetimeEnd" readonly />
                            @else
                                <input type="text" name="endDate" class="form-control date" id="datetimeEnd" readonly />
                            @endif
                        </label>
						
					</div>
					<div class="form-group">
					    <label>
					    	报备状态：					    	
					    </label>

					    <select name="state" class="form-control">
					    	<option value="0">全部</option>
                            @if(isset($post['state']) && ($post['state']=='1'))
					    	    <option selected value="1">未授权</option>
                            @else
                                <option value="1">未授权</option>
                            @endif
                            @if(isset($post['state']) && ($post['state']=='2'))
                                <option selected value="2">授权失败</option>
                            @else
                                <option value="2">授权失败</option>
                            @endif
                            @if(isset($post['state']) && $post['state']==3)
					    	    <option selected value="3">未下单</option>
                            @else
                                <option value="3">未下单</option>
                            @endif
                            @if(isset($post['state']) && $post['state']==4)
					    	    <option selected value="4">报备成功</option>
                            @else
                                <option value="4">报备成功</option>
                            @endif
                        </select>
                    </div>
					<input type="submit" value="查询" class="find"/>
                    <input type="reset" value="重置" class="reset"/>
					<a class="add" href="{{action('Home\ReportController@addReport')}}">+ 新增报备</a>
					
				</form>
				
				<table class="table table-bordered table-responsive table-striped detail" id="reportTable">
					<tr>
						<th>公众号</th>
						<th>申请时间</th>
						<th>公司名称</th>
						<th>联系人</th>
						<th>联系方式</th>
						<th>报备状态</th>
						<th>操作</th>
					</tr>
                    @foreach($reportlist as $v)
					<tr>
						<td>{{$v['wx_name']}}</td>
						<td>{{$v['create_time']}}</td>
						<td>{{$v['company']}}</td>
						<td>{{$v['contacts']}}</td>
						<td>{{$v['telphone']}}</td>
                        @if($v['status']==1)
                            <td class="colour_1">未授权</td>
                        @elseif($v['status']==2)
                            <td class="colour_2">授权失败</td>
                        @elseif($v['status']==3)
                            <td class="colour_3">未下单</td>
                        @elseif($v['status']==4)
                            <td class="colour_3">报备成功</td>
                        @endif
						<td>
                        @if($v['status']==1||$v['status']==2)
                                <a href="editreport?id={{$v['id']}}"><button class="btn btn-blue">修改</button></a>
                        @else
                                <button class="btn btn-grey" disabled>修改</button>
                        @endif
						</td>
					</tr>
                    @endforeach
				</table>
                {{ $paginator ->appends($post)->render() }}

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

            //重置
            $(".reset").click(function(){
                window.location.href = '{{ URL::asset('index.php/home/report/reportlist') }}';
            })
			
			
		})
	</script>
</html>
