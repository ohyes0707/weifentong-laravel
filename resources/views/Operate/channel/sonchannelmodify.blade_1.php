
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>用户管理-渠道列表-新增渠道</title>
		@include('Operate.common.head')	
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
						<label>所属父渠道：</label><span>{{$pbname}}</span>
					</div>
					<div class="form-list">
                                            <label>账号：</label><input type="input" name="account" placeholder="手机号码" class="text-input must-input" id="account" value="{{$bussiness['username']}}"/>
                                                <span id="prompt-account" class="prompt">* 账号不能为空或已存在</span>
					</div>
					<div class="form-list">
						<label>密码：</label><input type="checkbox" name="resetPwd">重置为初始密码123456
					</div>
					<div class="form-list">
                                            <label>渠道名称：</label><input type="input" name="channelName" class="text-input must-input" id="channelName" value="{{$bussinfo['nick_name']}}"/>
                                                <span id="prompt-channelname" class="prompt">* 渠道名称不能为空或已存在</span>
                                        </div>
					<div class="form-list">
						<label>结算一口价：</label><input type="input" name="price" class="text-input must-input" value="{{$bussiness['cost_price']}}"/>
					</div>
					<div class="form-list">
						<label>扣量百分比：</label><input type="input" name="percentage" class="text-input" value="{{$bussiness['reduce_percent']}}"/>
					</div>
					<div class="form-list">
						<label>渠道简介：</label><textarea name="intro" class="text-input" >{{$bussinfo['description']}}</textarea>
					</div>
					<div class="form-list">
						<label>完成页：</label><input type="input" name="successPage" class="text-input must-input"  value="{{$bussinfo['shangjia_url']}}"/>
					</div>
					<div class="form-list">
						<label>连接完成页：</label><input type="input" name="connectPage" class="text-input must-input" value="{{$bussinfo['complate_page']}}"/>
					</div>
					<div class="form-list">
						<label>热点名称：</label><input type="input" name="wifiName" class="text-input must-input" value="{{$bussiness['ssid']}}"/>
					</div>
					<div class="form-list">
						<label>异常跳转页：</label><input type="input" name="abnormalPage" class="text-input" value="{{$bussinfo['exception_url']}}"/>
					</div>
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否保存此修改？
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认"/>
								<button class="btn btn-cancel">取消</button>
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
                    var old_username = "{{$bussiness['username']}}";
                    var old_nickname = "{{$bussinfo['nick_name']}}";
                    var allow = 1;
			
                        //弹窗
			$('#account').change(function(){
                            var account = $('#account').val();
                            if(old_username == account){
                                
                            }else{
                                $.ajax({
                                        type:"get",
                                        data:{'keycode':account,'type':'account'},
                                        url:"ChannelQueryName",
                                        success: function(data){
                                            if(data==1){
                                                allow = 0;
                                                $('#prompt-account').css("display","initial");
                                            }else{
                                                $('#prompt-account').css("display","none");
                                            }
                                        }
                                });
                            }

			})
			$('#channelName').change(function(){
                            var account = $('#channelName').val();
                            if(old_nickname == account){
                                
                            }else{
                                $.ajax({
                                        type:"get",
                                        data:{'keycode':account,'type':'channelName'},
                                        url:"ChannelQueryName",
                                        success: function(data){
                                            if(data==1){
                                                allow = 0;
                                                $('#prompt-channelname').css("display","initial");
                                            }else{
                                                $('#prompt-channelname').css("display","none");
                                            }
                                        }
                                });
                            }

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
//				if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){ 
//			        alert('手机号码格式不正确')  
//			        return false; 
//			    }
                                if(allow == 0){
                                    return false;
                                }
				$('.myalert').show()
			})
			
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide()
			})
			
			
			
		})
	</script>
</html>

