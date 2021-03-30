<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>系统权限-管理员列表</title>
		@include('Operate.common.head')
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			@include('Operate.common.left')
			<!--左侧-->
			</div>
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="main-top clearfix">
					<div class="oprate-btns">
						<a href="{{URL::asset('index.php/operate/addUser')}}" class="btn btn-blue">新增</a>
						<button class="btn btn-blue btn-use" disabled>启用</button>
						<button class="btn btn-red btn-forbiddenlist" disabled>禁用</button>
						<button class="btn btn-red btn-deletelist" disabled>删除</button>
					</div>
					<form action="" method="post" class="checkform">
                        {{csrf_field()}}
						<input type="text" name="user" placeholder="查询用户" class="input"/>
						<input type="submit" value="查询" class="find"/>
					</form>
				</div>
				
				<table class="table-bordered table-responsive detail d-table">
					<tr>
						<th><input type="checkbox" name="checkbox"/></th>
						<th>用户名</th>
						<th>备注</th>
						<th>角色</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
					@foreach($data as $key =>$value)
						<tr>
							<td><input type="checkbox" value="{{$value['username']}}" name="checkbox"/></td>
							<td>{{$value['username']}}</td>
							<td>{{$value['remark']}}</td>
							<td>{{$value['rolename']}}</td>
							<td>{{$value['status']==1?"启用中":"已禁用"}}</td>
							<td>
								<a href="{{URL::asset('index.php/operate/editUser?aid='.$value['id'])}}" class="btn btn-blue">编辑</a>
								@if($value['status']==1)
								<button id="{{$value['id']}}" name="{{$value['username']}}" class="btn btn-red btn-forbidden">禁用</button>
									@else
									<button id="{{$value['id']}}" name="{{$value['username']}}" class="btn btn-red btn-action">启用</button>
								@endif
								<button id="{{$value['id']}}" name="{{$value['username']}}" class="btn btn-red btn-delete">删除</button>
							</td>
						</tr>
					@endforeach
				</table>
				
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
			var allInputs=$('input[name=checkbox]')
			var tdInput=$('td input[name=checkbox]')
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
			$('.btn-use').click(function(){
				var str='';
				var datastring = '';
				$.each($('input:checkbox:checked'),function(){
					 str+='<span>'+$(this).val();+'</span>'
					 datastring+= $(this).val()+','
				});

				$('.myalert').show()
				$('.alertMain').html('<p>请确认是否启用以下项目：</p><div>'+str+'</div>')
				$('.btn-sure').attr('value',datastring);
				$('.btn-sure').attr('name','use');
			})

			// 单个启用
			$('.btn-action').click(function(){
				var id =  $(this).attr("id");
				var name = $(this).attr("name");

				$('.myalert').show()
				$('.alertMain').html('<p>请确认是否启用以下项目：</p><div>'+name+'</div>')
				var newname = name+',';
				$('.btn-sure').attr('value',newname);
				$('.btn-sure').attr('name','use');
			})


			//禁用
			$('.btn-forbidden').click(function(){
				var id =  $(this).attr("id");
				var name = $(this).attr("name");
				$('.myalert').show()
				$('.alertMain').html('<p>请确认是否禁用以下项目：</p><div><span>'+name+'</span></div>')
				$('.btn-sure').attr('value',name);
				$('.btn-sure').attr('name','forbidden');
			})

			//禁用列表
			$('.btn-forbiddenlist').click(function(){
				var str='';
				var datastring = '';
				$.each($('input:checkbox:checked'),function(){
					str+='<span>'+$(this).val();+'</span>'
					datastring+= $(this).val()+','
				});

				$('.myalert').show()
				$('.alertMain').html('<p>请确认是否禁用以下项目：</p><div>'+str+'</div>')
				$('.btn-sure').attr('value',datastring);
				$('.btn-sure').attr('name','forbidden');
			})

			//删除
			$('.btn-delete').click(function(){
				var id =  $(this).attr("id");
				var name = $(this).attr("name");
				$('.myalert').show()
				$('.alertMain').html('<p>请确认是否删除以下项目：</p><div><span>'+name+'</span></div>')
				$('.btn-sure').attr('value',name);
				$('.btn-sure').attr('name','delete');
			})
			// 删除列表
			$('.btn-deletelist').click(function(){
				var str='';
				var datastring = '';
				$.each($('input:checkbox:checked'),function(){
					str+='<span>'+$(this).val();+'</span>'
					datastring+= $(this).val()+','
				});

				$('.myalert').show()
				$('.alertMain').html('<p>请确认是否删除以下项目：</p><div>'+str+'</div>')
				$('.btn-sure').attr('value',datastring);
				$('.btn-sure').attr('name','delete');
			})
			//取消按钮
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide()
			})
			//确认按钮
			$('.btn-sure').click(function(){
				$('.myalert').hide()
				var id =  $(this).attr("value");
				var type =  $(this).attr("name");

				if(type=="forbidden")
				{
					requestFunction(type,id)
				}else if(type=="delete")
				{
					requestFunction(type,id)
				}else if(type=='use')
				{
					requestFunction(type,id)
				}

			})

		})

		function requestFunction(type,id){
 							//{"success":true,"data":1}
			$.getJSON('{{URL::asset('index.php/operate/user/setmanagerList') }}', {"type": type, "id": id},
					function (data) {
						if (data.data > 0) {
							window.location.href = '/operate/managerlist'
						}
					});
		}

	</script>
</html>
