 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
                <meta HTTP-EQUIV="pragma" CONTENT="no-cache">    
                <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">    
                <meta HTTP-EQUIV="expires" CONTENT="0">  
		<title>申请工单</title>
 		@include('Agent.common.head')
                <link rel="stylesheet" type="text/css" href="{{ URL::asset('home/css/city-picker.css') }}"/>
            	<script src="{{ URL::asset('home/js/city-picker.data.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/city-picker.data1.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/jquery.tagsinput.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/city-picker.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/city-picker1.js') }}" type="text/javascript" charset="utf-8"></script>
                              <script src="{{ URL::asset('home/js/function.js') }}" type="text/javascript" charset="utf-8"></script>
                <script type="text/javascript">
                
                    if(window.name!="hasLoad"){    
                         location.reload();    
                         window.name = "hasLoad";    
                     }else{    
                         window.name="";    
                     } 
                     minPrice={{$olderprice}};
                     function priceCompare(price){
                            if(price < {{$olderprice}}){
                                    $('.amountTip').show()
                            }else{
                                    $('.amountTip').hide()
                            }
                    }
                </script>
	</head>
	<body>
		@include('Agent.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		@include('Agent.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="header">申请工单</div>
				<div class="process clearfix">
					<div class="step active">
						<img src="{{ URL::asset('home/img/icon_big3.png') }}"/>
						<p>申请报备</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big6.png') }}" class="icon-step"/>
					<div class="step active">
						<img src="{{ URL::asset('home/img/icon_big5.png') }}"/>
						<p>客户授权</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big4.png') }}"/>
						<p>审核下单</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big2.png') }}"/>
						<p>报备成功</p>
					</div>
				</div>
				@if($worderinfo['w_status']==2)
       
                                                               
                                <div class="rejectReason" style="">
						<p class="f_head" style="margin-bottom: 0px">审核失败原因</p>
                                                <div class="reason_con" style="width: 100%;padding: 20px;border: 1px solid #ccc;border-radius: 4px;margin-bottom: 20px;">{{  $worderinfo['w_reject']  }}</div>
					</div>
                                @endif
                                <form action="geteditworkorder" method="post" class="f_order" id="myform">
                                    
					<div class="f_primary">
                                            <input type="hidden" name="id" value="{{  $worderinfo['id']  }}"/>
						<p class="f_head" style="margin-bottom: 0px">基础设置（*必选）</p>
						<div class="f_con">
							
							<div class="f-line clearfix">
								<div class="f-group col-sm-12 col-md-6 col-lg-3">
									<label>
									 	公众号：
                                                                        </label>
                                                                                @if($worderinfo['isorder']==0)
                                                                                <select name="gzh" class="form-input" id="gzh">
                                                                                    <option value="0">请选择</option>
                                                                                    @if(count($wx_name)>0)
										    @foreach ($wx_name as $wx)
                                                                                    <option value="{{ $wx['id'] }},{{ $wx['wx_name'] }},{{ $wx['wx_id'] }}"
                                                                                            @if ($worderinfo['report_id']  == $wx['id'])
                                                                                                selected = "selected"
                                                                                            @endif
                                                                                            >{{ $wx['wx_name'] }}</option>
                                                                                    @endforeach
                                                                                    @endif
										</select>
                                                                                @else
                                                                                {{ $worderinfo['wx_name'] }}
                                                                                @endif				    
								</div>
								<div class="f-group col-sm-12 col-md-6 col-lg-3">
									<label class="word4">
                                                                            打款金额：
                                                                        </label>  
                                                                            @if($worderinfo['isorder']==0)
                                                                            <input min="0" name="user_money" type="number" value="{{  $worderinfo['w_user_money']  }}" class="form-input sum" onblur="calculate()"/>
                                                                            @else
                                                                            {{  $worderinfo['w_user_money']  }}
                                                                            @endif
                                                                        	<p class="amountTip" style="display: none;">单价必须大于保底单价</p>				    
								</div>
								<div class="f-group col-sm-12 col-md-6 col-lg-6">
									<label class="word4">
										投放时间：
									</label>
                                                                    
                                                                        <input name="start_date" type="text" value="{{  $worderinfo['w_start_date']  }}" class="form-input" id="dateStart" readonly/>
						
									<span>
										至 
									</span> 
                                                                        <input name="end_date" type="text" value="{{  $worderinfo['w_end_date']  }}" class="form-input" id="dateEnd" readonly/>
									
								</div>
							</div>
							
							<div class="f-line clearfix">
								<div class="f-group col-sm-12 col-md-6 col-lg-3">	
									<label class="word4">
                                                                            总涨粉量：
                                                                        </label>
                                                                            @if($worderinfo['isorder']==0)
                                                                            <input  min="0" name="total_fans" type="number" value="{{  $worderinfo['w_total_fans']  }}" class="form-input allfans" onblur="disableInput()" />
                                                                            @else
                                                                            <input  min="0" type="number" class="form-input allfans" disabled value="{{  $worderinfo['w_total_fans']  }}"/>
                                                                            
                                                                            @endif
                                                                          					    
								</div>
								
                                                                <div class="f-group col-sm-12 col-md-6 col-lg-3">
									<label>
                                                                            单价：
                                                                        </label>
                                                                            @if($worderinfo['isorder']==0)
                                                                            <input min="0" name="per_price" type="number"  value="{{  $worderinfo['w_per_price']  }}" class="form-input price" onblur="sum()"/>
                                                                            @else
                                                                            {{  $worderinfo['w_per_price']  }}
                                                                            @endif
									
									<br><span class="price-tip">（单月所有订单的平均单价为：¥<em>{{$olderprice}}</em>）</span>
								</div>
                                                            <div class="f-group col-sm-12 col-md-6 col-lg-5">
									<label class="word4">
										投放时段：
									</label>
                                                                            <input name="start_time" type="text"  class="form-input" id="timeStart" data-date-format="hh:ii" data-link-format="hh:ii" value="" readonly/>
									
									<span>
										至 
									</span>
                                                                             <input type="text" name="end_time" class="form-input" id="timeEnd" data-date-format="hh:ii" data-link-format="hh:ii" readonly/>
									<p class="tip" style="font-size: 14px;">（最小投放时间段为5分钟）</p>
								</div>
								
							</div>
							
							<div class="f-line clearfix">
								
                                                            <div class="f-group col-sm-12 col-md-6 col-lg-6">
									<label class="word4">
										每日涨粉：
                                                                        </label>
                                                                        <input name="least_fans" min="0" type="number" value="{{  $worderinfo['w_least_fans']  }}" class="form-input minimum" placeholder="保底量" onblur="compare()"/>
									
									<span>
										至
									</span> <input name="max_fans" min="0" type="number" value="{{  $worderinfo['w_max_fans']  }}" class="form-input maximum" placeholder="最高量" onblur="compare()" />
										
									<span>
										建议量：
									</span>
                                                                        <input name="advis_fans" min="0" type="number" value="{{  $worderinfo['w_advis_fans']  }}" class="form-input suggest" onblur="compare()"/>
									<p class="compareTip" style="display: none;">输入有误，保底量&lt;=建议量&lt;=最高量&lt;=总涨粉量</p>
								</div>
                                                            <div class="f-group col-sm-12 col-md-6 col-lg-6">
                                                                        <span>
										设备类型：
									</span>
                                                                        <select name="device_type" class="form-input">
                                                                            <option value ="0">不限</option>
                                                                            <option value ="1"
                                                                                    @if($worderinfo['device_type']==1)
                                                                                        selected
                                                                                    @endif
                                                                                    >iphone</option>
                                                                            <option value ="2"
                                                                                    @if($worderinfo['device_type']==2)
                                                                                        selected
                                                                                    @endif
                                                                                    >安卓</option>
                                                                         </select>
									
                                                            </div>
							</div>
							
							
						</div>
					</div>
					
					<div class="f_property">
						<p class="f_head" style="margin-bottom: 0px">属性设置（如不选择，则默认全部）</p>
						<div class="f_con_2" style="border: none; position"> 
                                                    <div style="position: absolute;z-index: 999;left:100px; line-height: 180px;">多选要求</div>
							<ul style="border: 1px solid #ccc">
                                                                <li class="t-sm" style=" border: none">
                                                                    <div class="t-left col-sm-2" style="border: none">
										
									</div>
									<div class="t-right col-sm-10 clearfix" >
										<label class="label-radio fl">
											<input type="radio" name="multiple" value="2" 
                                                                                               @if ($worderinfo['check_status'] == 2)
                                                                                                            checked
                                                                                                @endif />满足全部
										</label>
										<label class="label-radio fl">
											<input type="radio" name="multiple" value="1" 
                                                                                                @if ($worderinfo['check_status'] == 1)
                                                                                                            checked
                                                                                                @endif />满足其一
										</label>
										<div class="explain fl">
											<span></span>
											<div class="exbox">
												<p>满足其一：属性设置中的热点区域、粉丝标签满足其中一条</p>
												<p>满足全部：属性设置中的热点区域、粉丝标签全部满足</p>
											</div>
										</div>
									</div>
								</li>
								<li class="t-lg clearfix" style="border-bottom:none">
									<div class="t-left col-sm-2">
												
									</div>
									<div class="t-right col-sm-10" style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;">
                                                                           <div class="ddleft" style="width: 20%;line-height: 80px;float: left;text-align: center">热点区域</div>
                                                                            <div class="ddright" style="width: 80%;float: left">
										<div class="sub-right chosen-show clearfix">
											<span>当前选择：</span>
											<a href="javascript: void(0);" class="clear">[清空已选]</a>
											<div class="city-chosen">
												<input name="tags" id="tags" value="{{ $hot_area }}" />
											</div>
										</div>
										<div class="sub-right choose">
											<input class="form-control" readonly type="text" placeholder="请选择目标区域" id="city-picker1"/>
                                                                                
										</div>
                                                                            <input type="text" name="hot_area" value='{{ $hot_area }}' id="hot_area" style="display: none"/>
                                                                            </div>
                                                                        </div>
								</li>
								<li class="t-lg clearfix" style="border-top: none;margin-top: 0px;">
									<div class="t-left col-sm-2" style="border: none">
												
									</div>
									<div class="t-right col-sm-10">
                                                                                                                <div class="ddleft" style="width: 20%;line-height: 80px;float: left;text-align: center">粉丝标签</div>
                                                                            <div class="ddright" style="width: 80%;float: left">
										<div class="sub-right chosen-show clearfix">
											<span>当前选择：</span>
											<a href="javascript: void(0);" class="clear">[清空已选]</a>
											<div class="label-chosen">
												<input name="tags" id="tags1" value="{{ $fans_tag }}" />
											</div>
										</div>
										<div class="sub-right choose">
											 <input class="form-control" readonly type="text" placeholder="请选择目标区域" id="city-picker2">
										</div>
                                                                            <input type="text" name="fans_tag" value='{{ $fans_tag }}' id='fans_tag' style="display: none"/>
									</div></div>
								</li>
                                                            </ul>
                                                            
                                                            <ul  style="border: 1px solid #ccc;margin-top: 30px">
								<li class="t-sm">
									<div class="t-left col-sm-2">
										性别要求
									</div>
									<div class="t-right col-sm-10">
										<label class="label-radio">
											<input type="radio" name="sex" value="0" 
                                                                                                @if ($worderinfo['sex'] == 0)
                                                                                                            checked
                                                                                                @endif
                                                                                               
                                                                                               />全部
										</label>
										<label class="label-radio">
											<input type="radio" name="sex" value="1" 
                                                                                                @if ($worderinfo['sex'] == 1)
                                                                                                            checked
                                                                                                @endif />男
										</label>
										<label class="label-radio">
											<input type="radio" name="sex" value="2" 
                                                                                                @if ($worderinfo['sex'] == 2)
                                                                                                            checked
                                                                                                @endif
                                                                                               />女
										</label>
									</div>
								</li>
                                                                <li class="t-sm"  style="border-bottom: 1px solid #ccc;">
									<div class="t-left col-sm-2">
										设备属性
									</div>
									<div class="t-right col-sm-10">
										<label class="label-radio">
											<input type="radio" name="device_type" value="0" 
                                                                                                @if ($worderinfo['device_type'] == 0)
                                                                                                            checked
                                                                                                @endif
                                                                                               
                                                                                               />不限
										</label>
										<label class="label-radio">
											<input type="radio" name="device_type" value="1" 
                                                                                                @if ($worderinfo['device_type'] == 1)
                                                                                                            checked
                                                                                                @endif />iphone
										</label>
										<label class="label-radio">
											<input type="radio" name="device_type" value="2" 
                                                                                                @if ($worderinfo['device_type'] == 2)
                                                                                                            checked
                                                                                                @endif
                                                                                               />安卓
										</label>
									</div>
								</li>
                                                                <li class="clearfix bd-bottom scenes" style="border-bottom:  1px solid #ccc;margin-top: 0px;border-top: none">
									<div class="t-left col-sm-2">
												场景
									</div>
									<div class="t-right col-sm-10">
										<div class="sceneslist">
                                                                                     @foreach ($sceneList as $scene)
                                                                                        <label class="check-label">
												<input type="checkbox" name="scene[]"
                                                                                                        @if ($scene['es'] == 2)
                                                                                                            checked
                                                                                                        @endif
                                                                                                       value="{{ $scene['id'] }}"/>{{ $scene['scene_name'] }}
											</label>
                                                                                    @endforeach
											
										</div>
									</div>
								</li>
                                                                <li class="t-sm remark" style=" margin-top: 0px;border-top: 0px">
									<div class="t-left col-sm-2" style="border-right: none">
										备注
									</div>
									<div class="t-right col-sm-10">
										<textarea name="remark" placeholder="请填写......" style="border: none">{{  $worderinfo['w_desc']  }}</textarea>
									</div>
								</li>
<!--                                                                @if($worderinfo['w_status']==2)
                                                                <li class="t-sm remark">
									<div class="t-left col-sm-2">
										失败原因
									</div>
									<div class="t-right col-sm-10">
										{{  $worderinfo['w_reject']  }}
									</div>
								</li>
                                                                @endif-->
							</ul>
						</div>
					</div>
                                @if (session('msg'))
                                <div class="alert alert-success">
                                    {{ session('msg') }}
                                </div>
                            @endif
                            {!! $errors->first('w_total_fans')!==null?$errors->first('w_total_fans'):''!!}
					<div class="formbtn">
                                            <input type="submit" name="sub" value="111" style="display: none"/>
                                                <input type="hidden" name="_token"         value="{{  csrf_token()  }}"/>
						<input type="button" value="提交" class="submit" onclick="editorder()"/>
						<input type="button" value="取消" class="cancel" onclick="history.go(-1)"/>
					</div>
                                        <div class="cause" style="display: none;">
                                                        <div class="mask"></div>
                                                        <div class="causeMain">
                                                                <p>请输入修改原因</p>
                                                                <textarea name="reason"></textarea>
                                                                <span class="tip causeTip">原因必填</span>
                                                                <div class="causebtn">
                                                                        <input type="button" value="取消" class="cancel" onclick="cancelChange()"/>
                                                                        <input type="button" value="确认" class="submit" onclick="sub_order()"/>
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
					您输入的数值有误，建议量&lt;=保底量&lt;=最高量&lt;=总涨粉量。<br />请核对后重新输入！
				</div>
			</div>
		</div>
               
                
	</body>
	<script type="text/javascript">
//            function (){
//                var value="";
//                var inner = $("#tags_tagsinput").find('span').eq(1).html();
//                var length = $("#tags_tagsinput").find('.tag').length;
//                var key;
//                for (var i=1;i<=$("#tags_tagsinput").find('.tag').length;i++)
//                {
//                    key=i*2-1;
//                    var str = $("#tags_tagsinput").find('span').eq(key).html().replace('&nbsp;&nbsp;', "");
//                    var index = str .lastIndexOf("\/");  
//                    str  = str .substring(index + 1, str .length);
//                    console.log(str);
//                }
//            }
		$(function(){
			
			//选择日期
			$("#dateStart").datetimepicker({
				format: 'yyyy-mm-dd',
				minView:'month',
				language: 'zh-CN',
				autoclose:true,
			}).on("click",function(){
				$("#dateStart").datetimepicker("setEndDate",$("#dateEnd").val())
			});
			$("#dateEnd").datetimepicker({
				format: 'yyyy-mm-dd',
				minView:'month',
				language: 'zh-CN',
				autoclose:true,
			}).on("click",function(){
				$("#dateEnd").datetimepicker("setStartDate",$("#dateStart").val())
			});
			$('#timeStart').datetimepicker({
		        language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 1,
				minView: 0,
				maxView: 1,
				forceParse: 0
		    })//.on("click",function(){
			//	$("#timeStart").datetimepicker("setEndDate",$("#timeEnd").val())
			//});
			$('#timeEnd').datetimepicker({
		        language:  'fr',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 1,
				minView: 0,
				maxView: 1,
				forceParse: 0
		    })//.on("click",function(){
			//	$("#timeEnd").datetimepicker("setStartDate",$("#timeStart").val())
			//});
			var $citypicker1=new CityPicker($('#city-picker1'),
				{
					ChineseDistricts:ChineseDistricts,
					nodistrict: true
				});
			
			var $citypicker2=new CityPicker1($('#city-picker2'),
				{
					ChineseDistricts:ChineseDistricts1,
					nodistrict: true
				})
			

			$('#tags').tagsInput({
				width: 'auto',
				height: '38px',
			});
			$('#tags1').tagsInput({
				width: 'auto',
				height: '38px'
			});
                    //    $('#tags').importTags('foo,bar,baz');
			$('#tags_tag').hide();
			$('#tags1_tag').hide();
		
                    $("#timeStart").val("{{ $worderinfo['w_start_time'] }}");
                    $("#timeEnd").val("{{ $worderinfo['w_end_time'] }}");
                        
		})
                  
	</script>
        <script type="text/javascript">
		//左边菜单栏切换
		var a=false;
		function menuToggle(){
			a = !a;
			if(a){
				$('.close-folder').hide();
				$('.open-folder').show();
				$('.bottom-arrow').hide();
				$('.top-arrow').show();
				$('.menu-list').show();
			}else{
				$('.close-folder').show();
				$('.open-folder').hide();
				$('.bottom-arrow').show();
				$('.top-arrow').hide();
				$('.menu-list').hide();
			}
		}
		
		function selectItem(){
			var str='';
			var items=$('td input[type=checkbox]:checked');
			console.log(items)
			items.each(function(){
				var $text=$(this).parents('tr').find('td').eq(2).text();
				str+='<span>'+$text+'</span>'
			})
			return str;
		}
	</script>
</html>
