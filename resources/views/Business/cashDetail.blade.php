<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>带粉中心-结算管理-提现详情</title>
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
				
				<div class="header">提现详情</div>
				
				<div class="detailLists">
					<ul>
						<li class="list clearfix"><span>提现时间：</span><em>{{$paginator['create_date']}}</em></li>
						<li class="list clearfix"><span>子商户名：</span><em>{{$paginator['username']}}</em></li>
						
						@if ($paginator['tixian_type'] == 1)
					        <li class="list clearfix"><span>提现方式：</span><em>银行卡</em></li>
					    @elseif ($paginator['tixian_type'] == 0)
					    	<li class="list clearfix"><span>提现方式：</span><em>支付宝</em></li>
					   	@endif
						<li class="list clearfix"><span>提现姓名：</span><em>{{$paginator['real_name']}}</em></li>
						<li class="list clearfix"><span>提现账号：</span><em>{{$paginator['tixian_account']}}</em></li>
						<li class="list clearfix"><span>提现金额：</span><em>{{$paginator['op_money']}}</em></li>
						@if ($paginator['status'] == 2)
					    	<li class="list clearfix"><span>驳回原因：</span><em>{{$paginator['reason']}}</em></li>
					   	@endif
					   	<li style="display: none;" id="get_reject" class="list clearfix"><span>驳回原因：</span><em><span  id="get_reject1"></span></em></li>
						
					</ul>
					@if ($paginator['status'] == 4 && $paginator['pbid'] != 0)
					<div class="auditBtns">
						<button class="blue-btn" id="pass">通过</button>
						<button class="red-btn" id="reject">驳回</button>
						<button class="goback" onclick="history.go(-1)">返回</button>
					</div>
					@else
					<button class="goback" onclick="history.go(-1)">返回</button>
					@endif
					<button style="display: none;" class="goback" onclick="history.go(-1)">返回</button>
				</div>
				
			</div>
		</div>
		<div class="myalert" style="display: none;">
			<div class="mask"></div>
			<div class="alertbox">
				<a href="#" class="close">&times;</a>
				<div class="alertHead">提示</div>
				<div class="alertMain">
					请确认是否通过该提现申请？
				</div>
				<div class="alertbtn">
					<button class="blue-btn btn-sure">确定</button>
					<button class="goback btn-cancel">取消</button>
				</div>
			</div>
		</div>
		
		<div class="cause" style="display: none;">
			<div class="mask"></div>
			<div class="causeMain">
				<p>请输入驳回原因</p>
				<textarea name="reason"></textarea>
				<span class="causeTip">原因必填</span>
				<div class="causebtn">
					<input type="button" value="确认" class="blue-btn" id="rejectSure" />
					<input type="button" value="取消" class="goback" id="cancelReject"/>	
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){
			
			
			//弹窗
			$('#pass').click(function(){
				$('.myalert').show();
			})
			
			$('.btn-sure').click(function(){
				//点击确定
				$('.myalert').hide();
				getMessage();
			})
			$('.close,.btn-cancel').click(function(){
				//点击取消
				$('.myalert').hide();
				return false;
			})
			$('#reject').click(function(){
				$('.cause').show()
			})
			$('textarea[name=reason]').on('input',function(){
				if($(this).val().length > 0){
					$('.causeTip').hide();
					$('#rejectSure').prop('disabled',false)
				}else{
					$('.causeTip').show();
					$('#rejectSure').prop('disabled',true)
				}
			})
			$('#rejectSure').click(function(){
				$('.cause').hide();
				getReject();
			})
			$('#cancelReject').click(function(){
				$('.cause').hide();
				$('textarea[name=reason]').val('');
				$('.causeTip').show();
				$('#rejectSure').prop('disabled',true)
			})

			function getMessage(){
	            $.ajax({
	               	type:'get',
	               	url:"/business/Settlement/getLook?lid={{$paginator['id']}}&op_money={{$paginator['op_money']}}&sbid={{$paginator['bid']}}",
		               	success:function(data){
		                  	$('.goback').show(),
							$('.auditBtns').hide()
		               	},
		               	error:function(){   
							alert('审核失败');   
						}
	            });

         	}

         	function getReject(){
         		var $reject = $('textarea[name=reason]').val();
	            $.ajax({
	               	type:'get',
	               	url:"/business/Settlement/getReject?lid={{$paginator['id']}}&reject="+$reject,
		               	success:function(data){
		                  	$('#get_reject').show(),
							$('#get_reject1').text($reject),
							$('.goback').show(),
							$('.auditBtns').hide()
		               	},
		               	error:function(){   
							alert('驳回失败');   
						}
	            });

         	}
		})
	</script>
</html>
