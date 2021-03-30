<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>代理管理</title>
		@include('Agent.common.head')
		<style>
			.icon-folder img{
				display: inline-block;
			}
			.icon-arrow {
				top: 50%;
				margin-top: -4px;
			}
		</style>
	</head>
	<body>
	@include('Agent.common.top')

		
		<div class="main clearfix">
			<!--左侧-->
			@include('Agent.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<div class="main-top clearfix">
					<div class="oprate-btns">
						<a href="{{URL::asset('index.php/agent/addAgency')}}" class="btn btn-blue">新增</a>
						<button class="btn btn-blue btn-use" disabled>启用</button>
						<button class="btn btn-red btn-forbiddenlist" disabled>禁用</button>
						<button class="btn btn-red btn-deletelist" disabled>删除</button>
					</div>
					<form action="" method="post" class="checkform">
						{!! csrf_field() !!}
						<input type="text" name="agency" placeholder="查询代理" value="{{$nick_name==""?'':$nick_name}}" class="input"/>
						<input type="submit" value="查询" class="find"/>
						<input type="reset" value="重置" class="reset"/>
					</form>
				</div>

				<table class="table-bordered table-responsive detail d-table">
					<tr>
						<th><input type="checkbox" name="checkbox"/></th>
						<th>用户名</th>
						<th>代理名称</th>
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

					@if(isset($arr)&&$arr!=null)
					@foreach($arr as $key=>$value)
					<tr>
						<td><input type="checkbox" value="{{$value['username']}}" name="checkbox"/></td>
						<td>{{$value['username']}}</td>
						<td>{{$value['nick_name']}}</td>
						<td>{{$value['reportFail']}}</td>
						<td>{{$value['auth']}}</td>
						<td>{{$value['report']}}</td>
						<td>{{$value['work']}}</td>
						<td>{{$value['order']}}</td>
						<td>{{$value['agentMoney']}}</td>
						<td>{{$value['ti_money']}}</td>
						<td>{{$value['status']==1?"启用中":"已禁用"}}</td>
						<td>
							<a href="{{URL::asset('index.php/agent/editAgent?aid='.$value['id'])}}" class="btn btn-blue">编辑</a>
							@if($value['status']==1)
								<button id="{{$value['id']}}" name="{{$value['username']}}" class="btn btn-red btn-forbidden">禁用</button>
							@else
								<button id="{{$value['id']}}" name="{{$value['username']}}" class="btn btn-red btn-action">启用</button>
							@endif
							<a href="{{URL::asset('index.php/agent/report/analyseSonAgent?id='.$value['id'])}}" class="btn btn-blue">报表</a>
							<button id="{{$value['id']}}" name="{{$value['username']}}" class="btn btn-red btn-delete">删除</button>
						</td>
					</tr>
					@endforeach
					@endif

				</table>
				@if(isset($paginator) && $parameter)
					{{$paginator->appends($parameter)->render()}}
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
			//下拉菜单
			$('#navDropdown').on('show.bs.dropdown',function(){
				$('.top-caret').hide()
				$('.bottom-caret').show()
			})
			
			$('#navDropdown').on('hide.bs.dropdown',function(){
				$('.top-caret').show()
				$('.bottom-caret').hide()
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

			$(".reset").click(function(){
				window.location.href='/agent/agentList';
			})

		})

		function requestFunction(type,id){
			//{"success":true,"data":1}
			$.getJSON('{{URL::asset('index.php/agent/setmanagerList') }}', {"type": type, "id": id},
					function (data) {
						if (data > 0) {
							window.location.href = '/agent/agentList'
						}
					});
		}
	</script>
	<script type="text/javascript">
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
		
		function selectItem(){
			var str='';
			var items=$('td input[type=checkbox]:checked');
			console.log(items)
			items.each(function(){
				var $text=$(this).parents('tr').find('td').eq(2).text();
				str+='<span>'+$text+'</span>'
			})
			return str;
		}
	</script>
</html>
