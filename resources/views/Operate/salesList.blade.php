<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>用户管理-销售列表</title>
		@include('Operate.common.head')
	</head>
	<body>
		@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				
				<div class="main-top clearfix">
					<div class="oprate-btns">
						<a href="saleAdd" class="btn btn-blue">新增</a>
						<button class="btn btn-blue btn-use" disabled>启用</button>
						<button class="btn btn-red btn-forbidden" disabled>禁用</button>
						<button class="btn btn-red btn-delete" disabled>删除</button>
					</div>
					<form action="" method="post" class="checkform">
						{{csrf_field()}}
						<input type="hidden" name="page" @if(isset($page))value="{{$page}}"@endif/>
						<input type="text" name="sales" @if(isset($sale))value="{{$sale}}" @endif placeholder="查询销售" class="input"/>
						<input type="submit" value="查询" class="find"/>
						<input type="reset" value="重置" class="reset"/>
					</form>
				</div>
				
				<table class="table-bordered table-responsive detail d-table">
					<tr>
						<th><input type="checkbox" name="checkbox"/></th>
						<th>手机</th>
						<th>姓名</th>
						<th>报备</th>
						<th>授权</th>
						<th>报备完成</th>
						<th>工单</th>
						<th>订单</th>
						<th>总销售额</th>
						<th>保底价</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td><input type="checkbox" name="checkbox" class="check" value="{{$v['id']}}"/></td>
								<td>{{$v['username']}}</td>
								<td>{{$v['nick_name']}}</td>
								<td>{{$v['report']}}</td>
								<td>{{$v['auth']}}</td>
								<td>{{$v['report_success']}}</td>
								<td>{{$v['work']}}</td>
								<td>{{$v['order']}}</td>
								<td>{{$v['money']}}</td>
								<td>{{$v['ti_money']}}</td>
								@if($v['status'] == 1)
									<td class="blue status{{$v['id']}}">启用中</td>
								@else
									<td class="red status{{$v['id']}}">已禁用</td>
								@endif
								<td>
									<a href="saleEdit?uid={{$v['id']}}" class="btn btn-blue">编辑</a>
									<a href="saleForm?uid={{$v['id']}}&uname={{$v['nick_name']}}" class="btn btn-blue">报表</a>
									@if($v['status'] == 1)
										<button class="btn btn-red btn-forbidden" value="{{$v['id']}}">禁用</button>
									@else
										<button class="btn btn-blue btn-forbidden" value="{{$v['id']}}">启用</button>
									@endif
									<button class="btn btn-red btn-delete" value="{{$v['id']}}">删除</button>
								</td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator}}
				@endif
			</div>
		</div>
		
		<div class="myalert a-alert" style="display: none;">
			<div class="mask"></div>
			<div class="alertbox">
				<a href="#" class="close">&times;</a>
				<div class="alertHead">提示</div>
				<div class="alertMain">
					
				</div>
				<div class="alertbtn">
					<button class="btn btn-sure">确定</button>
					<button class="btn btn-cancel">取消</button>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(function(){

			//表格缩略
			$('table').delegate('.f_channel','click',function(){
				var $this=$(this);
				var code=$this.attr('channelId');
				var $sub=$this.parents('table').find('.sub_channel[fatherId="'+code+'"]');
				if($sub.length>0){
					if($sub.is(':hidden')){
						$sub.show();
						$this.addClass('on_channel').removeClass('off_channel');
					}else{
						$sub.hide();
						$this.addClass('off_channel').removeClass('on_channel');
					}
				}
			})
			
			//复选框
			var allInputs=$('input[type=checkbox]')
			var tdInput=$('td input[type=checkbox]')
			var $btn=$('.oprate-btns').find('button')
			$('th input').click(function(){
				if($(this).prop('checked')){
					allInputs.prop('checked',true);
					$btn.prop('disabled',false)
				}else{
					allInputs.prop('checked',false)
					$btn.prop('disabled',true)
				}
			})
			
			tdInput.click(function(e){
				e.stopPropagation()
				var len=$('td input:checked').length
				if(len == 0){
					$btn.prop('disabled',true)
					$('th input').prop('checked',false)
				}else if(len < tdInput.length){
					$btn.prop('disabled',false)
					$('th input').prop('checked',false)
				}else if(len == tdInput.length){
					$btn.prop('disabled',false)
					$('th input').prop('checked',true)
				}
			})
			
			$('.detail .btn').click(function(e){
				e.stopPropagation()
			})
			
			//启用
			$('.oprate-btns .btn-use').click(function(){
				$('.myalert').show()
				var selectItems=selectItem();
				var token = $("input[name=_token]").val();
				var page = $('input[name=page]').val();
				var str = '';
				$(".check:checked").each(function(i,o){
					if(str == ''){
						str = $(this).attr('value');
					}else{
						str += ','+$(this).attr('value');
					}
				})
				$('.alertMain').html('<p>请确认是否启用以下项目：</p><div>'+selectItems+'</div>');
				$('.btn-sure').click(function(){
					$.post('startAll',{'_token':token,'str':str},function(t){
						$('.myalert').hide()
						window.location.href='saleList?page='+page;
					})
				})
			})
			//禁用
			$('.oprate-btns .btn-forbidden').click(function(){
				$('.myalert').show();
				var selectItems=selectItem()
				var token = $("input[name=_token]").val();
				var page = $('input[name=page]').val();
				var str = '';
				$(".check:checked").each(function(i,o){
					if(str == ''){
						str = $(this).attr('value');
					}else{
						str += ','+$(this).attr('value');
					}
				})
				$('.alertMain').html('<p>请确认是否禁用以下项目：</p><div>'+selectItems+'</div>')
				$('.btn-sure').click(function(){
					$.post('endAll',{'_token':token,'str':str},function(t){
						$('.myalert').hide()
						window.location.href='saleList?page='+page;
					})
				})
			})
			$('.detail .btn-forbidden').each(function(){
				$(this).click(function(){
					$('.myalert').show()
					var inner = $(this).text();
					var value=$(this).attr('value')
					var token = $("input[name=_token]").val();
					var page = $('input[name=page]').val();
					if(inner == '启用'){
						$('.alertMain').html('<p class="txt-align">请确认是否启用？</p>');
					}else{
						$('.alertMain').html('<p class="txt-align">请确认是否禁用？</p>');
					}
					$('.btn-sure').click(function(){
						$.post('status',{'_token':token,'uid':value},function(t){
							$('.myalert').hide();
							window.location.href='saleList?page='+page;
						});
					})
				})
			})
			//删除
			$('.oprate-btns .btn-delete').click(function(){
				$('.myalert').show()
				var selectItems=selectItem()
				var token = $("input[name=_token]").val();
				var page = $('input[name=page]').val();
				var str = '';
				$(".check:checked").each(function(i,o){
					if(str == ''){
						str = $(this).attr('value');
					}else{
						str += ','+$(this).attr('value');
					}
				})
				$('.alertMain').html('<p>请确认是否删除以下项目：</p><div>'+selectItems+'</div>')
				$('.btn-sure').click(function(){
					$.post('delAll',{'_token':token,'str':str},function(t){
						$('.myalert').hide()
						window.location.href='saleList?page='+page;
					})
				})
			})
			$('.detail .btn-delete').each(function(){
				$(this).click(function(){
					$('.myalert').show()
					var value = $(this).attr('value');
					var token = $("input[name=_token]").val();
					var page = $('input[name=page]').val();
					$('.alertMain').html('<p class="txt-align">请确认是否删除？</p>')
					$('.btn-sure').click(function(){
						$.post('del',{'_token':token,'uid':value},function(t){
							$('.myalert').hide();
							window.location.href='saleList?page='+page;
						});
					})
				})
			})
			//取消按钮
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide()
			})
			//确认按钮
			$('.btn-sure').click(function(){
				$('.myalert').hide()
			})

			$(".reset").click(function(){
				window.location.href='saleList';
			})
			
		})
		function selectItem(){
			var str='';
			var items=$('td input[type=checkbox]:checked');
			console.log(items)
			items.each(function(){
				var $text=$(this).parents('tr').find('td').eq(2).text();
				str+='<span style="display:inline-block">'+$text+'</span>'
			})
			return str;
		}
	</script>
</html>
