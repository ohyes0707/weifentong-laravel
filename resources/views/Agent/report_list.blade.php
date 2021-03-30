<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>报备详情</title>
		@include('Home.common.head')
		<style>
			.shopMain{
				position: fixed;
				top: 50%;
				left: 50%;
				z-index: 10000;
				background: #fff;
				width: 750px;
				height: 500px;
				margin-left: -375px;
				margin-top: -250px;
				border-radius: 8px;
				color: #999;
				font-size: 16px;
			}
			.shopMain p{
				color: #333;
				padding: 50px 0 0 100px;
			}
			.shopMain select{
				width: 160px;
				height: 30px;
				margin-left: 100px;
				padding: 0;
			}
			.shopbtn{
				text-align: center;
				margin-top: 280px;
			}
			.shopbtn .btn{
				width: 114px;
				height: 34px;
				padding: 0;
				color: #fff;
				margin: 0 10px;
			}
			.shopbtn .finishbtn{
				background: #3EA9F5;
			}
			.shopbtn .closebtn{
				background: #fff;
				color: #999;
				border: 1px solid #ccc;
			}
			.causeTip{
				padding-left: 42px;
			}
		</style>
	</head>
	<body>
	 	@include('Agent.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		@include('Agent.common.left')
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
					<a class="add" href="{{URL::asset('index.php\agent\report\addreport')}}">+ 新增报备</a>

					
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
							@if($v['status']==4 || $v['status']==3)
								<button class="btn btn-grey" disabled>授权</button>
								<button type="button" lid="{{$v['id']}}" class="btn btn-blue shop">门店</button>
							@else
								<button class="btn btn-blue authrize" l_id="{{$v['id']}}">授权</button>

							@endif
						</td>
					</tr>
                    @endforeach
				</table>
                {{ $paginator ->appends($post)->render() }}

            </div>
		</div>
		<div class="shopSelect" style="display: none;">
			<input type='hidden' name='wx_id' value=''/>
			<div class="mask"></div>
			<div class="shopMain">
				<p>请选择用于涨粉的场景（门店）</p>
				<select name="shop" id="addshop" class="form-control">
				</select>
				<div class="shopbtn">
					<input type="button" value="完成准备工作" onclick="submitinfo()" class="btn finishbtn"/>
					<input type="button" value="关闭" class="btn closebtn"/>
				</div>
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


			$('.closebtn').click(function () {
				$('.shopSelect').hide()
			})

			//授权动作
			$('.authrize').click(function () {
				var rid = $(this).attr('l_id');
				window.location.href = "{{ URL::asset('index.php/agent/authrize') }}" + "?rid=" + rid; //暂时如此;
			})

			$('.shop').click(function () {

				var rid = $(this).attr('lid');

				$.getJSON("{{URL::asset('index.php/agent/shop')}}"+'?rid='+rid,function(res){
					if(res.data != 'null'){
						$(".shopSelect").css('display', 'block');
						$("#addshop").empty();
						$.each(res.data.list, function (i, v) {
							$("#addshop").append("<option class='data' value='" + v.shop_id + "'>" + v.shop_name + '</option>');
						});

						$('input[name=wx_id]').val(res.data.agentwxid)


					}else{

						alert('暂时没有门店信息');
					}
				});

			})

		})


		function submitinfo () {
			var wxid = $('input[name=wx_id]').val();
			var shop_id = $(".shopSelect").find("option:selected").val();
			var shop_name = $(".shopSelect").find("option:selected").text();

			$.getJSON("{{ URL::asset('index.php/agent/set_default') }}" + "?shopid=" + shop_id + "&shopname=" + shop_name + '&wxid=' + wxid, function (res) {
				if (res.data.data == 1) {
					$(".shopSelect").css('display', 'none');
				} else {
					alert('门店修改失败啦');
				}
			});
		}
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
		
		function selectItem(){
			var str='';
			var items=$('td input[type=checkbox]:checked');
			console.log(items)
			items.each(function(){
				var $text=$(this).parents('tr').find('td').eq(2).text();
				str+='<span>'+$text+'</span>'
			})
			return str;
		}
	</script>
        
</html>
