<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-品牌管理</title>
		@include('Operate.common.head')
		<style type="text/css">
			.detail tr>th:nth-child(2){
				width: 70%;
				text-align: left;
				padding-left: 40px;
			}
			.detail tr>td:nth-child(2){
				text-align: left;
				padding-left: 40px;
			}
			.detail .btn{
				margin-right: 40px;
			}
			.addalert .title{
				padding: 18px 0;
				font-size: 24px;
			}
			.add_input{
				width: 300px;
			    height: 34px;
			    border: 1px solid #ccc;
			    border-radius: 4px;
			    padding: 0 10px;
			    margin-top: 20px;
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
					<div class="form-group">
					    <label>
					    	选择品牌：					    	
					    </label>
					    <select name="brand" class="form-control">
					    	<option value="">全部</option>
							@if(isset($brand_list))
								@foreach($brand_list as $k=>$v)
									@if(isset($brand) && $brand == $v['brand_id'])
										<option value="{{$v['brand_id']}}" selected>{{$v['brand_name']}}</option>
									@else
										<option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
									@endif
								@endforeach
							@endif
					    </select>						    
					</div>
					<input type="submit" value="查询" class="find"/>
					<input type="reset" value="重置" class="reset"/>
					<button type="button" class="add">+ 添加品牌</button>
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>品牌</th>
						<th>操作</th>
					</tr>
					<input type="hidden" name="brand_id" value=""/>
					@if(isset($list) && !empty($list))
						@foreach($list as $k=>$v)
							<tr>
								<td>{{$v['brand_name']}}</td>
								<td>
									{{--<button type="button" class="btn btn-red btn_delete del" bid = '{{$v['brand_id']}}'>删除</button>--}}
									<a href="brandPortal?bid={{$v['brand_id']}}" class="btn btn-blue">Portal设置</a>
								</td>
							</tr>
						@endforeach
					@endif
				</table>
				@if(isset($paginator))
					{{$paginator->appends($post)->render()}}
				@endif
				<div class="addalert" style="display: none;">
					<div class="mask"></div>
					<div class="alertbox">
						<form action="brand" method="post">
							{{csrf_field()}}
							<div class="title">添加品牌</div>
							<div>
								<input type="text" name="brand_name" placeholder="输入品牌名称" class="add_input"/>
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认">
								<button type="button" class="btn btn-cancel">取消</button>
							</div>
						</form>
						
					</div>
				</div>
				
				<div class="myalert" style="display: none;">
					<div class="mask"></div>
					<div class="alertbox">
						<a href="#" class="close">&times;</a>
						<div class="alertHead">提示</div>
						<div class="alertMain">
							请确认是否删除该品牌？
						</div>
						<div class="alertbtn">
							<input type="button" class="btn btn-sure" value="确认" />
							<button type="button" class="btn btn-cancel">取消</button>
						</div>
					</div>
				</div>
				
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
			
			$('.add').click(function(){
				$('.addalert').show()
			})
			
			$('.btn-cancel').click(function(){
				$('.addalert,.myalert').hide()
			})
			
			$('.btn_delete').click(function(){
				$('.myalert').show()
			})
			
			$('.btn-sure[type=button]').click(function(){
				var bid = $("input[name=brand_id]").val();
				window.location.href = 'brandDel?bid='+bid;
				$('.myalert').hide()
			})
			$(".reset").click(function(){
				window.location.href = 'brand';
			})
			$(".del").click(function(){
				var brand_id = $(this).attr('bid');
				$("input[name=brand_id]").val(brand_id);
			})
		})
	</script>
</html>
