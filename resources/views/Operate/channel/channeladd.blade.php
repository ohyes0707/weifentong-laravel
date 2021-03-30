
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>用户管理-渠道列表-修改渠道</title>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}"/>	
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/common.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/public.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/page.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/statistics.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('operate/css/select.css') }}"/>
		<script src="{{ URL::asset('js/jquery-2.1.4.min.js') }}" type="text/javascript" charset="utf-8"></script>

                <link rel="stylesheet" type="text/css" href="{{ URL::asset('home/css/city-picker.css') }}"/>
            	<script src="{{ URL::asset('home/js/city-picker.data.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/city-picker.data1.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/jquery.tagsinput.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/city-picker.js') }}" type="text/javascript" charset="utf-8"></script>
		<script src="{{ URL::asset('home/js/city-picker1.js') }}" type="text/javascript" charset="utf-8"></script>
                
                <style type="text/css">
			.f_channel>td:nth-child(1){
				padding-left: 0;
				background: none;
			}
			.sub_channel>td:nth-child(1){
				padding-left: 0;
				background: none;
			}
			.sub_channel>td:nth-child(2){
				padding-left: 68px;
				background: url(../img/icon-open3.png) no-repeat 40px center;
			}
			
			.on_channel>td:nth-child(2){
				background: url(../img/icon-open2.png) no-repeat 10px center;
			}
			.off_channel>td:nth-child(2){
				background: url(../img/icon-close2.png) no-repeat 10px center;
			}
                        .prompt{
                                display: none;
                                padding-left: 20px;
                                color: red
                        }
                        .clearfix {
                            white-space: normal;
                        }
		.form-list{
			white-space: normal;
			width: 600px;
		}
		.form-list label{
			width: 120px;
		}
		.form-list .text-input{
			width: 400px;
		}
                /*区域选择*/
                div.text-input{
                        /*min-height: 80px;*/
                        height: auto;
                }

                .chosen-show {
                    width: 100%;
                    min-height: 39px;
                }
                .chosen-show>span, .chosen-show>a {
                    margin: 9px 0;
                    float: left;
                }
                .clear {
                    color: #d9534f;
                }
                .city-chosen {
                    float: left;
                }
                .choose {
                    height: 38px;
                    line-height: 38px;
                    position: relative;
                }

                span.tag {
                    position: relative;
                    margin: 5px 8px;
                }
                span.tag>span {
                        height: 30px;
                        line-height: 20px;
                    padding-right: 6px;
                    padding-left: 4px;
                    border: 1px solid #3EA9F5;
                    border-radius: 4px;
                    background: #fff;
                }
                span.tag a {
                    text-indent: -9999px;
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 16px;
                    height: 16px;
                    background: url({{ URL::asset('operate/img/icon23.png') }}) no-repeat center;
                }
                .city-picker-span {
                    border: 1px solid #cbcad8 !important;
                    width: 225px !important;
                    padding: 6px 3px 6px 12px !important;
                    font-size: 14px !important;
                    line-height: 1.42857143 !important;
                    vertical-align: middle !important;
                    background-clip: padding-box !important;
                    border-radius: 4px !important;
                    display: inline-block !important;
                    position: relative;
                    color: #555 !important;
                }
                .chosen-show span{
                        float: left;
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
				<div class="header">新增渠道</div>
				
				<form action="" method="post" class="form">
					<div class="form-list">
						<label>账号：</label><input type="input" name="account" placeholder="账号名称" class="text-input must-input" id="account"/>
                                                <span id="prompt-account" class="prompt">* 账号不能为空或已存在</span>
					</div>
					<div class="form-list">
						<label>密码：</label><input type="password" name="password" placeholder="初始密码默认为123456" class="text-input" disabled/>
					</div>
					<div class="form-list">
                                                <label>渠道名称：</label><input type="input" name="channelName" class="text-input must-input" id="channelName"/>
                                                <span id="prompt-channelname" class="prompt" style="position: absolute;">* 渠道名称不能为空或已存在</span>
                                        </div>
					<div class="form-list">
						<label>结算一口价：</label><input type="input" name="price" class="text-input must-input"/>
					</div>
					<div class="form-list">
						<label>扣量百分比：</label><input type="input" name="percentage" class="text-input"/>
					</div>
					<div class="form-list">
						<label>渠道简介：</label><textarea name="intro" class="text-input"></textarea>
					</div>
					<div class="form-list">
						<label>完成页：</label><input type="input" name="successPage" class="text-input must-input"/>
					</div>
					<div class="form-list">
						<label>连接完成页：</label><input type="input" name="connectPage" class="text-input must-input"/>
					</div>
					<div class="form-list">
						<label>热点名称：</label><input type="input" name="wifiName" class="text-input must-input"/>
					</div>
					<div class="form-list">
						<label>异常跳转页：</label><input type="input" name="abnormalPage" class="text-input"/>
					</div>
                                        <div class="form-list">
                                                    <label>支持热点区域：</label>
                                                            <div class="text-input">
                                                                <div class="chosen-show clearfix">

                                                                            <span>当前选择：</span>
                                                                            <a href="javascript: void(0);" class="clear">[清空已选]</a>
                                                                            <div class="city-chosen">
                                                                                    <input name="tags" id="tags" value="" />
                                                                            </div>
                                                                    </div>
                                                                    <div class="choose">
                                                                            <input class="form-control" readonly type="text" placeholder="请选择目标区域" id="city-picker1"/>
                                                                    </div>
                                                            </div>

                                                                <input type="text" name="hot_area"  value="" id="hot_area" style="display: none"/>

                                        </div>
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此渠道？
							</div>
							<div class="alertbtn">
                                                            <input type="hidden" name="_token"         value="{{  csrf_token()  }}"/>
								<input type="submit" class="btn btn-sure" value="确认"/>
								<button class="btn btn-cancel">取消</button>
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>	
	</body>
	<script type="text/javascript">
		$(function(){
                        //弹窗
			$('#account').change(function(){
                            var account = $('#account').val();
                            $.ajax({
                                    type:"get",
                                    data:{'keycode':account,'type':'account'},
                                    url:"ChannelQueryName",
                                    success: function(data){
                                        if(data==1){
                                            $('#prompt-account').css("display","initial");
                                        }else{
                                            $('#prompt-account').css("display","none");
                                        }
                                    }
                            });
			})
			$('#channelName').change(function(){
                            var account = $('#channelName').val();
                            $.ajax({
                                    type:"get",
                                    data:{'keycode':account,'type':'channelName'},
                                    url:"ChannelQueryName",
                                    success: function(data){
                                        if(data==1){
                                            $('#prompt-channelname').css("display","initial");
                                        }else{
                                            $('#prompt-channelname').css("display","none");
                                        }
                                    }
                            });
			})
			
			//弹窗
			$('.submit').click(function(){
				var phone=$('#account').val();
				var $inputs=$('.must-input');
				for(var i=0,len=$inputs.length;i<len;i++){
					if($inputs.eq(i).val() == ''){
						alert('请将信息填写完整');
						return false;
					}
				}
/*				if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
			        alert('手机号码格式不正确')  
			        return false; 
			    }*/
				$('.myalert').show()
			})
			
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide()
			})
			
			var $citypicker1=new CityPicker($('#city-picker1'),
				{
					ChineseDistricts:ChineseDistricts,
					nodistrict: true
				});
			
			

			$('#tags').tagsInput({
				width: 'auto',
				height: '38px',
			});
			$('#tags1').tagsInput({
				width: 'auto',
				height: '38px',
			});
			$('#tags_tag').hide();
			$('#tags1_tag').hide();
			
		})
	</script>
</html>

