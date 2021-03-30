<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>产能设置</title>
		@include('Operate.common.head')	
		<style type="text/css">
			input[type=text]{
				border: none;
				background: #fff;
				width: 100%;
				height: 100%;
				text-align: center;
			}
		</style>
	</head>
	<body>
		@include('Operate.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" style="padding-top: 35px;">
					
					<table class="table-bordered table-responsive table-striped detail init-table">
						<tr>
							<th>区域</th>
							<th>总量</th>
							<th>男粉总量</th>
							<th>女粉总量</th>
						</tr>
                                                @foreach ($data as $key => $datalist)
                                                @if($datalist['pid'] == 1)
						<tr>
							<td style="padding-left: 40px;">{{$datalist['province_name']}}</td>
                                                        <td><input type="text" name="capacity[{{$datalist['id']}}][0]" value="{{$datalist['capacity_num']}}"/></td>
							<td><input type="text" name="capacity[{{$datalist['id']}}][1]" value="{{$datalist['boy_num']}}"/></td>
							<td><input type="text" name="capacity[{{$datalist['id']}}][2]" value="{{$datalist['girl_num']}}"/></td>
						</tr>
                                                @else

						<tr  class="f_channel 
                                                     @if(!isset($datalist['list']))
                                                        on_channel
                                                     @else
                                                        off_channel
                                                     @endif
                                                     " channelId="{{$datalist['id']}}">
							<td>{{$datalist['province_name']}}</td>
                                                        <td><input type="text" name="capacity[{{$datalist['id']}}][0]" value="{{$datalist['capacity_num']}}"/></td>
							<td><input type="text" name="capacity[{{$datalist['id']}}][1]" value="{{$datalist['boy_num']}}"/></td>
							<td><input type="text" name="capacity[{{$datalist['id']}}][2]" value="{{$datalist['girl_num']}}"/></td>
						</tr>
                                                    @if(isset($datalist['list']))
                                                        @foreach ($datalist['list'] as $key2 => $datalist2)
                                                        <tr class="sub_channel" fatherId="{{$datalist['id']}}">
                                                                <td>{{$datalist2['city_name']}}</td>
                                                                <td><input type="text" name="capacity[{{$datalist2['id']}}][0]" value="{{$datalist2['capacity_num']}}"/></td>
                                                                <td><input type="text" name="capacity[{{$datalist2['id']}}][1]" value="{{$datalist2['boy_num']}}"/></td>
                                                                <td><input type="text" name="capacity[{{$datalist2['id']}}][2]" value="{{$datalist2['girl_num']}}"/></td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                
                                                @endif
                                                @endforeach
					</table>
					<div class="btns">
						<input type="button" value="提交" class="submit"/>
<!--						<input type="button" value="取消" class="shopcancel" onclick="history.go(-1)"/>-->
					</div>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								请确认是否保存此次修改？
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认"/>
                                                                <button type="button" class="btn btn-cancel">取消</button>
							</div>
						</div>
					</div>
                                    <input type="hidden" name="_token"         value="{{  csrf_token()  }}"/>
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
				$(this).find('td:gt(0)').click(function(e){
					e.stopPropagation()
				})
			})
			
			//弹窗
			$('.submit').click(function(){
				$('.myalert').show()
			})
			
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide();
			})
			
			
		})
	</script>
</html>
