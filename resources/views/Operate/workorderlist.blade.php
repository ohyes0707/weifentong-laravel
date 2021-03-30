<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>工单列表</title>
		@include('Operate.common.head')	
	</head>
	<body>
		@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
		@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="?action=search" method="get" class="form-inline" role="form" id="f-report">
					<div class="form-group  position">
                                            <input type="hidden" name="action" value="search"/>
					    <label>
					    	选择公众号：
					    </label>
<!--					    <select name="gzh" class="form-control">
					    	<option value="">请选择</option>
                                                @if($wx_name!='')
                                                @foreach ($wx_name as $wx)
                                                <option value="{{ $wx['wx_id'] }}"
                                                    @if ($gzh  == $wx['wx_id'])
                                                        selected = "selected"
                                                    @endif
                                                        >{{ $wx['wx_name'] }}</option>
                                                @endforeach
                                                @endif
					    </select>	-->
                                            <input type="text" id="inputgzh" hidden name="gzh">
                                            <input type="text" id="inputv" onkeyup="checkFunction()" name="wxName"  class="form-control">
                                                    <ul id="ul_hide">
                                                        @if($wx_name!='')
                                                            @foreach ($wx_name as $wx)
                                                                @if ($gzh  == $wx['wx_id'])
                                                                   <script>
                                                                   $("#inputv").val("{{ $wx['wx_name'] }}");
                                                                   </script>
                                                                @endif
                                                            <li class="option_obj" style="display: none;" tit="{{ $wx['wx_id'] }}">{{ $wx['wx_name'] }}</li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
						<script>
							$(".option_obj").click(function(){
								var wxname = $(this).text();
                                                                var wxid = $(this).attr('tit');
								$("#inputv").val(wxname);
                                                                $("#inputgzh").val(wxid);
								$(".option_obj").hide();
							})

							function checkFunction(){
								var inputv,filter,ul,li,a,i;
								inputv = document.getElementById('inputv');
								filter = inputv.value.toUpperCase();
								ul =  document.getElementById('ul_hide');
								li = ul.getElementsByTagName('li');
								if(filter==''){
									$(".option_obj").hide();
									return false;
								}
								for(i=0;i<li.length;i++){
									var tt = li[i].innerHTML.toUpperCase().indexOf(filter);
									if(tt>=0){
										li[i].style.display = "";
									}else{
										li[i].style.display = "none";
									}
								}
							}
						</script>
					</div>
                                        <div class="form-group">
                                            <input type="hidden" name="action" value="search"/>
					    <label>
					    	销售代表：
					    </label>
					    <select name="user" class="form-control">
					    	<option value="">请选择</option>
                                                @if($user_name!='')
                                                @foreach ($user_name as $username)
                                                <option value="{{ $username['user_id'] }}"
                                                    @if ($userid  == $username['user_id'])
                                                        selected = "selected"
                                                    @endif
                                                        >{{ $username['nick_name'] }}</option>
                                                @endforeach
                                                @endif
					    </select>						    
					</div>
					<div class="form-group">
                                            <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{ $startDate }}" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{ $endDate }}" readonly /></label>
						
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
                                    
                                    <div class="form-group">
					    <label>
					    	涨粉状态：					    	
					    </label>
					    <select name="fanstate" class="form-control">
					    	<option value="" >请选择</option>
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
					<input type="submit" value="查询" class="find"/>	
                                        <input type="reset" value="重置" class="reset"/>
				</form>
				<table class="table table-bordered table-responsive table-striped detail" id="reportTable">
					<tr>
						<th>公众号</th>
						<th>提交时间</th>
						<th>总涨粉量</th>
						<th>单价</th>
                                                <th>销售代表</th>
                                                <th>涨粉状态</th>
						<th>审核状态</th>
						<th>操作</th>
					</tr>
					
                                        @foreach ($paginator as $value)
					<tr>
						<td>{{ $value['wx_name'] }}</td>
						<td>{{ $value['commit_time'] }}</td>
						<td>{{ $value['w_total_fans'] }}</td>
						<td>{{ $value['w_per_price'] }}</td>
                                                <td>{{ $value['nick_name'] }}</td>
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
                                                <td>
                                                   @if ($value['w_status']  === 1)
                                                        <span  class="colour_1">审核中</span>
                                                    @elseif ($value['w_status']  === 3)
                                                        <span  class="colour_2">审核失败</span>
                                                    @elseif ($value['w_status'] === 2)
                                                        <span class="colour_3">审核通过</span>
                                                    @elseif ($value['w_status'] === 4)
                                                        <span class="colour_3">已关闭</span>
                                                    @else
                                                        已生成订单
                                                    @endif
                                                    
                                                </td>
						<td>
<!--							<button text="{{ $value['id'] }}" class="btn                      
                                                    @if ($value['w_status']  === 1)
                                                        btn-red return" 
                                                    @else
                                                        btn-grey return" disabled
                                                    @endif >驳回</button>
							<button text="{{ $value['id'] }}" class="btn                      
                                                    @if ($value['w_status']  === 1)
                                                        btn-blue audit" 
                                                    @else
                                                        btn-grey " disabled
                                                    @endif >通过</button>-->
							<button text="{{ $value['id'] }}" class="btn btn-yellow calloff" >详情</button>

						</td>
					</tr>
                                        @endforeach
				</table>
				{{ $paginator ->appends(array('gzh'=>$gzh,'startDate'=>$startDate,'endDate'=>$endDate,'stat'=>$stat,'action'=>$action,'user'=>$userid))->render() }}
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
					<button class="btn btn-cancel">取消</button>
					<button class="btn btn-sure">确定</button>
				</div>
			</div>
		</div>
                
                <form action="postWorkReject?stat=1&new=2" method="post" id="f-reason">
                    <div class="cause" style="display: none;">
                            <div class="mask"></div>
                            <div class="causeMain">
                                    <p>驳回原因</p>
                                    <textarea name="reason"></textarea>
                                    <span class="tip causeTip">原因必填</span>
                                     <input type="type" name="wid" value="" id="wid" style="display: none"/>
                                    <div class="causebtn">
                                        <input type="submit" name="sub" value="111" style="display: none"/>
                                        <input type="hidden" name="_token"         value="{{  csrf_token()  }}"/>
                                            <input type="button" value="取消" class="cancel" />
                                            <input type="button" value="确认" class="sure"/>
                                    </div>
                            </div>
                    </div>
                </form>
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
		$(".reset").click(function () {
			window.location.href = 'getworkorderlist';
		})
	</script>
</html>
