<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>优先级调整</title>
		@include('Operate.common.head')
		<style>
			table{
				width: 100%;
				margin-bottom: 20px;
			}
			table th,table td{
				padding: 8px 0;
				box-sizing: border-box;
			}
			.colspan-3 th{
				width: 33.33%;
			}
			table tr:first-child>th{
				background: #f9f9f9;
			}
			.position1{
				position: relative;
			}
			.position2{
				position: relative;
			}
			#ul_hide1{
				position: absolute;
				right: 0;
				z-index: 999;
				background: #fff;
				border: 1px solid #ccc;
				border-radius: 4px;
				width: auto;
				box-sizing: content-box;

			}
			#ul_hide1 li{
				padding: 0 10px;
				min-width: 100px;
			}
			#ul_hide2{
				position: absolute;
				right: 0;
				z-index: 999;
				background: #fff;
				border: 1px solid #ccc;
				border-radius: 4px;
				width: auto;
				box-sizing: content-box;

			}
			#ul_hide2 li{
				padding: 0 10px;
				min-width: 100px;
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
					<div class="form-group position1">
					    <label>
					    	渠道：					    	
					    </label>
						<input type="text" id="inputq" onkeyup="checkFunction1()" name="buss" @if(isset($post['buss']))value="{{$post['buss']}}"@endif class="form-control">
						<ul id="ul_hide1">
							@if(isset($buss_list) && !empty($buss_list))
								@foreach($buss_list as $k=>$v)
									<li class="option_obj1" style="display: none;">{{$v['nick_name']}}</li>
								@endforeach
							@endif
						</ul>
						<script>
							$(".option_obj1").click(function(){
								var wxname = $(this).text();
								$("#inputq").val(wxname);
								$(".option_obj1").hide();
							})

							function checkFunction1(){
								var inputv,filter,ul,li,a,i;
								inputv = document.getElementById('inputq');
								filter = inputv.value.toUpperCase();
								ul =  document.getElementById('ul_hide1');
								li = ul.getElementsByTagName('li');
								if(filter==''){
									$(".option_obj1").hide();
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
					    {{--<select name="buss" class="form-control">--}}
					    	{{--<option value="0">请选择</option>--}}
							{{--@if(isset($buss_list) && !empty($buss_list))--}}
							{{--@foreach($buss_list as $v)--}}
								{{--@if(isset($post['buss']) && $post['buss']==$v['bid'])--}}
									{{--<option selected value="{{$v['bid']}}">{{$v['nick_name']}}</option>--}}
								{{--@else--}}
									{{--<option value="{{$v['bid']}}">{{$v['nick_name']}}</option>--}}
								{{--@endif--}}
							{{--@endforeach--}}
							{{--@endif--}}
					    {{--</select>--}}
					</div>
					<div class="form-group position2">
					    <label>
					    	选择公众号：					    	
					    </label>
						<input type="text" id="inputg" onkeyup="checkFunction2()" name="wxName" @if(isset($post['wxName']))value="{{$post['wxName']}}"@endif class="form-control">
						<ul id="ul_hide2">
							@if(isset($wx_name) && !empty($wx_name))
								@foreach($wx_name as $k=>$v)
									<li class="option_obj2" style="display: none;">{{$v['wx_name']}}</li>
								@endforeach
							@endif
						</ul>
						<script>
							$(".option_obj2").click(function(){
								var wxname = $(this).text();
								$("#inputg").val(wxname);
								$(".option_obj2").hide();
							})

							function checkFunction2(){
								var inputv,filter,ul,li,a,i;
								inputv = document.getElementById('inputg');
								filter = inputv.value.toUpperCase();
								ul =  document.getElementById('ul_hide2');
								li = ul.getElementsByTagName('li');
								if(filter==''){
									$(".option_obj2").hide();
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
					    {{--<select name="gzh" class="form-control">--}}
					    	{{--<option value="0">请选择</option>--}}
							{{--@if(isset($wx_name) && !empty($wx_name))--}}
							{{--@foreach($wx_name as $v)--}}
								{{--@if(isset($post['gzh']) && $post['gzh']==$v['o_wx_id'])--}}
					    			{{--<option selected value="{{$v['o_wx_id']}}">{{$v['wx_name']}}</option>--}}
								{{--@else--}}
									{{--<option value="{{$v['o_wx_id']}}">{{$v['wx_name']}}</option>--}}
								{{--@endif--}}
							{{--@endforeach--}}
							{{--@endif--}}
					    {{--</select>--}}
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					{{--<label style="float: right; margin-right: 10px;color: #FF3400;">数字越大，优先级越高</label>--}}
				</form>
				<table class="table-bordered table-responsive detail colspan-3" id="reportTable">
					<tr>
						<th>渠道名</th>
						<th>公众号</th>
						<th>优先级</th>
					</tr>
					@if(!empty($buss))
					@foreach($buss as $v)
					<tr>
						<td rowspan="{{$v['count']+1}}">{{$v['name']}}</td>
					</tr>
						@if(isset($data[$v['name']]) && !empty($data[$v['name']]))
						@foreach($data[$v['name']] as $kk=>$vv)
							@if(isset($vv['wx_name']))
							<tr>
								<td>{{$vv['wx_name']}}</td>
								<td>
									<button class="btn btn-blue priority" buss="{{$vv['buss_id']}}" order="{{$vv['order_id']}}">{{$vv['level']}}</button>
								</td>
							</tr>
							@else
							<tr>
								<td></td>
								<td>
									<span class="btn priority"></span>
								</td>
							</tr>
							@endif
						@endforeach
						@endif
					@endforeach
					@endif
				</table>
				<p>备注：数字越大，优先级越高</p>
			@if(isset($paginator))
				{{$paginator->appends($post)->render()}}
				@endif
			</div>
		</div>
		
		
		<div class="prior-box" style="display: none;">
			<div class="mask"></div>
			<div class="prior-main">
				<form action="" method="" class="prior-form">
					{{csrf_field()}}
					<input type="hidden" name="buss" value=""/>
					<input type="hidden" name="order" value=""/>
					<div class="prior-list">
						<label for="priorOld">旧优先级：</label>
						<input type="input" name="priorOld" id="priorOld" class="prior-input" readonly/>
					</div>
					<div class="prior-list">
						<label for="priorNew">新优先级：</label>
						<input type="input" name="level" id="priorNew" class="prior-input"/>
					</div>
					<div class="p-btns">
						<input type="button" value="提交" class="p-submit"/>
						<input type="button" value="取消" class="p-cancel"/>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			
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
			
			
			//修改优先级
			$('.priority').click(function(){
				var old=$(this).text();
				$('#priorOld').val(old)
				$('.prior-box').show();
			})
		    $('.p-cancel').click(function(){
		    	$('.prior-box').hide();
		    	$('.prior-input').val('')
		    })

			$(".reset").click(function(){
				window.location.href = 'getList';
			})

			$(".priority").click(function(){
				var buss_id = $(this).attr('buss');
				var order_id = $(this).attr('order');
				$("input[name=buss]").val(buss_id);
				$("input[name=order]").val(order_id);
			})
			$(".p-submit").click(function(){
				var str = $("#priorNew").val();
				var order_id = $("input[name=order]").val();
				var buss_id = $("input[name=buss]").val();
				if(!str){
					alert('优先级不能为空');
					window.location.href = 'getList';
				}else{
					$.post('setLevel',{'level':str,'buss_id':buss_id,'order_id':order_id,'_token':$("input[name=_token]").val()},function(t){
						if(t){
							alert('修改成功');
							window.location.href = 'getList';
						}else{
							alert('修改失败');
							window.location.href = 'getList';
						}
					})
				}
			})
		})
	</script>
</html>
