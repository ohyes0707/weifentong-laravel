//列表缩略初始化
function ifopen(){
	$('.parent').each(function(){
		var $this=$(this);
		var code=$this.attr('data-code');
		if(ChineseDistricts[code]){
			$this.find('.toggle').addClass('disopen').removeClass('open')
			$('.subset[data-fcode="'+code+'"]').hide();
		}
	})
}

function ifSelect(){
	$('.td-chan label').each(function(){
		var l=$(this),input=l.find('input');
		if(input.prop('checked')){
			l.removeClass('offlabel').addClass('onlabel');
		}else{
			l.removeClass('onlabel').addClass('offlabel')
		}
	})
}

//渠道
function addChannel(){
//	var allArr=[];
	var $table=$('.f_order table');
	var trlist='';
	console.log(buss_list);
	//var buss = $(".buss_list").html();
	//$.each($(".buss_list"),function(i,v){
	//	buss += v;
	//})
	//console.log(buss.toArray())
	//$.each(ChineseDistricts[86],function(index,value){
	//	var parent=value;
	//	var subarr=ChineseDistricts[index];

//		if(subarr){
//			trlist +='<tr data-code="'+index+'" title="'+value+'" class="parent"><td class="td-chan"><input type="hidden" name="p_buss['+index+']" value="0"><label><input type="checkbox" name="check['+index+']" />'+value+'</label><span class="toggle"></span></td><td class="inputtd"><input type="number" class="alladd" name="total_fans['+index+']" placeholder="/" readonly/></td><td class="inputtd"><input type="number" class="dayadd" name="day_fans['+index+']" placeholder="/" readonly/></td><td><select name="status['+index+']"><option value="2">暂停</option><option value="1">开启</option></select></td><td></td><td></td></tr>';
//			$.each(subarr,function(i,v){
////				var list=parent+'/'+v
////				allArr.push(list);
//				trlist +='<tr data-code="'+i+'" title="'+v+'" data-fcode="'+index+'" class="subset"><td class="td-chan"><input type="hidden" name="p_buss['+i+']" value="'+index+'"><label><input type="checkbox" name="check['+i+']" />'+v+'</label></td><td class="inputtd"><input type="number" class="alladd" name="total_fans['+i+']" placeholder="/" readonly/></td><td class="inputtd"><input type="number" class="dayadd" name="day_fans['+i+']" placeholder="/" readonly /></td><td><select name="status['+i+']"><option value="2">暂停</option><option value="1">开启</option></select></td><td></td><td></td></tr>';
//			})
//		}else{
//			trlist +='<tr data-code="'+index+'" title="'+value+'" class="parent"><td class="td-chan"><input type="hidden" name="p_buss['+index+']" value="0"><label><input type="checkbox" name="check['+index+']" />'+value+'</label></td><td class="inputtd"><input type="number" class="alladd" name="total_fans['+index+']" placeholder="/" readonly/></td><td class="inputtd"><input type="number" name="day_fans['+index+']" class="dayadd" placeholder="/" readonly/></td><td><select name="status['+index+']"><option value="2">暂停</option><option value="1">开启</option></select></td><td></td><td></td></tr>';
////			allArr.push(parent)
//		}
//	})
	$table.append(trlist)
//	var allstr=allArr.join();
//	$('#tags').importTags(allstr);
//	$table.append('<tr class="t-foot"><td>合计</td><td class="sum-all"></td><td class="sum-day"></td><td></td><td></td><td></td></tr>');
	tableCss();
	ifopen();
	ifSelect();
}

//判断总和
function dataJudge(text){

	var settime;
	$('.alertMain').html(text);
	$('.alertbtn').hide()
	$('.myalert').show(function(){
		settime=setTimeout(function(){
			$('.myalert').hide()
		},3000)
	});

	$('.mask,.myalert .close').click(function(){
		$('.myalert').hide();
		clearTimeout(settime);
	})


}

//计算总和
function sum(obj1,obj2){
	var sum=0;

	$(obj1).each(function(i,v){
		if($(this).val()!=''){
			sum+=parseFloat($(this).val())
		}
	})

	$(obj2).html(sum);
}

