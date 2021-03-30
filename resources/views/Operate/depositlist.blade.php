<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>提现列表</title>
		@include('Operate.common.head')	
                <link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/statistics.css') }}"/>
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
					<div class="form-group position">
					    <label>
					    	商户名称：
					    </label>
						@if($subShop!=0)
							@if(isset($name_list) && !empty($name_list) )
							    @foreach ($name_list as $key => $namelist)
									@if(isset($subShop) && $subShop==$namelist['id_list'])
										<input type="text" id="inputv" onkeyup="checkFunction()" name="shopName" class="form-control" value="{{$namelist['name_list']}}">
									@endif
								@endforeach
						    @endif
						@else
							<input type="text" id="inputv" onkeyup="checkFunction()" name="shopName" class="form-control" >
						@endif
					    
					    <input type="text" id="inputd" style="display: none" name="buss_id" class="form-control">
					    <ul id="ul1">
					    	@if(isset($name_list) && !empty($name_list) )
							    @foreach ($name_list as $key => $namelist)
									<li class="wxname_chose" value="{{$namelist['id_list']}}" style="display: none;">{{$namelist['name_list']}}</li>
								@endforeach
						    @endif
					    </ul>
					</div>
					<script>
                            $(".wxname_chose").click(function(){
                                var wxname = $(this).text();
								var wx_val = $(this).val();
                                $("#inputv").val(wxname);
                                $("#inputd").val(wx_val);
                                $(".wxname_chose").hide();
                            })

                            function checkFunction(){
                                var inputv,filter,ul,li,a,i;
                                inputv = document.getElementById('inputv');
                                filter = inputv.value.toUpperCase();
                                ul =  document.getElementById('ul1');
                                li = ul.getElementsByTagName('li');

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

					<div class="form-group">
					    <label>
					    	提现状态：					    	
					    </label>
					    <select name="state" class="form-control">
					    	<option  value="0">全部</option>
							@if(isset($state) && $state==1)
								<option selected value="1">已打款</option>
							@else
								<option  value="1">已打款</option>
							@endif
							@if(isset($state) && $state==2)
								<option selected value="2">审核失败</option>
							@else
								<option  value="2">审核失败</option>
							@endif

							@if(isset($state) && $state==4)
								<option selected value="4">未审核</option>
							@else
								<option  value="4">未审核</option>
							@endif
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startdate" class="form-control date" @if(isset($startDate))value="{{$startDate}}"@endif id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="enddate" class="form-control date" @if(isset($endDate))value="{{$endDate}}"@endif id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail colspan-8" id="reportTable">
					<tr>
						<th>时间</th>
						<th>商户</th>
						<th>提现金额</th>
						<th>提现方式</th>
						<th>提现姓名</th>
						<th>提现账号</th>
						<th>提现状态</th>
						<th>操作</th>
					</tr>
					@if(isset($paginator) && !empty($paginator))
						@foreach ($paginator as $key => $datalist)
							@if(isset($datalist) && !empty($datalist))
							<tr>
								<td>{{date('Y-m-d',strtotime($datalist['create_date']))}}</td>
								<td>{{$datalist['username']}}</td>
								<td>{{$datalist['op_money']}}</td>
								@if ($datalist['tixian_type'] == 1)
							        <td>银行卡</td>
							    @elseif ($datalist['tixian_type'] == 0)
							    	<td>支付宝</td>
							   	@endif
								<td>{{$datalist['real_name']}}</td>
								<td>{{$datalist['tixian_account']}}</td>
								@if ($datalist['status'] == 1)
							        <td class="green">已打款</td>
							        <td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}">查看</a></td>
							    @elseif ($datalist['status'] == 2)
							    	<td class="red">审核失败</td>
							    	<td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}">查看</a></td>
							    @elseif ($datalist['status'] == 4)
							    	<td class="yellow">未审核</td>
							    	<td class="look"><a href="withdrawLook?lid={{$datalist['sid']}}" class="btn btn-blue">审核</a></td>
							    @endif
								
							</tr>
							@endif
						@endforeach
					@endif

				</table>
				@if(isset($paginator) && !empty($paginator))
				{{ $paginator->appends($termarray)->render() }}
				@endif

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
		    
			//左边列表栏缩略
			$('.sub_file').click(function(){
				var $this=$(this);
				var $list=$this.find('.sub_list')
				if($list.is(':hidden')){
					$list.show();
					$this.addClass('on_file').removeClass('off_file');
					$this.find('.sub_close').hide().siblings('.sub_open').show()
				}else{
					$list.hide();
					$this.addClass('off_file').removeClass('on_file');
					$this.find('.sub_close').show().siblings('.sub_open').hide()
				}
			})
			
		    $(".reset").click(function(){
				window.location.href='depositlist';
			})
		    
		})
	</script>
</html>
