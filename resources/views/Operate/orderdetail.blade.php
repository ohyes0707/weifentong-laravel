<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>订单列表</title>
		@include('Operate.common.head')
		<script src="{{ URL::asset('operate/js/Sortable.js') }}" type="text/javascript" charset="utf-8"></script>
		<style>
			.chan-table tr td:nth-child(7) {
				text-align: center;
			}
			.chan-table tr td:nth-child(8) {
				text-align: center;
			}
			.chan-table tr td:nth-child(9) {
				text-align: center;
			}
			.block__list{
				margin-top: 30px;
			}
			.block__list li input{
				width: 200px;
				height: 40px;
				border-radius: 4px;
				border: 1px solid #ccc;
				background: #fff;
				font-size: 16px;
				margin-bottom: 10px;
				cursor: move;
			}
			.one_price{
				width:100%;
				border:none;
				text-align: center;
			}
			.subdata .data:first-child{
				padding-bottom:11px;
			}
			.subdata .data:nth-child(2){
				line-height:59px;
			}
			.subdata .data:nth-child(3){
				line-height:59px;
			}
			.btn_log{
				padding: 0;
			}
		</style>
		<script>
			var buss_list = $(".buss_list").html();
		</script>
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
					<div class="b-title">订单详情<span style="float: right;margin-right: 30px;">销售：{{$user_name}}</span></div>
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
								<div class="data textHide">{{$data['hot_area']}}</div>
							@else
								<div class="data textHide">不限</div>
							@endif
						</div>
						<div class="col-sm-4">
							<span class="dlabel">每日涨粉：</span>
							<div class="subdata">
								<div class="data">
									<span>保底量</span> <span class="min_fans">{{$data['w_least_fans']}}</span>
								</div>
								<div class="data">
									<span>最高量</span> <span class="max_fans">{{$data['w_max_fans']}}</span>
								</div>
								<div class="data">
									<span>建议量</span> <span>{{$data['w_advis_fans']}}</span>
								</div>
							</div>
						</div>
						<div class="col-sm-4" @if(!$order_time) style="color:red;"  @endif >
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
								<div class="data textHide">{{$data['fans_tag']}}</div>
							@else
								<div class="data textHide">不限</div>
							@endif
						</div>
						<div class="col-sm-4" @if(!$order_time) style="color:red;"  @endif>
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
								<div class="data">{{$data['scene_ch']}}</div>
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
						<div class="col-sm-4">
							<span class="dlabel">选择属性：</span>
							<span class="data">
								@if($data['check_status']==1)
									满足其一
								@else
									满足全部
								@endif
							</span>
						</div>
						<div class="col-sm-4">
							<span class="dlabel">设备属性：</span>
							<span class="data">
								@if($data['device_type']==1)
									ios
								@elseif($data['device_type']==2)
									安卓
								@else
									不限
								@endif
							</span>
						</div>
					</div>
				</div>
				
				<form action="" method="post" class="f_order"  id="order-form" onsubmit="return submitForm()">
					{{csrf_field()}}
					<input type="hidden" name="order_id" value="{{$order_id}}" class="order_id"/>
					<input type="hidden" name="work_id" value="{{$work_id}}"/>
					{{--<input type="hidden" name="level" value=""/>--}}
					<div class="topbtn clearfix">
						<input type="button" class="btn btn-red btn-close" value="全部暂停"/>
						<input type="button" class="btn btn-blue btn-open" value="全部开启"/>	
					</div>
					<table class="table table-bordered chan-table">
						<tr class="t-head">
							<th class="ghname" rowspan="12">{{$wx_name}}</th>
							<th>渠道选择</th>
							<th>总涨粉</th>
							<th>日涨粉</th>
							<th>结算一口价</th>
							<th>渠道操作</th>
							<th>用户选择</th>
							<th>已涨粉总量</th>
							<th>当日涨粉量</th>
							<th>当日取关率</th>
						</tr>

						<tr class="t-foot">
							<td>合计</td>
							<td class="sum-all">
								@if(isset($buss_list['total_fans']))
									{{$buss_list['total_fans']}}
								@endif
							</td>
							<td class="sum-day2">
								<input type="number" name="date_total_fans" id="day_fans" class="one_price" @if($order_day_fans)value="{{$order_day_fans}}"@else value="{{$data['w_advis_fans']}}" @endif>
								{{--@if(isset($buss_list['day_fans']))--}}
									{{--{{$buss_list['day_fans']}}--}}
								{{--@endif--}}
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								@if(isset($buss_list['total_up_fans']))
									{{$buss_list['total_up_fans']}}
								@endif
							</td>
							<td>
								@if(isset($buss_list['day_up_fans']))
									{{$buss_list['day_up_fans']}}
								@endif
							</td>
							<td>
								@if(isset($buss_list['day_up_fans']) && $buss_list['day_up_fans'] != 0)
									{{sprintf('%.2f',$buss_list['day_un_fans']/$buss_list['day_up_fans']*100)}}%
								@endif
							</td>
						</tr>
						@if(!empty($buss_total))
						@foreach($buss_total as $k=>$v)
							@if($v['nick_name']!='')
							@if(isset($v[$v['username']]) && $v[$v['username']])
								<tr data-code="{{$v['id']}}" title="{{$v['nick_name']}}_f" class="parent">
							@else
								<tr data-code="{{$v['id']}}" title="{{$v['nick_name']}}_f" class="parent parentOnly">
							@endif
								<td class="td-chan">
									{{--<input type="hidden" name="p_buss[{{$v['id']}}]" value="0">--}}
									<label class="offlabel">
										@if(isset($v[$v['username']]) && $v[$v['username']])
											@if(isset($buss_list[$v['id']]))
												<input type="checkbox" id="{{$v['id']}}" checked>
											@else
												<input type="checkbox" id="{{$v['id']}}">
											@endif
										@else
											@if(isset($buss_list[$v['id']]))
												<input type="checkbox"  name="check[{{$v['id']}}]" value="{{$v['id']}}" id="{{$v['id']}}" checked >
											@else
												<input type="checkbox"  name="check[{{$v['id']}}]" value="{{$v['id']}}" id="{{$v['id']}}" >
											@endif
										@endif
										<input type="hidden" name="pbid[{{$v['id']}}]" value="{{$v['id']}}">
										{{$v['nick_name']}}
									</label>
									@if(isset($v[$v['username']]) && $v[$v['username']])
										<span class="toggle disopen"></span>
									@endif
								</td>
								@if(isset($v[$v['username']]) && $v[$v['username']])
									<td class="inputtd">
								@else
									<td class="inputtd parentOnly">
								@endif
									@if(isset($v[$v['username']]) && $v[$v['username']] && isset($buss_list[$v['id']]))
										<input type="number" class="alladd" name="total_fans[{{$v['id']}}]" value="" placeholder="/" readonly/>
									@elseif(isset($buss_list[$v['id']]))
										<input type="number" class="alladd" name="total_fans[{{$v['id']}}]" value="{{(string)$buss_list[$v['id']]['plan_fans']}}" placeholder="/"/>
									@else
										<input type="number" class="alladd" name="total_fans[{{$v['id']}}]" placeholder="/" readonly/>
									@endif
								</td>
								@if(isset($v[$v['username']]) && $v[$v['username']])
									<td class="inputtd">
								@else
									<td class="inputtd parentOnly">
								@endif
									@if(isset($v[$v['username']]) && $v[$v['username']]  && isset($buss_list[$v['id']]))
										<input type="number" class="dayadd" name="day_fans[{{$v['id']}}]" value=""  placeholder="/" readonly/>
									@elseif(isset($buss_list[$v['id']]))
										<input type="number" class="dayadd" name="day_fans[{{$v['id']}}]" value="{{(string)$buss_list[$v['id']]['day_fans']}}"  placeholder="/"/>
									@else
										<input type="number" class="dayadd" name="day_fans[{{$v['id']}}]" placeholder="/" readonly/>
									@endif
								</td>
								<td>
									@if(isset($buss_list[$v['id']]) && !isset($v[$v['username']]))
										<input type="text" class="one_price" name="one_price[{{$v['id']}}]" value="{{$buss_list[$v['id']]['one_price']}}"/>
									@else
										<input type="text" class="one_price" name="one_price[{{$v['id']}}]" value="0"/>
									@endif
								</td>
								<td>
									@if(isset($v[$v['username']]) && $v[$v['username']])
									<select disabled>
									@else
									<select  name="status[{{$v['id']}}]">
									@endif
										@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['task_status']==2)
											<option class="stop" selected value="2">暂停</option>
										@else
											<option class="stop" value="2">暂停</option>
										@endif
										@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['task_status']==1)
											<option class="start" selected value="1">开启</option>
										@else
											<option class="start" value="1">开启</option>
										@endif
									</select>
								</td>
								<td>
									@if(isset($v[$v['username']]) && $v[$v['username']])
									<select name="" disabled>
									@else
									<select name="user_type[{{$v['id']}}]">
									@endif
										<option class="new" value="0">不限</option>
										@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['user_type']==1)
											<option class="new" selected value="1">新用户</option>
										@else
											<option class="new" value="1">新用户</option>
										@endif
										@if($data['sex'] == 1 || $data['sex'] == 2)
											<option class="new" selected value="2">老用户</option>
										@elseif(!empty($data['fans_tag']))
											<option class="new" selected value="2">老用户</option>
										@elseif(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['user_type']==2)
											<option class="new" selected value="2">老用户</option>
										@else
											<option class="new" value="2">老用户</option>
										@endif
									</select>
								</td>
								<td>
									@if(isset($v[$v['username']]) && $v[$v['username']] && isset($parent_total[$v['id']]))
										{{$parent_total[$v['id']]['total_fans']}}
									@elseif(isset($buss_list[$v['id']]))
										{{$buss_list[$v['id']]['total_fans']}}
									@endif
								</td>
								<td>
									@if(isset($v[$v['username']]) && $v[$v['username']] && isset($parent_total[$v['id']]))
										{{$parent_total[$v['id']]['subscribe_today']}}
									@elseif(isset($buss_list[$v['id']]))
										{{$buss_list[$v['id']]['subscribe_today']}}
									@endif
								</td>
								<td>
									@if(isset($v[$v['username']]) && $v[$v['username']] && isset($parent_total[$v['id']]))
										{{$parent_total[$v['id']]['child_unper']}}
									@else
										@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['subscribe_today'] != 0)
											{{sprintf('%.2f',$buss_list[$v['id']]['un_subscribe_today']/$buss_list[$v['id']]['subscribe_today']*100)}}%
										@endif
									@endif
								</td>
							</tr>
								@if(isset($v[$v['username']]) && $v[$v['username']])
									<tr data-code="{{$v['id']}}_c" title="{{$v['nick_name']}}" data-fcode="{{$v['id']}}" class="subset" style="display: none;">
										<td class="td-chan">
											<label class="offlabel">
												@if(isset($buss_list[$v['id']]))
													<input type="checkbox" id="{{$v['id']}}" checked name="check[{{$v['id']}}]">
												@else
													<input type="checkbox" id="{{$v['id']}}" name="check[{{$v['id']}}]">
												@endif
												<input type="hidden" name="pbid[{{$v['id']}}]" value="{{$v['id']}}">
												{{$v['nick_name']}}
											</label>
										</td>
										<td class="inputtd">
											@if(isset($buss_list[$v['id']]))
												<input type="number" class="alladd" name="total_fans[{{$v['id']}}]" value="{{$buss_list[$v['id']]['plan_fans']}}"/>
											@else
												<input type="number" class="alladd" name="total_fans[{{$v['id']}}]" placeholder="/" readonly/>
											@endif
										</td>
										<td class="inputtd">
											@if(isset($buss_list[$v['id']]))
												<input type="number" class="dayadd" name="day_fans[{{$v['id']}}]" value="{{$buss_list[$v['id']]['day_fans']}}"/>
											@else
												<input type="number" class="dayadd" name="day_fans[{{$v['id']}}]" placeholder="/" readonly/>
											@endif
										</td>
										<td>
											@if(isset($buss_list[$v['id']]))
												<input type="text" class="one_price" name="one_price[{{$v['id']}}]" value="{{$buss_list[$v['id']]['one_price']}}"/>
											@else
												<input type="text" class="one_price" name="one_price[{{$v['id']}}]" value="0"/>
											@endif
										</td>
										<td>
											<select name="status[{{$v['id']}}]">
												@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['task_status']==2)
													<option class="stop" selected value="2">暂停</option>
												@else
													<option class="stop" value="2">暂停</option>
												@endif
												@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['task_status']==1)
													<option class="start" selected value="1">开启</option>
												@else
													<option class="start" value="1">开启</option>
												@endif
											</select>
										</td>
										<td>
											<select name="user_type[{{$v['id']}}]">
												<option class="new" value="0">不限</option>
												@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['user_type']==1)
													<option class="new" selected value="1">新用户</option>
												@else
													<option class="new" value="1">新用户</option>
												@endif
												@if($data['sex'] == 1 || $data['sex'] == 2)
													<option class="new" selected value="2">老用户</option>
												@elseif(!empty($data['fans_tag']))
													<option class="new" selected value="2">老用户</option>
												@elseif(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['user_type']==2)
													<option class="new" selected value="2">老用户</option>
												@else
													<option class="new" value="2">老用户</option>
												@endif
											</select>
										</td>
										<td>
											@if(isset($buss_list[$v['id']]))
												{{$buss_list[$v['id']]['total_fans']}}
											@endif
										</td>
										<td>
											@if(isset($buss_list[$v['id']]))
												{{$buss_list[$v['id']]['subscribe_today']}}
											@endif
										</td>
										<td>
											@if(isset($buss_list[$v['id']]) && $buss_list[$v['id']]['subscribe_today'] != 0)
												{{sprintf('%.2f',$buss_list[$v['id']]['un_subscribe_today']/$buss_list[$v['id']]['subscribe_today']*100)}}%
											@endif
										</td>
									</tr>
								@endif
							@endif
							@if(isset($v[$v['username']]) && $v[$v['username']] && is_array($v[$v['username']]))
								@foreach($v[$v['username']] as $vv)
									<tr data-code="{{$vv['id']}}" title="{{$vv['nick_name']}}" data-fcode="{{$v['id']}}" class="subset" style="display: none;">
										<td class="td-chan">
											{{--<input type="hidden" name="p_buss[{{$v['id']}}]" value="{{$v['id']}}">--}}
											<label class="offlabel">
												@if(isset($buss_list[$vv['id']]))
													<input type="checkbox" value="{{$vv['id']}}" checked name="check[{{$vv['id']}}]">
												@else
													<input type="checkbox" value="{{$vv['id']}}"  name="check[{{$vv['id']}}]">
												@endif
													<input type="hidden" name="pbid[{{$vv['id']}}]" value="{{$v['id']}}">
												{{$vv['nick_name']}}
											</label>
										</td>
										<td class="inputtd">
											@if(isset($buss_list[$vv['id']]))
												<input type="number" class="alladd" name="total_fans[{{$vv['id']}}]" value="{{$buss_list[$vv['id']]['plan_fans']}}"/>
											@else
												<input type="number" class="alladd" name="total_fans[{{$vv['id']}}]" placeholder="/" readonly/>
											@endif
										</td>
										<td class="inputtd">
											@if(isset($buss_list[$vv['id']]))
												<input type="number" class="dayadd" name="day_fans[{{$vv['id']}}]" value="{{$buss_list[$vv['id']]['day_fans']}}"/>
											@else
												<input type="number" class="dayadd" name="day_fans[{{$vv['id']}}]" placeholder="/" readonly/>
											@endif
										</td>
										<td>
											@if(isset($buss_list[$vv['id']]))
												<input type="text" class="one_price" name="one_price[{{$vv['id']}}]" value="{{$buss_list[$vv['id']]['one_price']}}"/>
											@else
												<input type="text" class="one_price" name="one_price[{{$vv['id']}}]" value="0"/>
											@endif
										</td>
										<td>
											<select name="status[{{$vv['id']}}]">
												@if(isset($buss_list[$vv['id']]) && $buss_list[$vv['id']]['task_status']==2)
													<option class="stop" selected value="2">暂停</option>
												@else
													<option class="stop" value="2">暂停</option>
												@endif
												@if(isset($buss_list[$vv['id']]) && $buss_list[$vv['id']]['task_status']==1)
													<option class="start" selected value="1">开启</option>
												@else
													<option class="start" value="1">开启</option>
												@endif
											</select>
										</td>
										<td>
											<select name="user_type[{{$vv['id']}}]">
												<option class="new" value="0">不限</option>
												@if(isset($buss_list[$vv['id']]) && $buss_list[$vv['id']]['user_type']==1)
													<option class="new" value="1" selected>新用户</option>
												@else
													<option class="new" value="1">新用户</option>
												@endif
												@if($data['sex'] == 1 || $data['sex'] == 2)
													<option class="new" selected value="2">老用户</option>
												@elseif(!empty($data['fans_tag']))
													<option class="new" selected value="2">老用户</option>
												@elseif(isset($buss_list[$vv['id']]) && $buss_list[$vv['id']]['user_type']==2)
													<option class="new" value="2">老用户</option>
												@else
													<option class="new" value="2">老用户</option>
												@endif
											</select>
										</td>
										<td>
											@if(isset($buss_list[$vv['id']]))
												{{$buss_list[$vv['id']]['total_fans']}}
											@endif
										</td>
										<td style="text-align: center">
											@if(isset($buss_list[$vv['id']]))
												{{$buss_list[$vv['id']]['subscribe_today']}}
											@endif
										</td>
										<td>
											@if(isset($buss_list[$vv['id']]) && $buss_list[$vv['id']]['subscribe_today']!=0)
												{{sprintf('%.2f',$buss_list[$vv['id']]['un_subscribe_today']/$buss_list[$vv['id']]['subscribe_today']*100)}}%
											@endif
										</td>
									</tr>
								@endforeach
							@endif
						@endforeach
						@endif
					</table>
					<div class="bottombtn">
						<input type="hidden" name="wx_name" @if(isset($wx_name))value="{{$wx_name}}"@endif/>
						<input type="button" value="提交" class="btn btn-blue" id="submit"/>
						<input type="button" value="取消" class="btn btn-grey" onclick="history.go(-1)"/>
						<input type="button" value="关闭" class="btn btn-red orderclose"/>
						<input type="button" value="操作日志" class="btn btn-blue btn_log"/>
					</div>

					<div class="orderPriority" style="display: none;">
						<div class="mask"></div>
						<div class="order-prior-main">
							<div class="order-prior-header">订单优先级设置</div>
							<ul class="block__list block__list_words" id="order-priority">
								@if(isset($order_list))
									@foreach($order_list as $k=>$v)
										@if($order_id == $v['order_id'])
											<li class="now"><input style="border:1px solid #3EA9F5;text-align: center;" type="text" name="priority[{{$v['order_id']}}]" value="{{$v['wx_name']}}" style="text-align: center;" readonly/></li>
										@else
											<li><input type="text" name="priority[{{$v['order_id']}}]" value="{{$v['wx_name']}}" style="text-align: center;" readonly/></li>
										@endif
									@endforeach
								@endif
							</ul>
							<div class="prior-btns" id="hideBtn" style="margin-top: 15px">
								<input type="button" value="提交" class="fill-sub" id="sub1"/>
								<input type="button" value="取消" class="fill-cancel" id="cancel1"/>
							</div>
							<div class="makeSure-box" style="display: none;">
								<p class="disChange">提交后将不可更改，请确定是否提交？</p>
								<div class="fill-btns">
									<input type="submit" value="确定" class="fill-sub" id="sub2"/>
									<input type="button" value="取消" class="fill-cancel" id="cancel2"/>
								</div>
							</div>
						</div>
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
					<button class="btn btn-sure">确定</button>
					<button class="btn btn-cancel">取消</button>
				</div>
			</div>
		</div>


	</body>
	<script type="text/javascript">