//表单提交
function formSubmit(){
	var allfans=parseFloat($('.fansdata').text());
	var daymax=parseFloat($('.daymax').text());
	var allsum=parseFloat($('.sum-all').text());
	var daysum=parseFloat($('.sum-day').text());
	if(allsum > allfans){
		dataJudge('总涨粉总计不得大于总涨粉量');
		return false;
	}
	if(daysum > daymax){
		dataJudge('日涨粉总计不得大于日涨粉最高量');
		return false;
	}
	$('.f_order').submit();
}

function tableCss(){
	var len=$('.f_order tr').length;
	var height=$('.inputtd').height()*$('.parent').length+'px';
	$('.ghname').attr('rowspan',len).css('line-height',height);//
}

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

function sureAlert(text,event){
	var $this=event.target;
	$('.alertMain').html(text);
	$('.myalert').show();
	$('.btn-cancel').click(function(){
		$('.myalert').hide();
	})
	$('.btn-sure').click(function(){
		$('.myalert').hide();
	})
}

//登录页用户名检测
/*function userCheck(){
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
}*/

//登录
/*function login(){
	$.post('',$('#f-login').serialize(),function(res){
		if(res.status == 0){
			alert(res.info);
		}else{
			window.location =res.info;
		}
	})
}*/

//二维码倒计时
var codetimer;
var s=300;//倒计时时长
var clear=true;//用于判断计时器是否清除
function countdown(){
	$.get('', function(res) {
		$('.codeimg img').attr('href', res); //请求二维码
		$('.codeAlert,.countdown,.dis_refresh').show();
		$('.discount,.can_refresh').hide();
		$('.countdown span').text(s);
		codetimer = setInterval(function() {
			s--;
			$('.countdown span').text(s);
			if(s <= 0) {
				clearInterval(codetimer);
				clear = true;
				$('.discount,.can_refresh').show();
				$('.countdown,.dis_refresh').hide();
				s = 300;
			} else {
				clear = false;
			}

		}, 1000)
	})

}


