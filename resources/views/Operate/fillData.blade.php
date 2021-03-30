<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>数据回填</title>
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
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startdate" class="form-control date" id="datetimeStart" @if(isset($startdate))value="{{$startdate}}"@endif readonly /></label>
						
						<label class="datelabel">至&nbsp;<input type="text" name="enddate" class="form-control date" @if(isset($enddate))value="{{$enddate}}"@endif id="datetimeEnd" readonly /></label>
						
					</div>
					<div class="form-group">
					    <label>
					    	状态：					    	
					    </label>
					    <select name="state" class="form-control">
					    	<option value="0">全部</option>
					    	<option value="1">未回填</option>
					    	<option value="2">已回填</option>
					    </select>						    
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
				</form>
				<table class="table-bordered table-responsive table-striped detail init-table colspan-4">
					<tr>
						<th>日期</th>
						<th>状态</th>
						<th>数量</th>
						<th>操作</th>
					</tr>
					@if(isset($paginator) && !empty($paginator))
						@foreach ($paginator as $key => $datalist)
							@if(isset($datalist['date_time']))
							<tr class="f_channel off_channel" channelId="{{$datalist['id']}}">
								<td>{{$datalist['date_time']}}</td>
								<input class="datetime" name="datetime" type="hidden" value="{{$datalist['date_time']}}" />
								@if(isset($datalist['list']) && !empty($datalist['list']))
									@if (empty($datalist['list'][0]['sum_number']))
										<td>未回填</td>
										<td>/</td>
										<td>
											<button class="btn btn-blue edit-btn" >编辑</button>
											<button class="btn btn-grey look-btn" disabled>查看详情</button>
										</td>
									@else
										<td class="green">已回填</td>
										<td>{{$datalist['sum']}}</td>
										<td>
											<button class="btn btn-grey edit-btn" disabled>编辑</button>
											<button class="btn btn-blue look-btn" >查看详情</button>
										</td>
									@endif
								@endif
							</tr>
							@endif
							@if(isset($datalist['list']) && !empty($datalist['list']))
								@foreach($datalist['list'] as $kk=>$vv)
									@if (empty($vv['sum_number']))
										<tr class="sub_channel" fatherId="{{$datalist['id']}}">
											<td>{{$vv['wx_name']}}</td>
											<td>未回填</td>
											<td>/</td>
											<td></td>
										</tr>
									@else
										<tr class="sub_channel" fatherId="{{$datalist['id']}}">
											<td>{{$vv['wx_name']}}</td>
											<td class="green">已回填</td>
											<td>{{$vv['sum_number']}}</td>
											<td></td>
										</tr>
									@endif
								@endforeach
							@endif
						@endforeach
					@endif
				</table>
				{{ $paginator->appends($termarray)->render() }}
			</div>
		</div>
		
		<div class="fillAlert" style="display: none;">
			<div class="mask"></div>
			<div class="fillMain">
				<a href="javascript: void(0)" class="close">&times;</a>
				<form action="backedit" method="post" id="fillForm">
				{{csrf_field()}}
					<div class="amountData">
						<!-- <dl class="ghList">
							<dt class="gh-name">公众号1：</dt>
							<dd class="ghItems">
								<dl>
									<dt>数量</dt>
									<dd><input type="text" name="amount" class="f-input"/></dd>
								</dl>
								<dl>
									<dt>渠道1占比</dt>
									<dd><input type="text" name="amount" class="f-input p-input"/>%</dd>
								</dl>
								<dl>
									<dt>渠道2占比</dt>
									<dd><input type="text" name="amount" class="f-input p-input"/>%</dd>
								</dl>
							</dd>
						</dl>
						
						<dl class="ghList">
							<dt class="gh-name">公众号1：</dt>
							<dd class="ghItems">
								<dl>
									<dt>数量</dt>
									<dd><input type="text" name="amount" class="f-input"/></dd>
								</dl>
								<dl>
									<dt>渠道1占比</dt>
									<dd><input type="text" name="amount" class="f-input p-input"/>%</dd>
								</dl>
								<dl>
									<dt>渠道2占比</dt>
									<dd><input type="text" name="amount" class="f-input p-input"/>%</dd>
								</dl>
							</dd>
						</dl> -->
					</div>
					
					<div class="fill-btns" id="hideBtn">
						<input type="button" value="提交" class="fill-sub" id="sub1"/>
						<input type="button" value="取消" class="fill-cancel" id="cancel1"/>
					</div>
					<div class="makeSure" style="display: none;">
						<p class="disChange">提交后将不可更改，请确定是否提交？</p>
						<div class="fill-btns">
							<input type="submit" value="确定" class="fill-sub" id="sub2"/>
							<input type="button" value="取消" class="fill-cancel" id="cancel2"/>
						</div>
					</div>
				</form>
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
		    
		    $('.shop').click(function(){
				window.location.href="addShop.html"
			})
		    $(".reset").click(function(){
				window.location.href='backfilllist';
			})
		   
			
			//渠道统计报表子渠道缩略
			$('table').delegate('.f_channel','click',function(){
				var $this=$(this);
				var code=$this.attr('channelId');
				var $sub=$this.parents('table').find('.sub_channel[fatherId="'+code+'"]');
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
			
			$('.f_channel').each(function(){
				$(this).find('td:last').click(function(e){
					e.stopPropagation()
				})
			})
			
			$('.edit-btn').click(function(e){
				getBuss($(this));
				$('.f-input').prop('readonly',false)
				$('.close').hide()
				e.stopPropagation()
				$('.fillAlert').show()
				$('#hideBtn').show();
		    	$('.makeSure').hide();
		    	$('.f-input').prop('readonly',false).val('')
			})
			
		    $('#sub1').click(function(){
		    	var $input=$(this).parent().parent().children('.amountData').children().children('.ghItems').find('.p-input');
		    	var $tip='<p class="tip">渠道占比之和需为100%</p>';
		    	var $parent=$(this).parent().parent().children('.amountData').children('.ghList');
		    	
		    	var sum_total=0;
		    	var w_name= [];
		    	console.log($parent)
		    	//取出name数组
		    	$input.each(function(){
		    		var $wname = $(this).parent().parent().parent().parent().children('.w_name').attr('name');
		    		w_name.push($wname);
		    	})
		    	$.unique(w_name);
		    	//根据name数组 查总和
		    	$.each(w_name,function(n,v){
		    		var sum=0;
		    		// if(sum_total == 1){
		    		// 	return false;
		    		// }
		    		$input.each(function(){
		    			// alert(sum);
		    			var $wname_sum = $(this).parent().parent().parent().parent().children('.w_name').attr('name');
		    			if($wname_sum == v){
		    				sum += Number($(this).val());
		    			}
			    		
			    	})
		    		if(sum != 100){
		    			var tips=$parent.find('.tip')
			    		if(tips.length == 0){
			    			$parent.append($tip)
			    		}
			    		sum_total = 0;
			    		return false;
		    		}else{
		    			sum_total = sum;
		    		}
		    	})
		    	if(sum_total == 100 ){
		    		$('#hideBtn').hide();
		    		$('.makeSure').show();
		    		$('.f-input').prop('readonly',true)
		    		$parent.find('.tip').remove()
		    	}
		    	
			    
		    })
		    
		    $('#cancel1').click(function(){
		    	$('.fillAlert').hide()
		    	$('.f-input').val('')
		    	$('.ghList').remove();
		    	
		    })
		    $('#cancel2').click(function(){
		    	$('#hideBtn').show();
		    	$('.makeSure').hide();
		    	$('.f-input').prop('readonly',false)
		    })
		    
		    $('.look-btn').click(function(){
		    	getBuss($(this));
		    	$('.close').show();
		    	$('#hideBtn').hide();
		    	$('.f-input').prop('readonly',true)
		    	$('.fillAlert').show();
		    })
		    $('.close').click(function(){
		    	$('.fillAlert').hide()
		    	$('.ghList').remove();
		    })
		    
		    $('.p-input').on('input propertychange',function(){
		    	var $input=$(this).parents('.ghItems').find('.p-input');
		    	var $tip='<p class="tip">渠道占比之和需为100%</p>';
		    	var $parent=$(this).parents('.ghList')
		    	var sum=0;
		    	console.log($parent)
		    	$input.each(function(){
		    		sum += Number($(this).val())
		    	})
		    	if(sum != 100){
		    		var tips=$parent.find('.tip')
		    		if(tips.length == 0){
		    			$parent.append($tip)
		    		}
		    	}else{
		    		$parent.find('.tip').remove()
		    	}
		    })

		    //需要回填的数据
		    function getBuss(obj){
         		var $date = obj.parent().parent().children('input').val();
	            $.ajax({
	               	type:'get',
	               	url:"/operate/backfill/getbackedit?date="+$date,
		               	success:function(data){
		               		// alert(data[0].date_time);
		               		$.each(data,function(i,v){
		               			if(v.sum){
		               				var str='<dl class="ghList"><dt class="gh-name">'+v.wx_name+'：</dt><input class="w_name" name="wx_name_'+v.wx_id+'" type="hidden" value="'+v.wx_id+'" /><input name="datetime_buss" type="hidden" value="'+v.date_time+'" /><dd class="ghItems ghItems_wx_'+v.wx_id+'"><dl><dt>数量</dt><dd><input type="text" value="'+v.sum+'" name="amount_'+v.wx_id+'"class="f-input"/></dd></dl></dd></dl>';
		               			}else{
		               				var str='<dl class="ghList"><dt class="gh-name">'+v.wx_name+'：</dt><input class="w_name" name="wx_name_'+v.wx_id+'" type="hidden" value="'+v.wx_id+'" /><input name="datetime_buss" type="hidden" value="'+v.date_time+'" /><dd class="ghItems ghItems_wx_'+v.wx_id+'"><dl><dt>数量</dt><dd><input type="text" name="amount_'+v.wx_id+'"class="f-input"/></dd></dl></dd></dl>';
		               			}
		               			
		               			$('.amountData').append(str);

		               			$(v.buss).each(function(ib,vb){
		               				if(vb.hold){
		               					var str1='<dl><dt>'+vb.bname+'</dt><dd><input name="bid_'+vb.bid+'" type="hidden" value="'+vb.bid+'" /><input name="bid_'+vb.id+'" type="hidden" value="'+vb.id+'" /><input type="text" name="bid_val_'+vb.id+'" value="'+vb.hold+'" class="f-input p-input"/>%</dd></dl>';
		               				}else{
		               					var str1='<dl><dt>'+vb.bname+'</dt><dd><input name="bid_'+vb.bid+'" type="hidden" value="'+vb.bid+'" /><input name="bid_'+vb.id+'" type="hidden" value="'+vb.id+'" /><input type="text" name="bid_val_'+vb.id+'" class="f-input p-input"/>%</dd></dl>';
		               				}
			               			
			               			$('.ghItems_wx_'+v.wx_id+'').append(str1);
			               		})
		               		})
		               	},
		               	error:function(){   
							alert('驳回失败');   
						}
	            });

         	}
		    
		})
	</script>
</html>
