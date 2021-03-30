
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>工单详情</title>
		@include('Operate.common.head')	
	</head>
	<body>
		@include('Operate.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<div class="header">工单详情</div>
                                
                                @if(!isset($data['old']['wx_name']))
                                    <div class="detail-box">
                                            <div class="b-title">公众号名称：<span>{{ $data['now']['wx_name'] }}</span></div>
                                            <div class="detail-con clearfix">
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">打款金额：</span>
                                                            <div class="data">{{  $data['now']['w_user_money'] }}</div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">总涨粉量：</span>
                                                            <span class="data fansdata">{{ $data['now']['w_total_fans'] }}</span>
                                                    </div>
                                                    <div class="col-sm-4 area">
                                                            <span class="dlabel">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</span>
                                                            <span class="data">{{ $data['now']['w_per_price'] }}</span>
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">每日涨粉：</span>
                                                            <div class="subdata">
                                                                    <p class="data">
                                                                            <span>保底量</span> <span>{{ $data['now']['w_least_fans'] }}</span>
                                                                    </p>
                                                                    <p class="data">
                                                                            <span>最高量</span> <span class="daymax">{{ $data['now']['w_max_fans'] }}</span> 
                                                                    </p>
                                                                    <p class="data">
                                                                            <span>建议量</span> <span>{{ $data['now']['w_advis_fans'] }}</span> 
                                                                    </p>
                                                            </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">投放时间：</span>
                                                            <span class="data">{{ $data['now']['w_start_date'] }} 至 {{ $data['now']['w_end_date'] }}</span>
                                                    </div>
                                                    <div class="col-sm-4 area">
                                                            <span class="dlabel">热点区域：</span>
                                                            <div class="data"> 
                                                                @if($data['now']['hot_area']=='')
                                                                   全部
                                                                @else
                                                                   {{  $data['now']['hot_area']  }}
                                                               @endif                                                                                                                     
                                                            </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">投放时段：</span>
                                                            <span class="data">{{ $data['now']['w_start_time'] }}至{{ $data['now']['w_end_time'] }}</span>
                                                    </div>
                                                    <div class="col-sm-4 area">
                                                            <span class="dlabel">属性区域：</span>
                                                            <div class="data">
                                                                @if($data['now']['fans_tag']=='')
                                                                   全部
                                                                @else
                                                                   {{  $data['now']['fans_tag']  }}
                                                               @endif  
                                                            </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">性别属性：</span>
                                                            <span class="data">

                                                            @if($data['now']['sex'] == 0)
								全部
							@elseif($data['now']['sex'] == 1)
								男
                                                        @elseif($data['now']['sex'] == 2)
								女
                                                        @endif

                                                            </span>
                                                    </div>
                                                    <div class="col-sm-4 area">
                                                            <span class="dlabel">场&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;景：</span>
                                                            <div class="data">
                                                                @if($data['now']['scene']=='')
                                                                   全部
                                                                @else
                                                                   {{  $data['now']['scene']  }}
                                                               @endif 
                                                            </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                            <span class="dlabel">设备类型：</span>
                                                            <span class="data">

                                                            @if($data['now']['device_type'] == 0)
								不限
							@elseif($data['now']['device_type'] == 1)
								iphone
                                                        @elseif($data['now']['device_type'] == 2)
								安卓
                                                        @endif

                                                            </span>
                                                    </div>
                                            </div>
                                    </div>
                                @endif
                                @if(isset($data['old']['wx_name']))
                                
                                <div class="detail-box">
					<div class="b-title">公众号名称：<span>{{ $data['old']['wx_name'] }}</span></div>
					<div class="detail-con clearfix">
                                                <div class="col-sm-4 ">
							<span class="dlabel">打款金额：</span>
							<div class="data">{{  $data['old']['w_user_money'] }}</div>
						</div>
						<div class="col-sm-4">
							<span class="dlabel">总涨粉量：</span>
							<span class="data fansdata">{{ $data['old']['w_total_fans'] }}</span>
						</div>
						<div class="col-sm-4 area">
							<span class="dlabel">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</span>
							<span class="data">{{ $data['old']['w_per_price'] }}</span>
						</div>
						
						<div class="col-sm-4">
							<span class="dlabel">每日涨粉：</span>
							<div class="subdata">
								<p class="data">
									<span>保底量</span> <span>{{ $data['old']['w_least_fans'] }}</span>
								</p>
								<p class="data">
									<span>最高量</span> <span class="daymax">{{ $data['old']['w_max_fans'] }}</span> 
								</p>
								<p class="data">
									<span>建议量</span> <span>{{ $data['old']['w_advis_fans'] }}</span> 
								</p>
							</div>
						</div> 
						<div class="col-sm-4">
							<span class="dlabel">投放时间：</span>
							<span class="data">{{ $data['old']['w_start_date'] }} 至 {{ $data['old']['w_end_date'] }}</span>
						</div>
                                                <div class="col-sm-4 area">
							<span class="dlabel">热点区域：</span>
<!--							<div class="data">{{  $data['old']['hot_area'] }}</div>-->
                                                        <div class="data">
								@if(!empty($data['old']['hot_area']))
									{{  $data['old']['hot_area'] }}
								@else
									全部
								@endif
							</div>
						</div>
						
						<div class="col-sm-4">
							<span class="dlabel">投放时段：</span>
							<span class="data">{{ $data['old']['w_start_time'] }}至{{ $data['old']['w_end_time'] }}</span>
						</div>
						<div class="col-sm-4 area">
							<span class="dlabel">属性区域：</span>
							<div class="data">
								@if(!empty($data['old']['fans_tag']))
									{{  $data['old']['fans_tag'] }}
								@else
									全部
								@endif
							</div>
						</div>
						<div class="col-sm-4">
							<span class="dlabel">性别属性：</span>
                                                        <span class="data">
                                                         @if($data['old']['sex'] == 0)
								全部
							@elseif($data['old']['sex'] == 1)
								男
                                                        @elseif($data['old']['sex'] == 2)
								女
                                                        @endif
                                                            
                                                        </span>
						</div>
                                                <div class="col-sm-4 area">
							<span class="dlabel">场&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;景：</span>
							<div class="data">
								@if(!empty($data['old']['scene']))
									{{ $data['old']['scene'] }}
								@else
									全部
								@endif
                                                        </div>
						</div>
                                                <div class="col-sm-4">
							<span class="dlabel">设备属性：</span>
                                                        <span class="data">
                                                         @if($data['old']['device_type'] == 0)
								全部
							@elseif($data['old']['device_type'] == 1)
								iphone
                                                        @elseif($data['old']['device_type'] == 2)
								安卓
                                                        @endif
                                                            
                                                        </span>
						</div>
					</div>
				</div>
				
				<div class="detail-box box2">
					<div class="b-title">修改时间：<span>{{ $data['old']['addtime'] }}</span></div>
					<div class="detail-con clearfix">
                                                <div class="col-sm-4  
                                                     @if($data['now']['w_user_money']!=$data['old']['w_user_money'])
                                                                        red
                                                                   @endif">
							<span class="dlabel">打款金额：</span>
							<div class="data">{{  $data['now']['w_user_money'] }}</div>
						</div>
						<div class="col-sm-4
                                                     @if($data['now']['w_total_fans']!=$data['old']['w_total_fans'])
                                                                        red
                                                     @endif">
							<span class="dlabel">总涨粉量：</span>
							<span class="data fansdata">{{  $data['now']['w_total_fans'] }}</span>
						</div>
						<div class="col-sm-4 area
                                                     @if($data['now']['w_per_price']!=$data['old']['w_per_price'])
                                                                        red
                                                     @endif
                                                     ">
							<span class="dlabel">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</span>
							<span class="data">{{  $data['now']['w_per_price'] }}</span>
						</div>
						
						<div class="col-sm-4">
							<span class="dlabel">每日涨粉：</span>
							<div class="subdata">
								<p class="data
                                                                   @if($data['now']['w_least_fans']!=$data['old']['w_least_fans'])
                                                                        red
                                                                   @endif
                                                                   ">
									<span>保底量</span> <span>{{  $data['now']['w_least_fans'] }}</span>
								</p>
								<p class="
                                                                   @if($data['now']['w_max_fans']!=$data['old']['w_max_fans'])
                                                                        red
                                                                   @endif ">
									<span>最高量</span> <span class="daymax">{{  $data['now']['w_max_fans'] }}</span> 
								</p>
								<p class="
                                                                   @if($data['now']['w_advis_fans']!=$data['old']['w_advis_fans'])
                                                                        red
                                                                   @endif ">
									<span>建议量</span> <span>{{  $data['now']['w_advis_fans'] }}</span> 
								</p>
							</div>
						</div>
						<div class="col-sm-4
                                                        @if($data['now']['w_start_date']!=$data['old']['w_start_date']||$data['now']['w_end_date']!=$data['old']['w_end_date'])
                                                            red
                                                        @endif ">
							<span class="dlabel">投放时间：</span>
							<span class="data">{{ $data['now']['w_start_date'] }} 至 {{ $data['now']['w_end_date'] }}</span>
						</div>
                                                <div class="col-sm-4 area 
                                                     @if($data['now']['hot_area']!=$data['old']['hot_area'])
                                                                        red
                                                                   @endif">
							<span class="dlabel">热点区域：</span>
							<div class="data">
								@if(!empty($data['now']['hot_area']))
									{{  $data['now']['hot_area'] }}
								@else
									全部
								@endif
							</div>
						</div>
						
						<div class="col-sm-4
                                                      @if($data['now']['w_start_time']!=$data['old']['w_start_time']||$data['now']['w_end_time']!=$data['old']['w_end_time'])
                                                            red
                                                        @endif ">
							<span class="dlabel">投放时段：</span>
							<span class="data">{{ $data['now']['w_start_time'] }}至{{ $data['now']['w_end_time'] }}</span>
						</div>
                                                <div class="col-sm-4 area
                                                      @if($data['now']['fans_tag']!=$data['old']['fans_tag'])
                                                            red
                                                        @endif ">
							<span class="dlabel">属性区域：</span>
							<div class="data">
								@if(!empty($data['now']['fans_tag']))
									{{ $data['now']['fans_tag'] }}
								@else
									全部
								@endif
							</div>
						</div>
						
						<div class="col-sm-4
                                                      @if($data['now']['sex']!=$data['old']['sex'])
                                                            red
                                                        @endif ">
							<span class="dlabel">性别属性：</span>
							 <span class="data">
                                                         @if($data['now']['sex'] == 0)
								全部
							@elseif($data['now']['sex'] == 1)
								男
                                                        @elseif($data['now']['sex'] == 2)
								女
                                                        @endif
                                                            
                                                        </span>
						</div>
                                                <div class="col-sm-4 area
                                                      @if($data['now']['scene']!=$data['old']['scene'])
                                                            red
                                                        @endif ">
							<span class="dlabel">场&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;景：</span>
							<div class="data">
								@if(!empty($data['now']['scene']))
									{{ $data['now']['scene'] }}
								@else
									全部
								@endif
							</div>
						</div>
                                                <div class="col-sm-4
                                                      @if($data['now']['device_type']!=$data['old']['device_type'])
                                                            red
                                                        @endif ">
							<span class="dlabel">设备类型：</span>
							 <span class="data">
                                                         @if($data['now']['device_type'] == 0)
								不限
							@elseif($data['now']['device_type'] == 1)
								iphone
                                                        @elseif($data['now']['device_type'] == 2)
								安卓
                                                        @endif
                                                            
                                                        </span>
						</div>
					</div>
				</div>
				@endif
				<ul class="other_info">
					<li>修改原因： @if(isset($data['old']['w_reason'] ))
                                            {{$data['old']['w_reason'] }}
                                            @endif</li>
					<li>备　　注：{{ $data['now']['w_desc'] }}</li>
				</ul>
                                <div class="btns">
					<button class="btn btn-blue pass" text="{{ $data['now']['id'] }}">通过</button>
					<button class="btn btn-red refuse">驳回</button>
					<button class="btn back" onclick="history.go(-1)">返回</button>
				</div>

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
                                        <a href="getworkorderlist?action=upda&stat=1&new=3&id={{ $data['now']['id'] }}"><button class="btn btn-sure" ">确定</button></a>
				</div>
			</div>
		</div>
                
                <form action="postWorkReject?stat=1&new=2" method="post" id="f-report">
                    <div class="cause" style="display: none;">
                            <div class="mask"></div>
                            <div class="causeMain">
                                    <p>驳回原因</p>
                                    <textarea name="reason"></textarea>
                                    <span class="tip causeTip">原因必填</span>
                                    <input type="type" name="wid" value="{{ $data['now']['id'] }}" style="display: none" />
                                    <div class="causebtn">
                                        <input type="submit" name="sub" value="111" style="display: none"/>
                                        <input type="hidden" name="_token"         value="{{  csrf_token()  }}"/>
                                            <input type="button" value="取消" class="cancel" />
                                            <input type="button" value="确认" class="sure"/>
                                    </div>
                            </div>
                    </div>
                </form>
	</body>
	<script type="text/javascript">
		$(function(){
			
		})
	</script>
</html>