$(function(){
	var day=new Date();
	day.setTime(day.getTime()-24*60*60*1000)
	var yesterday=day.getFullYear()+'-'+(day.getMonth()+1)+'-'+day.getDate()
	$("#datetimeEnd").datetimepicker("setEndDate",yesterday);
	//报备列表
    //授权
/*    $('.authrize').click(function(event){
        var lid = $(this).attr('l_id');
        var mythis=event.target;
        $('.alertMain').html('请确认是否授权该报备信息？<br />点击确认后该报备授权成功，可进行下一步操作！');
        $('.myalert').show();
        $('.btn-cancel').click(function(){
            $('.myalert').hide();
        })
        $('.btn-sure').click(function(){
            $('.myalert').hide();
            window.location.href="changestatus?lid="+lid+"&status=3";
            //$(mythis).parent('td').find('.btn').removeClass('btn-red').removeClass('btn-blue').addClass('btn-grey').attr('disabled',true)
        })
    })*/
/*	$('.authrize').click(function(){
		if(clear){
			countdown()
		}else{
			$('.codeAlert').show();
		}
	})*/
	$('.can_refresh').click(function(){
		countdown()
	})
	$('.boxclose,.mask').click(function(){
		$('.codeAlert').hide();
	})
	//工单列表
	//驳回
	$('.return').click(function(event){

		var mythis=event.target;

		$('.cause').show();
		$('.cancel').click(function(){
			$('.cause').hide();
                        $('.causeTip').show();
			$('.cause textarea').val('')
		})
		$('.sure').click(function(){

            var wid=$(mythis).attr('text');
            $('#wid').val(wid);
            if($('.cause textarea').val() == ''){
                    $('.causeTip').show();
                    return false;
            }
            document.getElementById("f-reason").submit();
			$('.cause').hide();
			$(mythis).parent('td').find('.btn').not('.infor').removeClass('btn-red').removeClass('btn-blue').addClass('btn-grey').attr('disabled',true);
		})
	})
	//通过
	$('.audit').click(function(event){
		var mythis=event.target;
		$('.alertMain').html('请确认是否通过该工单？<br />点击确认后该工单审核通过！');
		$('.myalert').show();
		$('.btn-cancel').click(function(){
			$('.myalert').hide();
		})
		$('.btn-sure').click(function(){
			$('.myalert').hide();
                        window.location.href="?action=upda&stat=1&new=3&id="+$(mythis).attr('text');
			$(mythis).parent('td').find('.return,.audit').removeClass('btn-red').removeClass('btn-blue').addClass('btn-grey').attr('disabled',true);
		})
	})

	//取消
	$('.calloff').click(function(event){
		var mythis=event.target; 
                window.location.href="getWorkOrder?id="+$(mythis).attr('text');
//		$('.alertMain').html('请确认是否通取消该工单？<br />点击确认后暂时关闭该工单！');
//		$('.myalert').show();
//		$('.btn-cancel').click(function(){
//			$('.myalert').hide();
		})

//		$('.btn-sure').click(function(){
//                       window.location.href="?action=upda&stat=3&new=4&id="+$(mythis).attr('text');
//			$('.myalert').hide();
//			$(mythis).parent('td').find('.btn').removeClass('btn-red').removeClass('btn-blue').removeClass('btn-yellow').addClass('btn-grey').attr('disabled',true)
//		})


/*------------------------------------新增-------------------------------*/
$('.causeMain textarea').bind('keyup',function(){
        var text=$(this).val();
        if(text == ''){
                $('.causeTip').show();
        }else{
                $('.causeTip').hide();
        }
})



	//关闭订单
	$('.orderclose').click(function(event){
		var mythis=event.target;
		$('.alertMain').html('请确认是否关闭该订单？');
		$('.myalert').show();
		$('.alertbtn').show();
		$('.btn-cancel').click(function(){
			$('.myalert').hide();
		})
		$('.btn-sure').click(function(){
			$.post('close',{'status':3,'order_id':$(".order_id").val(),'_token':$("input[name=_token]").val()},function(t){
				$('.myalert').hide();
				window.location.href='list';
			});
			$('.myalert').hide();
			window.location.href='list';
		})

	})

	//工单详情
	$('.refuse').click(function(){
		$('.cause').show();
		$('.cancel').click(function(){
			$('.cause').hide();
			$('.cause textarea').val('')
                        $('.causeTip').show()
		})
		$('.sure').click(function(){
                    if($('.cause textarea').val() == ''){
				$('.causeTip').show();
				return false;
			}
			$('.cause').hide();
		})
	})

	$('.pass').click(function(){
		$('.alertMain').html('请确认是否通过该工单？<br />点击确认后该工单审核通过！');
		$('.myalert').show();
		$('.btn-cancel').click(function(){
			$('.myalert').hide();
		})
		$('.btn-sure').click(function(){
			$('.myalert').hide();
		})
	})

	$('.mask,.myalert .close').click(function(){
		$('.myalert').hide();
	})
	//下拉菜单
	$('#navDropdown').on('show.bs.dropdown',function(){
		$('.top-caret').hide()
		$('.bottom-caret').show()
	})

	$('#navDropdown').on('hide.bs.dropdown',function(){
		$('.top-caret').show()
		$('.bottom-caret').hide()
	})



	//文字溢出隐藏与显示
	var textover=$('.area .data');
	textover.each(function(i,v){
		if(this.offsetWidth<this.scrollWidth){
			$(this).parent('.area').append('<a href="javascript: void(0);" class="allshow">>></a>')
		}
		$(this).click(function(){
			var arrow=$(this).siblings('.allshow');
			if(arrow.is(':hidden')){
				$(this).css({
					'text-overflow':'ellipsis',
					'overflow':'hidden',
					'white-space':'nowrap',
					'border': 'none',
					'position':'static',
					'padding':'0'
				})
				arrow.show();
			}
		})
	})
	$('.allshow').click(function(){
		$(this).hide();
		$(this).parent('.area').siblings('.area').children('.data').css({
			'text-overflow':'ellipsis',
			'overflow':'hidden',
			'white-space':'nowrap',
			'border': 'none',
			'position':'static',
			'padding':'0'
		}).siblings('.allshow').show();
		$(this).siblings('.data').css({
			'overflow':'visible',
			'border':'1px solid #3dabf6',
			'white-space':'normal',
			'position':'absolute',
			'left':'25%',
			'background':'#fff',
			'z-index':'1',
			'padding':'5px',
			'border-radius': '4px'
		})
	})


	//合计
	$(document).delegate('.alladd','keyup',function(){

		sum('.alladd','.sum-all')

	})

	//日涨粉
	$(document).delegate('.dayadd','keyup',function(){

		sum('.dayadd','.sum-day')

	})


	$(document).delegate('.toggle','click',function(){
		var $parent=$(this).parents('tr');
		var code=$parent.attr('data-code');
		if($('.subset[data-fcode="'+code+'"]').length>0){
			if($('.subset[data-fcode="'+code+'"]').is(':hidden')){
				$('.subset[data-fcode="'+code+'"]').show();
				$(this).addClass('open').removeClass('disopen');
			}else{
				$('.subset[data-fcode="'+code+'"]').hide();
				$(this).addClass('disopen').removeClass('open');
			}
		}
	})

	//多选框选中和取消
	$(document).delegate('.td-chan label','click',function(){
		var l=$(this),$input=l.find('input');
		if($input.prop('checked')){
			l.removeClass('offlabel').addClass('onlabel');
			l.parents('tr').find('.inputtd input').prop('readonly',false).attr('placeholder','')
		}else{
			l.removeClass('onlabel').addClass('offlabel');
			l.parents('tr').find('.inputtd input').prop('readonly',true).attr('placeholder','/').val('');
			sum('.alladd','.sum-all');
			sum('.dayadd','.sum-day');

		}
	})

	//日涨粉与总涨粉比较
	$(document).delegate('.alladd','blur',function(){
		var allVal=parseFloat($(this).val());
		var dayVal=parseFloat($(this).parents('tr').find('.dayadd').val());
		if(!isNaN(dayVal)){
			if(allVal < dayVal || isNaN(allVal)){
				dataJudge('输入有误，日涨粉应小于等于总涨粉！')
			}
		}
	})
	$(document).delegate('.dayadd','blur',function(){
		var dayVal=parseFloat($(this).val());
		var allVal=parseFloat($(this).parents('tr').find('.alladd').val());
		if(!isNaN(allVal)){
			if(allVal < dayVal){
				dataJudge('输入有误，日涨粉应小于等于总账粉！')
			}
		}
	})

	
	//工单详情
	$('.refuse').click(function(){
		$('.cause').show();
		$('.cancel').click(function(){
			$('.cause').hide();
			$('.cause textarea').val('')
		})
		$('.sure').click(function(){
                    if($('.cause textarea').val() == ''){
                        $('.causeTip').show();
                        return false;
                    }
			document.getElementById("f-report").submit();
		})
	})
	
	$('.pass').click(function(){
                var mythis=event.target; 
		$('.alertMain').html('请确认是否通过该工单？<br />点击确认后该工单审核通过！');
		$('.myalert').show();
		$('.btn-cancel').click(function(){
			$('.myalert').hide();
		})
		$('.btn-sure').click(function(){
                    window.location.href="?action=upda&stat=1&new=2&id="+$(mythis).attr('text');
                    $('.myalert').hide();
		})
	})
	
	$('.mask,.myalert .close').click(function(){
		$('.myalert').hide();	
	})

})
//文字溢出隐藏与显示
var textover=$('.area .data');
textover.each(function(i,v){
	if(this.offsetWidth<this.scrollWidth){
		$(this).parent('.area').append('<a href="javascript: void(0);" class="allshow">>></a>')
	}
})

