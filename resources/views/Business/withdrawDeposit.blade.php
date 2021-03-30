<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>带粉中心-结算管理-提现</title>
		@include('Business.common.head')
	</head>
	<body>
		<!--导航栏-->
		@include('Business.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Business.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="header">提取可用余额到个人账户</div>
				
				<form action="" method="post" class="cash-form">
				{{csrf_field()}}
					<div class="form-list">
						<label>可用余额：</label>
						<div class="usable"><span>{{$balance}}</span> 元<em>（正在提现金额：{{$withdrawals}}元）</em></div>
					</div>
					<div class="form-list">
						<label>提现方式：</label>
						<label class="label-radio"><input type="radio" name="payment" id="alipay" checked/>支付宝</label>
						<label class="label-radio"><input type="radio" name="payment" id="bank"/>银行卡</label>
					</div>
					
					<div class="alipay">
						<div class="form-list">
							<label>姓　　名：</label><input type="text" name="payee" placeholder="收款人姓名" class="form-input"/>
						</div>
						<div class="form-list">
							<label>提现账号：</label><input type="text" name="account" placeholder="支付宝账户/手机号码" class="form-input"/>
						</div>
						<div class="form-list" style="display: none;">
							<label>1</label><input type="text" name="type" value="1" class="form-input"/>
						</div>
						<div class="form-list" style="display: none;">
							<label>1</label><input type="text" name="bid" value="1" class="form-input"/>
						</div>
					</div>
					
					<div class="bank">
						<div class="form-list">
							<label>姓　　名：</label><input type="text" name="payee" placeholder="开户人姓名" class="form-input"/>
						</div>
						<div class="form-list">
							<label>开户银行：</label><input type="text" name="bank" placeholder="输入银行" class="form-input"/>
						</div>
						<div class="form-list">
							<label>银行卡号：</label><input type="text" name="cardnumber" placeholder="储蓄卡号" class="form-input"/>
						</div>
						<div class="form-list" style="display: none;">
							<label>2</label><input type="text" name="type" value="2" class="form-input"/>
						</div>
						<div class="form-list" style="display: none;">
							<label>2</label><input type="text" name="bid" value="2" class="form-input"/>
						</div>
					</div>
					
					<div class="form-list">
						<label>提现金额：</label><input type="text" name="amount" placeholder="最低100" class="form-input"/>元
					</div>
					
					<ul class="withdrawTip">
						<li>1.提现将扣除5%的税，提现的金额不能超过可用余额！</li>
					</ul>
					<div class="btns">
						<input type="button" value="提现" class="blue-btn" id="tx-btn"/>
						<input type="button" value="取消" class="goback" onclick="history.go(-1)"/>
					</div>
					
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="javascript: void(0)" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								请确认是否提现？
							</div>
							<div class="alertbtn">
								<input type="submit" name="submit" value="确认" class="blue-btn" id="submit"/>
								<button class="goback btn-cancel">取消</button>
							</div>
						</div>
					</div>
					
				</form>
				
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
			
			
			//选择支付方式
			var l_radios = $('.label-radio');
			$.each(l_radios, function () {
		        var l = $(this), 
		        	input = $(this).children("input[type='radio']"),
		        	target=input.attr('id');
		        if (input.prop('checked')) {
		            l.removeClass('offradio').addClass('onradio');
		            $('.'+target).show().find('input').prop('disabled',false)
		        } else {
		            l.removeClass('onradio').addClass('offradio');
		             $('.'+target).hide().find('input').prop('disabled',true)
		        }
		        input.click(function () {
		            if (l.attr('class').indexOf('offradio') > -1) {
		                var inputName = $(this).attr('name');
		                var allCheckbox = $('input[name="' + inputName + '"]');
		                $.each(allCheckbox, function () {
		                    $(this).parent('label').removeClass('onradio').addClass('offradio');
		                    $('.'+$(this).attr('id')).hide().find('input').prop('disabled',true)
		                });
		                l.removeClass('offradio').addClass('onradio');
		                $('.'+target).show().find('input').prop('disabled',false);
		            }
		        });
		    });
		    
		    //弹框
			$('#tx-btn').click(function(){
				var $amount = $('input[name=amount]').val();
				if($amount<100){
					alert('提现金额不能低于100');
				}else if(({{$balance}}-$amount)>0){
					$('.myalert').show();
				}else{
					alert('提现超过余额');
				}
				
			})
			
			$('.close,.btn-cancel').click(function(){
				//点击取消
				$('.myalert').hide();
				return false;
			})
		    
			
		})
	</script>
</html>
