
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>产能查询</title>
		@include('Operate.common.head')	
	</head>
	<body>
		@include('Operate.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="get" class="form-inline" role="form" id="f-report">
					<div class="form-group">
					    <label>
					    	区域：					    	
					    </label>
                                            <input type="text" name="area" value="{{$keycode}}"/>					    
					</div>
					<div class="form-group">
					    <label>
					    	性别：					    	
					    </label>
					    <select name="sex" class="form-control">
					    	<option value="">全部</option>
					    	<option value="1"
                                                        @if($sex==1)
                                                        selected
                                                        @endif
                                                        >男</option>
					    	<option value="2"
                                                        @if($sex==2)
                                                        selected
                                                        @endif
                                                        >女</option>
					    </select>						    
					</div>
					<div class="form-group">
						<label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{$time}}" readonly /></label>						
					</div>
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<input type="button" value="导出excel" class="excel"/>
				</form>
                                <div>
                                    您当前选择的性别是:
                                    @if($sex==1)
                                    男
                                    @elseif($sex==2)
                                    女
                                    @else
                                    全部
                                    @endif
                                </div>
				<table class="table-bordered table-responsive table-striped detail init-table">
					<tr>
						<th>区域</th>
						<th>总量</th>
						<th>剩余产能</th>
					</tr>
					<tr>
						<td style="padding-left: 40px;">{{$data['city_name']}}</td>
                                                <td>
                                                    {{$data['capacity_num']}}
                                                </td>
						<td>{{$data['dbcapacity_num']}}</td>
					</tr>
				</table>
				
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
			
                    $('.find').click(function(){
                        $('.form-inline').submit();
//                            if($('.form-control').val()>0||$('#inputv').val()!=''){
//                                var path = "getBussOneReport";  
//                                $('.form-inline').attr("action", path).submit();
//                            }else{
//                                var path = "getBussReport";  
//                                $('.form-inline').attr("action", path).submit();
//                            }
                    })
                        
                    $('.excel').click(function(){
                        $('.form-inline').attr("action", 'CapacityCExcel').submit();
                    })
                    
                    $('.reset').click(function(){
                        window.location.href='CapacitySList';
                    })
		})
	</script>
</html>
