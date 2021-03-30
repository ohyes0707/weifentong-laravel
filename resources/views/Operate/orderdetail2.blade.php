<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>订单列表</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<div class="header">生成订单</div>
				<div class="detail-box">
					<div class="title">订单详情</div>
					<div class="detail-con clearfix">
						<div class="col-sm-4">
							<span class="dlabel">总涨粉量：</span>
							<span class="data fansdata">{{$data['w_total_fans']}}</span>
						</div>
						<div class="col-sm-4">
							<span class="dlabel">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</span>
							<span class="data">{{$data['w_per_price']}}</span>
						</div>
						<div class="col-sm-4 area">
							<span class="dlabel">热点区域：</span>
							@if($data['hot_area'])
								<div class="data">{{$data['hot_area']}}</div>
							@else
								<div class="data">不限</div>
							@endif
						</div>
						<div class="col-sm-4">
							<span class="dlabel">每日涨粉：</span>
							<div class="subdata">
								<p class="data">
									<span>保底量</span> <span>{{$data['w_least_fans']}}</span>
								</p>
								<p class="data">
									<span>最高量</span> <span>{{$data['w_max_fans']}}</span>
								</p>
								<p class="data">
									<span>建议量</span> <span>{{$data['w_advis_fans']}}</span>
								</p>
							</div>
						</div>
						<div class="col-sm-4">
							<span class="dlabel">投放时间：</span>
							@if($data['w_start_date']=='')
								不限
							@else
								<span class="data">{{$data['w_start_date']}} 至 {{$data['w_end_date']}}</span>
							@endif
						</div>
						<div class="col-sm-4 area">
							<span class="dlabel">属性区域：</span>
							@if($data['fans_tag'])
								<div class="data">{{$data['fans_tag']}}</div>
							@else
								<div class="data">不限</div>
							@endif
						</div>
						<div class="col-sm-4">
							<span class="dlabel">投放时段：</span>
							@if($data['w_start_time']=='')
								不限
							@else
								<span class="data">{{$data['w_start_time']}}至{{$data['w_end_time']}}</span>
							@endif
						</div>
						<div class="col-sm-4 area">
							<span class="dlabel">场&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;景：</span>
							@if($data['scene'])
								<div class="data">{{$data['scene']}}</div>
							@else
								<div class="data">不限</div>
							@endif
						</div>
						<div class="col-sm-4">
							<span class="dlabel">性别属性：</span>
							<span class="data">
								@if($data['sex']==1)
									男
								@elseif($data['sex']==2)
									女
								@else
									不限
								@endif
							</span>
						</div>
					</div>
				</div>
				
				<form action="" method="post" class="f_order">
					{{csrf_field()}}
					<input type="hidden" name="order_id" value="{{$order_id}}"/>
					<input type="hidden" name="work_id" value="{{$work_id}}"/>
					<div class="channel-box">
						<div class="b-title">渠道选择</div>
						<div class="channel-select clearfix">
							<span class="present">当前选择：</span>
							<a href="javascript: void(0)" class="clear">[清空已选]</a>
							<div class="taglist">
								<input name="tags" id="tags" value="" style="display: none;"/>
							</div>
						</div>
						<div class="channel-input">
							<input class="form-control" readonly type="text" placeholder="请选择渠道" id="city-picker"/>
						</div>
					</div>
					<div class="topbtn clearfix">
						<input type="button" class="btn btn-red btn-stop" value="全部暂停"/>
						<input type="button" class="btn btn-blue btn-open" value="全部开启"/>
					</div>
					<table class="table table-bordered">
						<tr class="t-head">
							<td class="ghname">新世相</td>
							<th>渠道选择</th>
							<th>总涨粉</th>
							<th>日涨粉</th>
							<th>渠道操作</th>
							<th>已涨粉总量</th>
							<th>当日涨粉量</th>
						</tr>
					</table>
					<div class="bottombtn">
						<input type="submit" value="提交" class="btn btn-blue"/>
						<input type="button" value="取消" class="btn btn-grey"/>
						<input type="button" value="关闭" class="btn btn-red orderclose"/>
					</div>
				</form>
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
	</body>
	<script type="text/javascript">
		$(function(){
			
			var $citypicker=new CityPicker($('#city-picker'),
				{
					ChineseDistricts:ChineseDistricts,
					nodistrict: true,
				})
			
			
			$('#tags').tagsInput({
				width: 'auto',
				height: '38px',
				onAddTag:function(tag){
				 	var $head=$('.t-head');
				 	if(tag.indexOf('/') == -1){
				 		var code;
				 		var added=true;
				 		$.each(ChineseDistricts[86],function(i,a){
							if(tag == a){
								code=i;
							}
						})
				 		$('.parent').each(function(){
				 			if($(this).data('code') == code){
				 				added=false;
				 				return false;
				 			}
				 		})
				 		if(added){
				 			$head.after('<tr data-code="'+code+'" title="'+tag+'" class="parent open"><td class="toggle">'+tag+'</td><td class="inputtd"><input type="number" name="buss_total_fans['+code+']" class="alladd"/><input type="hidden" name="p_buss['+code+']" value="0" ></td><td class="inputtd"><input type="number" name="buss_day_fans['+code+']" class="dayadd"/></td><td><select name="task_status['+code+']"><option value="2" class="stop">暂停</option><option value="1" class="start">开启</option></select></td><td></td><td></td></tr>');
				 		}else{
				 			
				 		}
				 		
				 		
				 	}else{
				 		var arr=tag.split('/');
				 		var fcode,scode;
				 		var added=true;
				 		$.each(ChineseDistricts[86],function(i,a){
							if(arr[0] == a){
								fcode=i;
							}
						})
				 		$.each(ChineseDistricts[fcode],function(i,a){
							if(arr[1] == a){
								scode=i;
							}
						})
				 		$('.parent').each(function(){
				 			if($(this).data('code') == fcode){
				 				added=false;
				 				return false;
				 			}
				 		})
				 		if(added){
				 			var $ftag='<tr data-code="'+fcode+'" title="'+arr[0]+'" class="parent open"><td class="toggle">'+arr[0]+'</td><td class="inputtd"><input type="number" name="111[]" class="alladd"/></td><td class="inputtd"><input type="number" name="222[]" class="dayadd"/></td><td><select name="task_status['+fcode+']"><option value="2" class="stop">暂停</option><option value="1" class="start">开启</option></select></td><td></td><td></td></tr><tr data-code="'+scode+'" title="'+arr[1]+'" data-fcode="'+fcode+'" class="subset"><td>'+arr[1]+'</td><td class="inputtd"><input type="number" class="alladd"/></td><td class="inputtd"><input type="number" class="dayadd"/></td><td><select name="task_status['+code+']"><option value="2" class="stop">暂停</option><option value="1" class="start">开启</option></select></td><td></td><td></td></tr>';
				 			$head.after($ftag);
				 		}else{
							$('.parent[title='+arr[0]+']').after('<tr data-code="'+scode+'" title="'+arr[1]+'" data-fcode="'+fcode+'" class="subset"><td>'+arr[1]+'</td><td class="inputtd"><input type="number" name="buss_total_fans['+scode+']" class="alladd"/><input type="hidden" name="p_buss['+scode+']" value="'+fcode+'" ></td><td class="inputtd"><input type="number" name="buss_day_fans['+scode+']" class="dayadd"/></td><td><select name="task_status['+scode+']"><option value="2" class="stop">暂停</option><option value="1" class="start">开启</option></select></td><td></td><td></td></tr>')
				 		}
				 		
				 	}
				},
				onRemoveTag:function(tag){
        			if(tag.indexOf('/') == -1){
        				var code;
				 		$.each(ChineseDistricts[86],function(i,a){
							if(tag == a){
								code=i;
							}
						})
				 		if(ChineseDistricts[code]){
							$('.subset[data-fcode="'+code+'"]').each(function(){
								$(this).remove();
								$('#tags').removeTag(tag+'/'+$(this).attr('title'));
							});
							
						}
				 		$('.parent[data-code="'+code+'"]').remove();
				 		addSum()
        			}else{
        				var j=true;
        				var arr=tag.split('/');
        				var code=$('.subset[title="'+arr[1]+'"]').data('fcode');
        				$('.subset[title="'+arr[1]+'"]').remove();
        				$('.subset').each(function(){
        					if($(this).attr('data-fcode') == code){
        						j=false;
        						return false;
        					}
        				})
        				if(j){
        					
        					var title=$('.parent[data-code="'+code+'"]').attr('title');
        					$('.parent[data-code="'+code+'"]').remove();
        					addSum()
        					if($('#tags').tagExist(title)){
        						$('#tags').removeTag(title);
        					}
        				}
						addSum()
        			}
   			 	}
			});
			$('#tags_tag').hide();
			
		})
		$(".btn-open").click(function(){
			$(".stop").prop('selected',false)
			$(".start").prop('selected',true);
		})
		$(".btn-stop").click(function(){
			$(".start").prop('selected',false)
			$(".stop").prop('selected',true);
		})
	</script>
</html>
