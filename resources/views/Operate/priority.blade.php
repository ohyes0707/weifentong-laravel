<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>优先级调整</title>
		@include('Operate.common.head')
		<script src="{{ URL::asset('operate/js/Sortable.js') }}" type="text/javascript" charset="utf-8"></script>
		<style>
			table tr:first-child>th{
				background: #f9f9f9;
			}
			table tr td:last-child{
				text-align: left;
				padding-left: 5px;
			}
			table input{
				padding: 3px 11px;
				background: #fff;
				border: 1px solid #777;
				color: #333;
				border-radius: 4px;
				font-size: 14px;
				cursor: move;
				width: 80px;
				overflow: hidden;
				white-space: nowrap;
				text-align: center;
			}
			.block__list_tags li{
				float: left;
				margin: 1px 20px 1px 0;
			}
			.sure,.cancel{
				width: 74px;
				height: 34px;
				border-radius: 4px;
			}
			.sure{
				border: none;
				background: #3EA9F5;
				color: #fff;
				margin-right: 40px;
			}
			.cancel{
				border: 1px solid #ccc;
				color: #999;
				background: #fff;
			}
			.p-btns{
				float: right;
				margin-bottom: 10px;
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
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<div class="form-group">
					    <label>
					    	父渠道：					    	
					    </label>
					    <select name="channel" class="form-control" id="sel-channel">
					    	<option value="0">请选择</option>
							@if(isset($buss))
								@foreach($buss as $k=>$v)
									@if(isset($post['channel']) && $post['channel'] == $v['bid'])
					    				<option value="{{$v['bid']}}" selected>{{$v['nick_name']}}</option>
									@else
										<option value="{{$v['bid']}}">{{$v['nick_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	子渠道：					    	
					    </label>
					    <select name="sub-channel" class="form-control" id="sub-channel">
					    	<option value="0">请选择</option>
							@if(isset($buss_c) && !empty($buss_c))
								@foreach($buss_c as $k=>$v)
									@if(isset($post['sub-channel']) && $post['sub-channel'] == $v['buss_id'])
										<option value="{{$v['buss_id']}}" selected>{{$v['nick_name']}}</option>
									@else
										<option value="{{$v['buss_id']}}">{{$v['nick_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					@if(!isset($order))
						<div class="p-btns">
							<input type="button" value="确定" class="sure" id="sure"/>
							<input type="button" value="取消" class="cancel"/>
						</div>
					@endif
				</form>

				@if(!isset($order))
					<form action="setLevel" method="post" id="priority">
						{{csrf_field()}}


						<table class="table-bordered detail">
							<tr>
								<th style="width:18%">渠道名</th>
								<th>订单名称</th>
							</tr>
							@if(isset($data) && !empty($data))
								@foreach($data as $k=>$v)
									<tr>
										<td>{{$k}}</td>
										<td>
											<ul id="channel_{{$k}}" class="block__list block__list_tags">
												@foreach($data[$k] as $kk=>$vv)
													<li>
														<input type="text" value="{{$vv['wx_name']}}" title="{{$vv['wx_name']}}" readonly/>
														<input type="hidden" name="{{$vv['buss_id']}}[]" value="{{$vv['order_id']}}"/>
													</li>
												@endforeach
											</ul>
										</td>
									</tr>
								@endforeach
							@endif
						</table>

						<div class="myalert" style="display: none;">
							<div class="mask"></div>
							<div class="alertbox">
								<a href="#" class="close">&times;</a>
								<div class="alertHead">提示</div>
								<div class="alertMain">
									请确认是否保存此次修改？
								</div>
								<div class="alertbtn">
									<button type="submit" class="btn btn-sure" id="submit">确定</button>
									<button type="button" class="btn btn-cancel">取消</button>
								</div>
							</div>
						</div>
					</form>
				@else
					<table class="table-bordered detail" >
						<tr>
							<th>订单优先级</th>
						</tr>
						@if(isset($order) && !empty($order))
							@foreach($order as $k=>$v)
								<tr>
									<td style="padding-left: 20px;">{{$v['wx_name']}}</td>
								</tr>
							@endforeach
						@endif
					</table>
				@endif

				@if(isset($order))
					{{$order->links()}}
				@endif
				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
			</div>
		</div>
		
	
	</body>
	<script type="text/javascript">
		$(function(){
			$('#sure').click(function(){
				$('.myalert').show()
			})
		    $('.btn-cancel').click(function(){
		    	$('.myalert').hide()
		    })
		    
		    
		    //拖拽
			$('.block__list').each(function(){
				var $this=$(this);
				var id=$this.attr('id');
				Sortable.create(document.getElementById(id), 
				{
					animation: 150, //动画参数
				});
			})
			//重置
			$(".reset").click(function(){
				window.location.href = 'getList';
			})
		    
		    //二级联动
		    $('#sel-channel').change(function(){
		    	var html='<option value="0">请选择</option>'
		    	var $this=$(this)
		    	var value=$(this).val();
		    	$.getJSON('getSon',{'value':value},function(res){
		    		$('#sub-channel').html('')
					$.each(res,function(i,v){
						html+='<option value="'+ v.buss_id+'">'+ v.nick_name+'</option>'
					})
					$('#sub-channel').html(html)
		    	})
				
		    })
		    
		})
	</script>
</html>
