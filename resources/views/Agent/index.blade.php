<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>首页</title>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('Agent/css/swiper.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('Agent/css/index.css') }}"/>
	</head>
	<body>
		<!--导航-->
		<div class="nav">
			<div class="header">
				<div class="logo">
                    <a href="index.html">
                        <img @if(isset($agent_info) && !empty($json_img['l'])) src="{{$json_img['l']}}" @else src="" @endif/> 
                    </a>
                </div>
				<div class="line"></div>
				<div class="font_24">@if(isset($agent_info) && !empty($agent_info['production'])) {{$agent_info['production']}} @else 产品名 @endif</div>
			</div>
			<ul class="navigator">
				<li class="active">
					<a href="javascript:void(0)" onclick="subgo()" target="_self" id="souye">首页<div class="bottom_line"></div></a>
				</li>
				<li><a href="javascript:void(0)" onclick="subgo1()" target="_self" id="guanyuwomen">关于我们<div class="bottom_line"></div></a></li>
				<li><a href="javascript:void(0)" onclick="subgo2()" target="_self" id="lianxiwomen">联系我们<div class="bottom_line"></div></a></li>
			</ul>
			<div class="login"><a href="javascript: toggle()">登录</a></div>
		</div>
		
		<!--轮播start-->
		<div class="swiper-container" >
	        <div class="swiper-wrapper">
                @if(isset($agent_info) && !empty($index_banner_imgs)) 
                    @foreach ($index_banner_imgs as $key => $imglist)
                        <div class="swiper-slide"><img src="{{$imglist}}"/></div>
                    @endforeach
                @else 
                    <div class="swiper-slide"><img src="http://pic1.win4000.com/wallpaper/b/579181d47ecd6.jpg"/></div>
                    <div class="swiper-slide"><img src="http://pic1.win4000.com/wallpaper/b/579181dce00eb.jpg"/></div>
                    <div class="swiper-slide"><img src="http://pic1.win4000.com/wallpaper/b/579181d8f0b87.jpg"/></div>

                @endif
	            
	        </div>
	        
	       	<!--分页器-->
	        <!--<div class="swiper-pagination"></div>-->
	        
	       	<!--左右按钮-->
	        <div class="swiper-button-prev"></div>
    		<div class="swiper-button-next"></div>
	    </div>
        <!--轮播end-->
        
        <!--关于我们start-->
        <div class="about_img" style='display: none;'>
            <img @if(isset($agent_info) && !empty($json_img['c'])) src="{{$json_img['l']}}" @else src="http://pic1.win4000.com/wallpaper/b/579181d47ecd6.jpg"@endif/>
        </div>
        
        <div class="about_container" style='display: none;'>
            <h2 class="title">@if(isset($agent_info) && !empty($agent_info['company'])) {{$agent_info['company']}} @else 北京容大科技有限公司 @endif</h2>
            
            @if(isset($agent_info) && !empty($agent_info['description'])) 
                <p class="paragraph">{{$agent_info['description']}} </p>
            @else 
                <p class="paragraph">北京容大友信科技有限公司，（简称“容大友信”）是一家与中国移动、中国联通、中国电信合作从事企业短信、企业彩信等通信传媒应用服务的提供商。 “海纳百川，有容乃大；壁立千仞，无欲则刚”是公司成立之初的宗旨，公司成立于2005年5月，通过多年持续的技术创新和迅速的市场拓展，“容大友信”汇聚了行业内的大量专业人才，公司核心管理团队拥有多年的行业经验以及对产业发展的深入理解。凭借成熟稳健的管理团队，业内领先的技术实力，经验丰富的营销队伍，完善的服务体系，以及良好如一的用户信誉，容大友信正在全力打造中国短信服务产业的新品牌。容大友信已经成为企业无线传媒商务应用的信赖伙伴。主要面向移动终端用户及企业提供基于GSM/CDMA/GPRS/SMS/MMS/WAP通信网络并覆盖所有用户（联通、移动及小灵通）的完整的无线移动商务应用服务和技术解决方案。</p>
                <p class="paragraph">目前，容大友信已拥有中石化、宝钢集团、金吉列、清华大学、SOHO中国、恒大集团、三星、天猫、淘宝、尚品网、苏宁、华联、新世界、百利金珠宝、中国纺织协会、红星美凯龙、F团、中共团中央、上海市信息中心、上海市委宣传部、中国医学基金会、上海医学会、上海闵行、虹桥镇政府等众多国内外知名企事业单位客户。销售和服务网络已经覆盖全国31个省、市、自治区，容大旗下已有上海容润信息有限公司等多家分公司和众多加盟合作伙伴，产品覆盖30余个行业，超过30万家企业客户。成为目前销售网络覆盖最广、服务经验最丰富、客户最多的企业之一。</p> 

            @endif
            
        </div>
        <!--关于我们end-->
        
        <!--联系我们start-->
        <div class="contact_container" style='display: none;'>
            <div class="content">
                <div class="contact_top">
                    <div class="link_way">
                        <div class="link_phone">
                            <div class="link_title">联系电话<span class="icon_phone"></span></div>
                            <div class="link_number">@if(isset($agent_info) && !empty($agent_info['phone'])) {{$agent_info['phone']}} @else 4000-123-456 @endif</div>
                        </div>
                        <div class="link_qq">
                            <div class="link_title">QQ<span class="icon_qq"></span></div>
                            <div class="link_number">@if(isset($agent_info) && !empty($agent_info['qq_bumber'])) {{$agent_info['qq_bumber']}} @else 4000-123-456 @endif</div>
                        </div>
                    </div>
                    <div class="contact_text">
                        <div class="chinese">联系我们</div>
                        <div class="english">CONTACT US</div>
                    </div>
                </div>
                <div class="address">
                    <p id="company">@if(isset($agent_info) && !empty($agent_info['company'])) {{$agent_info['company']}} @else 北京容大科技有限公司 @endif</p>
                    <p id="address">@if(isset($agent_info) && !empty($agent_info['address'])) {{$agent_info['address']}} @else 地址：北京市海淀区 @endif</p>
                </div>
            </div>
        </div>
        <!--联系我们end-->
	    
	    <div class="footer">
	    	<p class="copyright">Copyright © 2016 All Rights Reserved</p>
	    	<p class="company">@if(isset($agent_info) && !empty($agent_info['company'])) {{$agent_info['company']}} @else 北京容大科技有限公司 @endif</p>
	    </div>
	    
	    <div class="login_container">
	    	<div class="login_main">
	    		<form action="" method="post" id="login_form" class="user_login">
	    		{!! csrf_field() !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
	    			<ul>
	    				<li>
	    					<div class="input_container">
	    						<label class="form_label">用户名</label>
	    						<input type="text" name="username" id="username" class="input_text"/>
	    						<p class="tip usertip note_username" style="display: none;"></p>
	    						<!-- <p class="tip">手机号码不正确</p> -->
	    					</div>
	    				</li>
	    				<li>
	    					<div class="input_container">
	    						<label class="form_label">密码</label>
	    						<input type="password" name="password" id="password" class="input_text"/>
	    						<p class="tip usertip note_password" style="display: none;"></p>
	    						<!-- <p class="tip">密码不正确</p> -->
	    					</div>
	    				</li>
	    				<li>
	    					<div class="input_container">
	    						<label class="form_label">验证码</label>
		    					<div class="clearfix">
		    						<input type="text" name="captcha" id="code" class="input_text code_input"/>
		    						<img id="captcha" src="{{ url('/captcha') }}" class="security_code" onclick="Refresh_captcha()"/>
		    						<br/>
		    						<br/>
		    						<a style="font-size: 15px " href="javascript:;"  onclick="Refresh_captcha()"> &emsp;&emsp;看不清？换一张</a>
		    					</div>
		    					<p class="tip usertip note_captcha" style="display: none;width: 244px;float: left;margin-top: -20px;"></p>
		    					<!-- <p class="tip">验证码不正确</p> -->
	    					</div>
	    					
	    				</li>
	    			</ul>
	    			<input type="button" value="登　录" class="submit login_btn"/>
		    	</form>
	    	</div>
	    	
	    </div>
	</body>
	<script src="{{ URL::asset('js/jquery-2.1.4.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ URL::asset('Agent/js/swiper.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(function(){
			//图片轮播
			var mySwiper = new Swiper ('.swiper-container', {
				autoplay: 3000,//可选选项，自动滑动
				loop : true,
	//			pagination: '.swiper-pagination',
	//			paginationClickable: true,
				autoplayDisableOnInteraction : false,
			    // 前进后退按钮
			    nextButton: '.swiper-button-next',
			    prevButton: '.swiper-button-prev',
			    speed: 1000
	  		})
			//输入手机号码
			$('#username').on('input propertychange',function(){
				checkPhone()
			})
		})
		  
	</script>
	<script type="text/javascript">
		//登录框显示隐藏
		function toggle(){
			var $login_container=$('.login_container')
			if($login_container.is(':hidden')){
				$login_container.show()
			}else{
				$login_container.hide()
			}
		}
		//验证手机号
		function checkPhone(){
			var  reg= /^(13|14|15|18|17)\d{9}$/; 
			var mobile=$('#username').val();
			var $tip=$('#username').parents('li').find('.tip')
			if(!reg.test(mobile)){
				$tip.show();
				return false;
			}else{
				$tip.hide()
			}
			
		}


		function Refresh_captcha(){
            $("#captcha").attr('src',"{{ url('/captcha') }}?r="+Math.random());
        }

		function doLogin(){
            $.post("{{ url('agent/user/login') }}",$(".user_login").serialize(),function(res){
                $(".note_captcha").hide();
                $(".note_username").hide();
                $(".note_password").hide();
                if(res.code!=1000){
                    if(!$.isEmptyObject(res.data)){
                        var obj = res.data;
                        if(obj.captcha&&obj.captcha!='undefined'){
                            $(".note_captcha").text(obj.captcha[0]);
                            $(".note_captcha").show();
                            Refresh_captcha();
                        }
                        if(obj.login&&obj.login!='undefined'){
                            alert(obj.login[0]);
                            $(".note_username").text(obj.login[0]);
                            $(".note_username").show();
                        }
                        if(obj.username&&obj.username!='undefined'){
                            $(".note_username").text(obj.username[0]);
                            $(".note_username").show();
                        }
                        if(obj.password&&obj.password!='undefined'){
                            $(".note_password").text(obj.password[0]);
                            $(".note_password").show();
                        }

                    }
                }else{
                    window.location.reload();
                }
            },"json")
        }

		$(document).ready(function(){
            $(".submit").click(function(){
                doLogin();
            })

            //键盘 enter键登录  键盘事件
            $(window).keydown(function(event){
                if(event.keyCode==13){
                    doLogin();
                }
            })


        })

        function subgo(){
            $(".swiper-container").css("display","block")
            $(".about_img").css("display","none")
            $(".about_container").css("display","none")
            $(".contact_container").css("display","none")
            $("#souye").parent().attr("class","active")
            $("#guanyuwomen").parent().attr("class","")
            $("#lianxiwomen").parent().attr("class","")
            
        }
        function subgo1(){
            $(".swiper-container").css("display","none")
            $(".about_img").css("display","block")
            $(".about_container").css("display","block")
            $(".contact_container").css("display","none")
            $("#souye").parent().attr("class","")
            $("#guanyuwomen").parent().attr("class","active")
            $("#lianxiwomen").parent().attr("class","")
        }
        function subgo2(){
            $(".swiper-container").css("display","none")
            $(".about_img").css("display","none")
            $(".about_container").css("display","none")
            $(".contact_container").css("display","block")
            $("#souye").parent().attr("class","")
            $("#guanyuwomen").parent().attr("class","")
            $("#lianxiwomen").parent().attr("class","active")
        }
	</script>
</html>
