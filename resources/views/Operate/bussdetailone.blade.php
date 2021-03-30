<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>增粉统计报表</title>
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
                            @if($bussname!='')
                            <div class="header" style="border-bottom: 1px solid #ccc;">所属渠道：{{$bussname}}</div>
                            @endif
				<form action="" method="get" class="form-inline" role="form" id="f-report">
					
					<div class="form-group position">
					    <label>
					    	公众号：				    	
					    </label>
<!--					    <select name="wxid" class="form-control">
					    	<option value="">全部</option>
                                                @if(isset($paginator))
                                                    @foreach ($paginator as $key => $datalist)
                                                        <option value="{{$datalist['wx_id']}}"
                                                                @if($termarray['wx_id']==$datalist['wx_id'])
                                                                selected
                                                                @endif
                                                                >{{$datalist['wx_name']}}</option>
                                                    @endforeach
                                                @endif
					    </select>-->
                                            <input type="text" id="inputgzh" hidden name="wxid" class="form-control" style="display: none" value="{{ $termarray['wx_id'] }}">
                                            <input type="text" id="inputv" onkeyup="checkFunction()" name="wxName"  class="form-control" autocomplete="off" value="{{ $termarray['wxname'] }}">
                                                    <ul id="ul_hide">
                                                        @if(isset($paginator))
                                                            @foreach ($paginator as $key => $datalist)  
                                                            <li class="option_obj" style="display: none;" tit="{{$datalist['wx_id']}}">{{$datalist['wx_name']}}</li>
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
						<label class="datelabel">选择时间：<input type="text" name="startdate" class="form-cDateontrol date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="enddate" class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
                                    <input type="text" value="{{ $termarray['bussid'] }}" hidden="" name="bussid"/>	
                                    <input type="text" value="{{ $termarray['parentid'] }}" hidden="" name="parentid"/>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
			@if(isset($paginator))	
			@foreach ($paginator as $key => $datalist)	
				<!--单个公众号-->
				<table class="table-bordered table-responsive table-striped detail colspan-8">
					<tr>
						<th>公众号</th>
						<th>日期</th>
						<th>成功关注</th>
						<th>当日取关量</th>
						<th>当日取关率</th>
						<th>取关量</th>
						<th>取关率</th>
						
					</tr>
					<tr>
						<td rowspan="999">{{$datalist['wx_name']}}</td>
						<td>{{$datalist['wx_name']}}</td>
						<td>{{$datalist['nowfollow']}}</td>
						<td>{{$datalist['unnowfollow']}}</td>
						<td>{{$datalist['unnowfollowrate']}}%</td>
						<td>{{$datalist['unfollow']}}</td>
						<td>{{$datalist['unfollowrate']}}%</td>
					</tr>
                                        @if(isset($datalist['list'])&&$datalist['list']!=null)
                                            @foreach ($datalist['list'] as $datasonlist)
                                            <tr>
                                                    <td>{{$datasonlist['datetime']}}</td>
                                                    <td>{{$datasonlist['nowfollow']}}</td>
                                                    <td>{{$datasonlist['unnowfollow']}}</td>
                                                    <td>{{$datasonlist['unnowfollowrate']}}%</td>
                                                    <td>{{$datasonlist['unfollow']}}</td>
                                                    <td>{{$datasonlist['unfollowrate']}}%</td>
                                            </tr>
                                            @endforeach
                                        @endif
				</table>

			@endforeach
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
			
			
			
			//渠道统计报表子渠道缩略
			$('table').delegate('.f_channel','click',function(){
				var $this=$(this);
				var code=$this.attr('channelId');
				var $sub=$('.sub_channel[fatherId="'+code+'"]')
				if($sub.length>0){
					if($sub.is(':hidden')){
						$sub.show();
						$this.addClass('on_channel').removeClass('off_channel');
					}else{
						$sub.hide();
						$this.addClass('off_channel').removeClass('on_channel');
					}
				}
			})
		    
		    
                        $('.find').click(function(){
                            var startDate = new Date($('#datetimeStart').val()).getTime()
                            var endDate = new Date($('#datetimeEnd').val()).getTime()
                            var delta=parseInt((endDate-startDate)/1000/60/60/24);
                            if(delta>29){
                                    alert('数据太多啦，请导出Excel查看');
                                    return;
                            }
                            if($('.form-control').val()>0||$('#inputv')!=''){
                                var path = "getBussOneDetail";  
                                $('.form-inline').attr("action", path).submit();
                            }else{
                                var path = "getBussDetail";  
                                $('.form-inline').attr("action", path).submit();
                            }
                        })
                        $('.excel').click(function(){
                            $('.form-inline').attr("action", 'getBussDetailExcel').submit();
                        })
                    $("#datetimeStart").val("{{ $termarray['startdate'] }}");
                    $("#datetimeEnd").val("{{ $termarray['enddate'] }}");
                    
                    $(".reset").click(function () {
                            window.location.href = 'getBussDetail';
                    })
		})
	</script>
</html>
