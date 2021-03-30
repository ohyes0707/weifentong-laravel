<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>公众号列表</title>
		@include('Operate.common.head')
		<style type="text/css">
			.gh_img{
				display: block;
				width: 50px;
				height: 50px;
				margin: 0 auto;
			}
			.position{
				position: relative;
			}
			#ul_hide{
				position: absolute;
				right: 0;
				z-index: 999;
				background: #fff;
				border: 1px solid #ccc;
				border-radius: 4px;
				width: auto;
				box-sizing: content-box;

			}
			#ul_hide li{
				padding: 0 10px;
				min-width: 100px;
			}
			.detail tr>th{
				width: 10%;
			}
			.detail tr>th:first-child{
				width:20%;
			}
			.detail tr>th:nth-child(2){
				width: 20%;
			}
			.detail tr>th:last-child{
				width: 15%;
			}
		</style>
	</head>
	<body>
	@include('Operate.common.top')
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			<!--右侧-->
			<div class="main-right">
				<form action="" method="post" class="form-inline" role="form" id="f-report">
					{{csrf_field()}}
					<div class="form-group position">
					    <label>
					    	公众号：					    	
					    </label>
					    <input type="text" id="inputv" onkeyup="checkFunction()" name="wx_id" @if(isset($wx_id))value="{{$wx_id}}"@endif class="form-control">
						<ul id="ul_hide">
							@if(isset($wx_name) && !empty($wx_name))
								@foreach($wx_name as $k=>$v)
									<li class="option_obj" style="display: none;">{{$v['wx_name']}}</li>
								@endforeach
							@endif
						</ul>
						<script>
							$(".option_obj").click(function(){
								var wxname = $(this).text();
								$("#inputv").val(wxname);
								$(".option_obj").hide();
							})

							function checkFunction(){
								var inputv,filter,ul,li,a,i;
								inputv = document.getElementById('inputv');
								filter = inputv.value.toUpperCase();
								ul =  document.getElementById('ul_hide');
								li = ul.getElementsByTagName('li');
								if(filter==''){
									$(".option_obj").hide();
									return false;
								}
								for(i=0;i<li.length;i++){
									var tt = li[i].innerHTML.toUpperCase().indexOf(filter);
									if(tt>=0){
										li[i].style.display = "";
									}else{
										li[i].style.display = "none";
									}
								}
							}
						</script>
					</div>
					<input type="hidden" name="excel" value="0">
					<input type="button" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<input type="button" value="导出excel" class="excel"/>
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>公众号</th>
						<th>门店</th>
						<th>类型</th>
						<th>是否认证</th>
						<th>所属销售</th>
						<th>状态</th>
						<th>头像</th>
						<th>原始ID</th>
						{{--<th>操作</th>--}}
					</tr>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['wx_name']}}</td>
								<td>
									@if($v['default_shopname'])
										{{$v['default_shopname']}}
									@else
										未知
									@endif
								</td>
								<td>{{$v['service_type']}}</td>
								<td>{{$v['verify_type']}}</td>
								<td>{{$v['nick_name']}}</td>
								<td>{{$v['status']}}</td>
								<td>
									@if($v['head_img'])
										<img src="http://{{$lumen}}storages/Wx/{{$v['head_img']}}" class="gh_img"/>
									@endif
								</td>
								<td>{{$v['ghid']}}</td>
								{{--<td>--}}
									{{--<button type="button" class="btn btn-blue set_banner">banner设置</button>--}}
								{{--</td>--}}
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator}}
				@endif
			</div>
		</div>	
	</body>
	<script type="text/javascript">
		$(function(){
			
			//左边菜单栏缩略
//			$('.menu-title').click(function(){
//				var $this=$(this);
//				var $menu=$this.parent('.menu-header');
//				var $list=$this.siblings('.menu-list');
//				if($list.is(':hidden')){
//					$menu.addClass('open');
//					$list.show();
//				}else{
//					$menu.removeClass('open');
//					$list.hide();
//				}
//			})
			
			$('.set_banner').click(function(){
				window.location.href="banner"
			})
			$(".reset").click(function(){
				var bid = $("input[name=bid]").val();
				var bname = $("input[name=bname]").val();
				window.location.href='list';
			})
			$(".find").click(function(){
				$("input[name=excel]").val(0);
				var startDate = new Date($('#datetimeStart').val()).getTime()
				var endDate = new Date($('#datetimeEnd').val()).getTime()
				var delta=parseInt((endDate-startDate)/1000/60/60/24);
				if(delta>29){
					alert('数据太多啦，请导出Excel查看');
				}else{
					$("#f-report").submit();
				}
			})
			$(".excel").click(function(){
				$("input[name=excel]").val(1);
				var excel = $("input[name=excel]").val();
				$("#f-report").submit();
			})
		})
	</script>
</html>
