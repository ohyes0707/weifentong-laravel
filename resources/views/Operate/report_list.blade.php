<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>报备列表</title>
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
                    {!! csrf_field() !!}
					<div class="form-group position">
					    <label>
					    	公众号：
					    </label>
                        <input type="text" id="inputv" onkeyup="checkFunction()" name="wxName" class="form-control" value="@if(isset($post['wxName'])){{$post['wxName']}}@endif">
                        <ul id="ul_hide">
                            @foreach($wxlist as $v)
                            <li class="option_obj" style="display: none;">{{$v['wx_name']}}</li>
                            @endforeach
                        </ul>
                        <script>
                            $(".option_obj").click(function(){
                                var wxname = $(this).text();
                                $("#inputv").val(wxname);
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
{{--                        <select name="wxName" class="form-control">
                            <option value="">全部</option>
                            @foreach($wxlist as $v)
                                <option  @if(isset($post['wxName'])&&($v['wx_name']==$post['wxName']))selected="selected"@endif value="{{$v['wx_name']}}">{{$v['wx_name']}}</option>
                            @endforeach
                        </select>--}}
					</div>
                    <div class="form-group">
                        <label>
                            销售代表：
                        </label>
                        <input type="text" name="username" class="form-control" value="@if(isset($post['username'])){{$post['username']}}@endif">
                    </div>
					<div class="form-group">
                        <label class="datelabel">选择时间：
                            @if(isset($post['startDate']))
                                <input type="text" name="startDate" value="{{$post['startDate']}}" class="form-control date" id="datetimeStart" readonly />
                            @else
                                <input type="text" name="startDate" value="" class="form-control date" id="datetimeStart" readonly />
                            @endif
                        </label>
                        <label class="datelabel">至&nbsp;
                            @if(isset($post['endDate']))
                                <input type="text" name="endDate" value="{{$post['endDate']}}" class="form-control date" id="datetimeEnd" readonly />
                            @else
                                <input type="text" name="endDate" value="" class="form-control date" id="datetimeEnd" readonly />
                            @endif
                        </label>
					</div>
					<div class="form-group">
					    <label>
                            报备状态：
					    </label>
                        <select name="state" class="form-control">
                            <option value="0">全部</option>
                            @if(isset($post['state']) && $post['state']==1)
                                <option selected value="1">申请中</option>
                            @else
                                <option value="1">申请中</option>
                            @endif
                            @if(isset($post['state']) && $post['state']==2)
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
				</form>
				<table class="table table-bordered table-responsive table-striped detail" id="reportTable">
					<tr>
						<th>公众号</th>
						<th>申请时间</th>
						<th>公司名称</th>
						<th>联系人</th>
						<th>联系方式</th>
						<th>销售代表</th>
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
                            <td>{{$v['user_name']}}</td>
                            @if($v['status']==1)
                                <td class="colour_1">申请中</td>
                            @elseif($v['status']==2)
                                <td class="colour_2">授权失败</td>
                            @elseif($v['status']==3)
                                <td class="colour_3">未下单</td>
                            @elseif($v['status']==4)
                                <td class="colour_3">报备成功</td>
                            @endif

                            <td>

                            @if(($v['status']==1||$v['status']==2) && $v['type']==1)
                            <button  act="pass" l_id="{{$v['id']}}" class="btn btn-blue authrize">授权</button>
                            @elseif(($v['status']==1||$v['status']==2) && $v['type']==2)
                            <button  act="pass" l_id="{{$v['id']}}" class="btn btn-blue shop">门店</button>
                            @elseif(($v['status']==3||$v['status']==4) && $v['type']==1)
                            <button class="btn btn-grey authrize" disabled>授权</button>
                            @else
                            <button class="btn btn-grey shop" disabled>门店</button>
                            @endif
                            </td>

                        </tr>
                    @endforeach
				</table>
                {{ $paginator ->appends($post)->render() }}
			</div>
		</div>
		
		{{--<div class="myalert" style="display: none;">--}}
			{{--<div class="mask"></div>--}}
			{{--<div class="alertbox">--}}
				{{--<a href="#" class="close">&times;</a>--}}
				{{--<div class="alertHead">提示</div>--}}
				{{--<div class="alertMain">--}}
					{{--请确认是否授权该报备信息？--}}
				{{--</div>--}}
				{{--<div class="alertbtn">--}}
					{{--<button class="btn btn-cancel">取消</button>--}}
					{{--<button class="btn btn-sure">确定</button>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}

		<input id="open" style="display: none" value="{{$isopen}}"/>
		<input id="wxid" style="display: none" value="{{$wxid}}"/>

	<div class="shopSelect" style="display: none;">
		<div class="mask"></div>
		<div class="shopMain">
			<p>请选择用于涨粉的场景（门店）</p>
			<select name="shop" class="form-control">
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
			$('.closebtn').click(function(){
				$('.shopSelect').hide()
			})

			//重置
            $(".reset").click(function(){
                window.location.href = '{{ URL::asset('index.php/operate/report/reportlist') }}';
            })

			//获取广告

			if($('#open').val() == 'open')
			{

				var wxid = $('#wxid').val()
				$.getJSON("{{ URL::asset('index.php/home/report/getShopInfo') }}"+"?wxid="+wxid, function (res) {

					if(res.data!='null')
					{
						$(".shopSelect").css('display','block');
						$.each(res.data,function(i,v){

							$(".form-control").append("<option class='data' value='"+v.shop_id+"'>"+v.shop_name+'</option>');
						});
					}else {

						alert('暂时没有门店信息');
					}


				})
			}

			if($('#open').val() == 'error'){

				alert('报备公众号与授权公众号名字不一致');

			}

			if($('#open').val() == 'limit'){

					alert('平台缺少必要权限');

			}



		})



		function submitinfo (){
			var wxid = $('#wxid').val()
			var shop_id = $(".shopSelect").find("option:selected").val();
			var shop_name = $(".shopSelect").find("option:selected").text();

			$.getJSON("{{ URL::asset('index.php/home/report/set_default') }}"+"?wxid="+wxid+"&shopid="+shop_id+"&shopname="+shop_name,function(res){
				if(res.data.data == 1)
				{
					$(".shopSelect").css('display','none');
				}else{
					alert('门店修改失败啦');
				}
			});
		}

        //授权类型操作
		$('.authrize').click(function(){
			var rid =  $(this).attr('l_id');
            var url = "{{$url}}";
			window.location.href = "{{ URL::asset('index.php/home/report/addauth') }}"+"?url="+url+"&rid="+rid; //暂时如此;
		})


        //无授权门店类型公众号操作
        $(".shop").click(function(){
            var rid =  $(this).attr('l_id');
            var wx_name  = $($(this).parent().parent().find('td')[0]).text();
            window.location.href = "{{ URL::asset('index.php/operate/report/addauthByShop') }}"+"?rid="+rid+"&wxname="+wx_name;
        })
	</script>
</html>