//		$("#sub2").click(function(){
//			$('.orderPriority').hide()
//			judgeDayFans();
//			return false;
//		})

		$(".if_reset").click(function(){
			if ($('input[name=if_reset]').is(":checked")) {
				$('input[name=if_reset]').prop('checked',false);
			} else {
				$('input[name=if_reset]').prop('checked',true);
			}
		})

		function submitForm(){
			$('.orderPriority').hide()

			return judgeDayFans();
		}
		function judgeDayFans(){
			var min_fans=Number($('.min_fans').text())
			var max_fans=Number($('.max_fans').text())
			var day_fans=Number($('#day_fans').val())
			if(day_fans < min_fans || day_fans > max_fans){
				$('.myalert').show()
				$('.alertMain').html('日涨粉量应大于等于保底量，小于等于最高量');
				return false
			}
		}
		$('.btn-cancel,.btn-sure').click(function(){
			$('.myalert').hide()
		})
		$('#day_fans').blur(function(){
			judgeDayFans()
		})
		$('.parent input[type=checkbox]').change(function(){
			var $parent=$(this).parents('.parent'),
					code=$parent.attr('data-code'),
					$this=$(this),
					$sub=$('.subset[data-fcode="'+code+'"] .td-chan input[type=checkbox]');
			if($this.prop('checked')){
				$this.parent('label').addClass('onlabel').removeClass('offlabel')
				if($sub.length == 0){
					$parent.find('input:not([type=checkbox])').prop('readonly',false).attr('placeholder','')
				}
				$sub.each(function(){
					$(this).prop('checked',true).parent('label').addClass('onlabel').removeClass('offlabel')
							.parents('.subset').find('input:not([type=checkbox])').prop('readonly',false).attr('placeholder','')
				})


			}else{
				$this.parent('label').addClass('offlabel').removeClass('onlabel')
				if($sub.length == 0){
					$parent.find('input:not([type=checkbox])').prop('readonly',true).attr('placeholder','/')
				}
				$sub.each(function(){
					$(this).prop('checked',false).parent('label').addClass('offlabel').removeClass('onlabel')
							.parents('.subset').find('input:not([type=checkbox])').prop('readonly',true).attr('placeholder','/')
				})
			}
		})

		$('.subset input[type=checkbox]').change(function(){
			var code=$(this).parents('tr').attr('data-fcode'),
					$parent=$('.parent[data-code="'+code+'"]'),
					checkedLength=$('.subset[data-fcode="'+code+'"] .td-chan input:checked').length;
			if(checkedLength == 0){
				$parent.find('.td-chan input').prop('checked',false).parent('label').addClass('offlabel').removeClass('onlabel')
			}else{
				$parent.find('.td-chan input').prop('checked',true).parent('label').addClass('onlabel').removeClass('offlabel')
			}

		})

		//				$('.parent .td-chan label').click(function(){
		//			var $parent=$(this).parents('.parent'),
		//					code=$parent.attr('data-code'),
		//					$sub=$('.subset[data-fcode="'+code+'"] .td-chan input[type=checkbox]');
		//			$sub.each(function(){
		//				var $this=$(this);
		//				if($this.prop('checked')){
		//					$this.prop('checked',false);
		//					$this.parent('label').addClass('offlabel').removeClass('onlabel')
		//				}else{
		//					$this.prop('checked',true);
		//					$this.parent('label').addClass('onlabel').removeClass('offlabel')
		//				}
		//			})
		//		})
		$(function(){
			addChannel();

		})
		$(".btn-close").click(function(){
			$(".start").prop('selected',false);
			$(".stop").prop('selected',true);
		})
		$(".btn-open").click(function(){
			$(".stop").prop('selected',false);
			$(".start").prop('selected',true);
		})
		$("input:checked").each(function(){
			var id = $(this).prop('value');
			$("#"+id+"").attr('checked',true);
		})

		$('tr.parent').not('.parentOnly').each(function(){

			var $this=$(this),
					sum_all=0,
					sum_day=0,
					code=$(this).data('code'),
					$p_all=$(this).find('.alladd'),
					$p_day=$(this).find('.dayadd'),
					$sub=$('.subset[data-fcode="'+code+'"]'),
					$checked=$('.subset[data-fcode="'+code+'"] input[type=checkbox]:checked');
			if($checked.length > 0){
				$this.find('.td-chan label').addClass('onlabel').removeClass('offlabel')
				$this.find('.td-chan input').prop('checked',true)
			}else{
				$this.find('.td-chan label').addClass('offlabel').removeClass('onlabel')
				$this.find('.td-chan input').prop('checked',false)
			}
			$sub.each(function(){

				var $all=$(this).find('.alladd'),
						$day=$(this).find('.dayadd'),
						$rate=$(this).find('td:last')
				if($all.val()!=''){
					sum_all+=parseFloat($all.val())
				}
				if($day.val()!=''){
					sum_day+=parseFloat($day.val())
				}

			})

//			console.warn(sum_all);
//			console.warn($p_all);
			if(sum_all != 0){
				$p_all.val(sum_all)
			}
			if(sum_day != 0){
				$p_day.val(sum_day)
			}

//				$p_all.val(sum_all);
//				$p_day.val(sum_day)


		})

		/*弹框方法*/
		$('#submit').click(function(){
			$('html,body').scrollTop(0)
			$('.orderPriority').show()
		})
		$('#sub1').click(function(){
			$('#hideBtn').hide();
			$('.prior-editable input').prop('readonly',true);
			$('.makeSure-box').show()
			var level = $(".prior-editable input").val();
			$("input[name=level]").val(level);
		})

		$('#cancel1').click(function(){
			$('.orderPriority').hide()
		})

		$('#cancel2').click(function(){
			$('#hideBtn').show();
			$('.makeSure-box').hide();
			$('.prior-editable input').prop('readonly',false)
		})
		Sortable.create(document.getElementById('order-priority'),
				{
					animation: 150, //动画参数
					handle:'.now'
				});

		$('.btn_log').click(function(){
			var order_id = $("input[name=order_id]").val();
			window.location.href="log?order_id="+order_id;
		})
	</script>
</html>
