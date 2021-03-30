<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>优粉通-商家系统-登录</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Business/css/common.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Business/css/index.css') }}"/>
    <script src="{{ URL::asset('js/jquery-2.1.4.min.js') }}" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="nav"></div>
<div class="main">
    <div class="logo">
        <a href="javascript: void(0);"><img src="{{ URL::asset('Business/img/logo.png') }}"/></a>
    </div>
    <div class="content clfix">
        <div class="con-left">
            <img src="{{ URL::asset('Business/img/login_pic.png') }}"/>
            <p>微信公众号专业涨粉交易平台</p>
        </div>
        <div class="con-right">
            <div class="login">
                <div class="login-logo"><img src="{{ URL::asset('Business/img/logo.png') }}"/></div>
                <h3 class="head">商家系统</h3>
                <form action="" method="post" id="f-login" class="user_login">
                    {!! csrf_field() !!}
                    <div class="input">
                        <input name="username" type="text" placeholder="请输入您的账号" class="text-input account" />
                        <p class="tip usertip note_username" style="display: none;"></p>
                    </div>
                    <div class="input">
                        <input name="password" type="password" placeholder="请输入您的账户密码" class="text-input pwd"/>
                        <p class="tip usertip note_password" style="display: none;"></p>
                    </div>
                    <div class="input clfix">
                        <input name="captcha" type="text" placeholder="验证码" class="code-input captcha_class"/>
                        <div class="codeimg">
                            <img id="captcha" src="{{ url('/captcha') }}" onclick="Refresh_captcha()"/>
                            <a href="javascript:;"  onclick="Refresh_captcha()">看不清？换一张</a>
                        </div>
                        <p class="tip usertip note_captcha" style="display: none;width: 244px;float: left;margin-top: -20px;"></p>
                    </div>
                    <div class="remember">
                        {{--<label for=""><input type="checkbox"/>记住账号</label>--}}
                    </div>
                    <input type="button" value="登　录" class="submit"/>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function Refresh_captcha(){
        $("#captcha").attr('src',"{{ url('/captcha') }}?r="+Math.random());
    }

    function doLogin(){
        $.post("{{action('Business\UserController@doLogin')}}",$(".user_login").serialize(),function(res){
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
</script>
</body>
</html>
