<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>门店添加</title>
        @include('Operate.common.head')
    </head>
	<body>
            @include('Operate.common.top')
		
		<div class="main clearfix">
            <!--左侧-->
            @include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<div class="header" style="border-bottom: 1px solid #cbcbcb;">门店添加</div>
				
				<form action="{{ URL::asset('index.php/operate/report/addauthByShop') }}" method="post" class="form">
                    {!! csrf_field() !!}
                    <input type="hidden" value="{{$rid}}" name="rid">
                    <div class="form-list">
						<label>公众号：</label><input value="{{$wxname}}" readonly="true" type="input" name="ghname" class="text-input"/>
                        <p class="tip exist" id="ghname_error" style="display: none;"></p>
                    </div>
					<div class="form-list">
						<label>门店名称：</label><input onblur="check_must_field('shopName','门店名称必填');" type="input" name="shopName" class="text-input"/>
                        <p class="tip exist" id="shopName_error" style="display: none;"></p>
                    </div>
					<div class="form-list">
						<label>SSID：</label><input onblur="check_must_field('ssid','SSID必填');" type="input" name="ssid" class="text-input"/>
                        <p class="tip exist" id="ssid_error" style="display: none;"></p>
					</div>
					<div class="form-list">
						<label>shopId：</label><input onblur="check_must_field('shopId','shopId必填');" type="input" name="shopId" class="text-input"/>
                        <p class="tip exist" id="shopId_error" style="display: none;"></p>
					</div>
					<div class="form-list">
						<label>appId：</label><input onblur="check_must_field('appId','appId必填');" type="input" name="appId" class="text-input"/>
                        <p class="tip exist" id="appId_error" style="display: none;"></p>
					</div>
					<div class="form-list">
						<label>secretKey：</label><input onblur="check_must_field('secretKey','secretKey必填');" type="input" name="secretKey" class="text-input"/>
                        <p class="tip exist" id="secretKey_error" style="display: none;"></p>
					</div>
					<div class="form-list">
						<label>原始ID：</label><input onblur="check_must_field('ghid','原始ID必填');" type="input" name="ghid" class="text-input"/>
                        <p class="tip exist" id="ghid_error" style="display: none;"></p>
					</div>
					<input type="button" value="添加" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
				</form>
			</div>
		</div>
	</body>
<script>
    //检查必填字段
    function check_must_field(id,msg){
        var mustField = $.trim($("input[name="+id+"]").val());
        if(mustField==''||mustField=='undefined'){
            $("#"+id+"_error").text(msg);
            $("#"+id+"_error").show();
            return false
        }
        $("#"+id+"_error").hide();
        return true;
    }

    //检测表单提交数据
    function checkForms(){
        var open = true;
        var checkwxname = check_must_field('shopName','门店名称必填');
        var checkssid = check_must_field('ssid','SSID必填');
        var checkshopid = check_must_field('shopId','shopId必填');
        var checkappid = check_must_field('appId','appId必填');
        var checksecretkey = check_must_field('secretKey','secretKey必填');
        var checkghid = check_must_field('ghid','原始ID必填');
        if(!checkwxname||!checkssid||!checkshopid||!checkappid||!checksecretkey||!checkghid){
            open = false;
        }
        return open;
    }

    $(document).ready(function(){
        $(".submit").click(function(){
            if(checkForms()){
                $(".submit").prop("disabled",true);
                $(".form").submit();
            }
        })
    })
</script>
</html>