$(document).click(function(){
	$('.area .data').each(function(){
		var $data=$(this);
		if($data.attr('class').indexOf('textShow') > 0){
			$data.removeClass('textShow').addClass('textHide');
			$data.siblings('.allshow').show()
		}
	})
})
$('.allshow').click(function(e){
	$(this).hide();
	$(this).parent('.area').siblings('.area').children('.data').removeClass('textShow').addClass('textHide').siblings('.allshow').show();
	$(this).siblings('.data').removeClass('textHide').addClass('textShow');
	e.stopPropagation()
})

//修改密码
function pwdCheck(){
	var pwd=$('#old-pwd').val();
	var token = $("input[name=_token]").val();
	$.post('changepwd',{'_token':token,'pwd':pwd},function(res){
		if(res.message=="原始密码错误") {
			//密码错误
			$('.pwdtip').show();
		}else{
			//密码正确
			$('.pwdtip').hide();
		}
	},'json')
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
	var token = $("input[name=_token]").val();
	var new_pwd = $("#new-pwd").val();
	var type = $(".pwdtip").css('display');
	$.post( changePwd_url,{'_token':token,'new_pwd':new_pwd,'type':type},function(res){
		if(res){
			alert(res);
			window.history.go(-1);
			//修改成功
			//alert('您的密码修已修改成功，即将跳转至首页。')
			//window.location.href='index.html';
		}else{
			//修改失败
		}
	})
}
