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
<!--			@include('Operate.common.left')-->
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="get" class="form-inline" role="form" id="f-report">
					<div class="r_form clearfix">
						<div class="f_radio">
							<a href="javascript: void(0)" class="on_radio">公众号</a>
							<a href="fansStatistics1.html">渠道</a>
						</div>
					</div>
					
					<div class="form-group">
					    <label>
					    	公众号：				    	
					    </label>
					    <select name="gzh" class="form-control">
					    	<option value="0">全部</option>
					    	<option value="1">数芳科技</option>
					    	<option value="2">酒店</option>
					    	<option value="3">爱上网</option>
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	用户选择：				    	
					    </label>
					    <select name="user" class="form-control">
					    	<option value="0">全部</option>
					    	<option value="1">新用户</option>
					    	<option value="2">老用户</option>
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" readonly /></label>
						
					</div>
					<input type="submit" value="查询" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<!--全部公众号-->
				<table class="table-bordered table-responsive table-striped detail init-table colspan-8">
					<tr>
						<th>公众号</th>
						<th>成功关注</th>
						<th>当日取关量</th>
						<th>当日取关率</th>
						<th>微信关注</th>
						<th>取关量</th>
						<th>取关率</th>
						<th>操作</th>
					</tr>
					<tr class="f_channel off_channel" channelId="1">
						<td>公众号1（汇总）</td>
						<td>910</td>
						<td>455</td>
						<td>50%</td>
						<td>198</td>
						<td>52</td>
						<td>57.69%</td>
						<td><a href="fansDetail.html" class="option_detail">查看详情</a></td>
					</tr>
					<tr class="sub_channel" fatherId="1">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="sub_channel" fatherId="1">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="sub_channel" fatherId="1">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="sub_channel" fatherId="1">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="f_channel off_channel" channelId="2">
						<td>公众号2（汇总）</td>
						<td>910</td>
						<td>455</td>
						<td>50%</td>
						<td>198</td>
						<td>52</td>
						<td>57.69%</td>
						<td><a href="fansDetail.html" class="option_detail">查看详情</a></td>
					</tr>
					<tr class="sub_channel" fatherId="2">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="sub_channel" fatherId="2">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="sub_channel" fatherId="2">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr class="sub_channel" fatherId="2">
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
				</table>
				
				
				<!--单个公众号-->
				<table class="table-bordered table-responsive table-striped detail colspan-9">
					<tr>
						<th>公众号</th>
						<th>日期</th>
						<th>成功关注</th>
						<th>当日取关量</th>
						<th>当日取关率</th>
						<th>微信关注</th>
						<th>取关量</th>
						<th>取关率</th>
						<th>操作</th>
					</tr>
					<tr>
						<td rowspan="999">公众号2</td>
						<td>汇总</td>
						<td>910</td>
						<td>455</td>
						<td>50%</td>
						<td>198</td>
						<td>52</td>
						<td>57.69%</td>
						<td><a href="fansDetail.html" class="option_detail">查看详情</a></td>
					</tr>
					<tr>
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr>
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
					<tr>
						<td>2017-6-29</td>
						<td>100</td>
						<td>50</td>
						<td>50%</td>
						<td>98</td>
						<td>60</td>
						<td>60%</td>
						<td></td>
					</tr>
				</table>
				
<!--				@foreach ($paginator as $user)
                                    @foreach ($user['list'] as $hhd)
                                    3
                                    @endforeach
                                @endforeach-->
				{{ $paginator->appends($termarray)->render() }}
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
		    
		    
		})
	</script>
</html>
