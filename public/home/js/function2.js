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

//登录页用户名检测
function userCheck(){
	var username=$('.account').val();
	if(username == ''){
		$('.usertip').html('请输入用户名').show();
		return false;
	}else{
		$('.usertip').hide();
	}
	$.post('',{'username':username},function(res){
		if(res){
			//用户名不存在
			$('.usertip').html('用户名不存在').show();
		}else{
			//用户名正确
			$('.usertip').hide();
		}
	})
}

//登录
function login(){
	$.post('',$('#f-login').serialize(),function(res){
		if(res.status == 0){
           	alert(res.info);
        }else{
            window.location =res.info;
        }
	})
}


//旧密码检测
function pwdCheck(){
	var pwd=$('#old-pwd').val();
	$.post('',{'pwd':pwd},function(res){
		if(res){
			//密码错误
			$('.pwdtip').show();
		}else{
			//密码正确
			$('.pwdtip').hide();
		}
	})
}

//新密码检测
function newpwd(){
	var pwd=$('#new-pwd').val();
	if(pwd.length < 6){
		$('.newtip').html('密码至少需要6位！').show()
	}else if(pwd.match(/^\d+$/)) {
        $('.newtip').html('密码过于简单，请重新输入！').show();
    }else{
    	$('.newtip').hide();
    }
}
//再次输入新密码检测
function checkAgain(){
	var pwd1=$('#new-pwd').val();
	var pwd2=$('#makesure').val();
	if(pwd1 != pwd2){
		$('.againtip').show();
	}else{
		$('.againtip').hide();
	}
}

//提交修改密码
function changePwd(){
	$.post('',$('#f_pwd').serialize(),function(res){
		if(res){
			//修改成功
			alert('密码修改成功，即将跳转至首页。')
			window.location.href='index.html';
		}else{
			//修改失败
		}
	})
}

//申请报备
function addreport(){
	var phone=$('#linkway').val();
	var mobilePhone = /^(13|14|15|18|17)\d{9}$/;
	if (!mobilePhone.test(phone)){
        $('.teltip').show();
        return false;
    }else{
    	 $('.teltip').hide()
    }
	$.post('',$('#f_add').serialize(),function(res){
		if(res){
			//公众号已存在
			$('.exist').show();
			$('.teltip').hide();
		}else if(res){
			//手机号不正确
			$('.exist').hide();
			$('.teltip').show();
			
		}else{
			//报备成功
			$('.exist').hide();
			$('.teltip').hide();
		}
	})
}



//总涨粉量必填
function disableInput(){
	var allfans=$('.allfans').val();
	var sum=$('.sum').val();
	if(allfans == ''){
		$('.minimum').prop('disabled',true).val('');
		$('.maximum').prop('disabled',true).val('');
		$('.suggest').prop('disabled',true).val('');
		$('.price').prop('disabled',true).val('');
		$('.sum').prop('disabled',true).val('');
	}else{
		$('.minimum').prop('disabled',false);
		$('.maximum').prop('disabled',false);
		$('.suggest').prop('disabled',false);
		$('.sum').prop('disabled',false);
		if(sum != ''){
			price=(sum/allfans).toFixed(2);
			$('.price').val(price);
			priceCompare(price)
		}
	}
}

//弹框
function alertBox(text){
	var time;
	$('.alertMain').html(text)
	$('.myalert').show(function(){
		time=setTimeout(function(){
			$('.myalert').hide();
		},3000)
	})
	$('.close,.mask').click(function(){
		$('.myalert').hide();
		clearTimeout(time);
	})
}
//每日涨粉与总涨粉比较
function compare(){
	
	var all=parseFloat($('.allfans').val());
	var min=parseFloat($('.minimum').val());
	var max=parseFloat($('.maximum').val());
	var suggest=parseFloat($('.suggest').val());
	if(isNaN(all) || isNaN(min) || isNaN(max) || isNaN(suggest)){
		
	}else if(min <= suggest && suggest <= max && max <=all){
		
	}else{
		alertBox('您输入的数值有误，保底量&lt;=建议量&lt;=最高量&lt;=总涨粉量。<br />请核对后重新输入！');
	}
}

var minPrice=1.00;
function priceCompare(price){
	if(price < minPrice){
		alertBox('单价小于保底单价<br />请重新输入打款金额');
	}
}

//输入打款金额，计算单价
function calculate(){
	var sum=$('.sum').val();
	if(sum != ''){
		var amount=$('.allfans').val();
		var price=(sum/amount).toFixed(2);
		$('.price').val(price);
		priceCompare(price)
	}
}

//输入单价，计算打款金额
function sum(){
	var price=$('.price').val();
	if(price != ''){
		var amount=$('.allfans').val();
		var sum=(price*amount).toFixed(2);
		$('.sum').val(sum);
		//$('.sum').attr('disabled',true);
	}else{
		//$('.sum').attr('disabled',false).val('');
	}
}

//检测手机号码
function phoneCheck(){
	var phone=$('#linkway').val();
	var mobilePhone = /^(13|14|15|18|17)\d{9}$/;
	if (!mobilePhone.test(phone)){
        $('.teltip').show()
    }else{
    	 $('.teltip').hide()
    }
}


//申请工单
function addorder(){
	var selectVal=$('#gzh').val();
	var $input=$('.f_primary').find('input');
	if(selectVal == '0' || selectVal == ''){
		alertBox('必填项还未填写完成，请补充完整后重新提交！');
		return false;
	}
	for(var i=0,len=$input.length;i < len;i++){
		if($input.eq(i).val() == ''){

			alertBox('必填项还未填写完成，请补充完整后重新提交！');
			return false;
		}
	}
	 document.getElementById("myform").submit();
}

//申请工单
function editorder(){
    	var selectVal=$('#gzh').val();
	var $input=$('.f_primary').find('input');
	if(selectVal == '0' || selectVal == ''){
		alertBox('必填项还未填写完成，请补充完整后重新提交！');
		return false;
	}
	for(var i=0,len=$input.length;i < len;i++){
		if($input.eq(i).val() == ''){

			alertBox('必填项还未填写完成，请补充完整后重新提交！');
			return false;
		}
	}
	$('.cause').show();
}

//取消修改工单
function cancelChange(){
	$('.cause').hide();
	$('.cause textarea').val('')
}
//提交修改工单
function sub_order(){
	document.getElementById("myform").submit();
}

$(function(){
	
	//下拉菜单
	$('#navDropdown').on('show.bs.dropdown',function(){
		$('.top-caret').hide()
		$('.bottom-caret').show()
	})
	
	$('#navDropdown').on('hide.bs.dropdown',function(){
		$('.top-caret').show()
		$('.bottom-caret').hide()
	})
	
	//添加工单
	//单选
	var l_radios = $('.label-radio');
	
	$.each(l_radios, function () {
        var l = $(this), input = $(this).children("input[type='radio']");
        if (input.prop('checked')) {
            l.removeClass('offradio').addClass('onradio');
        } else {
            l.removeClass('onradio').addClass('offradio');
        }
        input.click(function () {
            if (l.attr('class').indexOf('offradio') > -1) {
                var inputName = $(this).attr('name');
                var allCheckbox = $('input[name="' + inputName + '"]');
                $.each(allCheckbox, function () {
                    $(this).parent('label').removeClass('onradio').addClass('offradio');
                });
                l.removeClass('offradio').addClass('onradio');
            }
        });
    });
    
    
    //多选
    var l_check=$('.check-label');
    l_check.each(function(){
    	l=$(this),input=$(this).children("input[type='checkbox']");
    	if(input.prop('checked')){
    		l.removeClass('offcheck').addClass('oncheck');
    	}else{
    		l.removeClass('oncheck').addClass('offcheck');
    	}
    })
    
      $('.check-label input').click(function(){
    		if ($(this).prop('checked')) {
    		
                $(this).parent('label').removeClass('offcheck').addClass('oncheck');   
            }else{
            	
            	 $(this).parent('label').removeClass('oncheck').addClass('offcheck');
            }
    })
      
    //清空选择
    $('.clear').eq(0).click(function(){
    	$('#tags').importTags('');
    })
    $('.clear').eq(1).click(function(){
    	$('#tags1').importTags('');
    })
    
    //满足其一或全部
    $('.explain').hover(function(){
    	$('.exbox').show();
    },function(){
    	$('.exbox').hide();
    })
    
    //开启工单
    $('.open-btn').click(function(){
    	$('.myalert').show();
    	  //点击×，背景，取消按钮
    	$('.close,.mask,.btn-cancel').click(function(){
			$('.myalert').hide();
		})
    	$('.btn-sure').click(function(){
    		//点击确定按钮
    		$('.myalert').hide();
    	})
    })
 
    //工单修改和开启
    $('.edit').click(function(){
        var mythis=event.target; 
        window.location.href="geteditworkorder?workId="+$(mythis).attr('text');
    })
    
    $('.open').click(function(){
        var mythis=event.target; 
        window.location.href="?action=upda&stat=4&new=1&id="+$(mythis).attr('text');
    })
})

