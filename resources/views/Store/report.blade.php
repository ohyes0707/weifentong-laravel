<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>美业管理-公众号授权</title>
	@include('Operate.common.head')
	<style type="text/css">
		.detail tr>th:nth-child(5){
			width: 16%;
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
					选择公众号：
				</label>
				<input type="text" id="inputv" name="wxName" value="{{isset($wxname)?$wxname:''}}" class="form-control">
			</div>
			<div class="form-group">
				<label>
					授权状态：
				</label>
				<select name="state" class="form-control">
					@foreach($statuArray as $key=>$value)
						@if(isset($state) && $state==$key )
							<option value="{{$key}}" selected>{{$value}}</option>
							@else
							<option value="{{$key}}">{{$value}}</option>
						@endif

					@endforeach
				</select>
			</div>
			<input type="submit" value="查询" class="find"/>
			<input type="reset" value="重置" class="reset"/>
			<a class="add" href="{{URL::asset('index.php/store/addreport')}}">+ 新增公众号</a>
		</form>

		<table class="table-bordered table-responsive detail">
			<tr>
				<th>公众号</th>
				<th>申请时间</th>
				<th>门店名称</th>
				<th>联系人</th>
				<th>联系方式</th>
				<th>授权状态</th>
				<th>操作</th>
			</tr>

			@if(isset($reportlist) && count($reportlist)>0)
				@foreach($reportlist as $value)
					<tr>
						<td>{{$value['wx_name']}}</td>
						<td>{{$value['create_time']}}</td>
						<td>{{$value['store_name']}}</td>
						<td>{{$value['contacts']}}</td>
						<td>{{$value['contact_way']}}</td>
						@if($value['status']==1)
							<td class="yellow">申请中</td>
						@elseif($value['status']==2)
							<td class="yellow">授权成功</td>
						@elseif($value['status']==3)
							<td class="yellow">授权失败</td>
						@endif

						@if($value['status']==2)
							<td style="width: 100%;" ><button type="button" class="btn btn-grey">授权成功</button> <button type="button" lid="{{$value['id']}}" class="btn btn-blue shop">门店</button></td>

						@else
							<td><button type="button" l_id="{{$value['id']}}" class="btn btn-blue authrize">授权</button></td>
						@endif
					</tr>
				@endforeach
			@endif
		</table>
		{{$paginator ->appends($parameter)->render()}}
	</div>
</div>



<div class="shopSelect" style="display: none;">
	<div class="mask"></div>
	<div class="shopMain">
		<p>请选择用于涨粉的场景（门店）</p>
		<select name="shop" class="form-control">
		</select>

		<div class="shopbtn">
			<input type="button" value="完成准备工作" onclick="submitinfo()" class="btn finishbtn"/>
			<input type="button" value="关闭" class="btn closebtn"/>
		</div>
	</div>
    <input type="hidden" name="wx_id" value="" />
</div>
</body>
<script type="text/javascript">
	$(function() {
		$(".reset").click(function(){
			window.location.href='/store/report';
		})


		$('.closebtn').click(function () {
			$('.shopSelect').hide()
		})

		//授权类型操作
		$('.authrize').click(function () {
			var rid = $(this).attr('l_id');
			{{--var url = "{{$url}}";--}}

			window.location.href = "{{ URL::asset('index.php/store/authrize') }}" + "?rid=" + rid; //暂时如此;


			{{--window.location.href = "{{ URL::asset('index.php/home/report/addauth') }}"+"?url="+url+"&rid="+rid; //暂时如此;--}}
		})

		$('.shop').click(function () {


			var rid = $(this).attr('lid');

				$.getJSON("{{URL::asset('index.php/store/shop')}}"+'?rid='+rid,function(res){
					if(res.data != 'null'){
						$(".shopSelect").show();
						console.log(res.data.list);
                        $("select[name=shop]").empty();
						$.each(res.data.list, function (i, v) {
                            $("select[name=shop]").append("<option class='data' value='" + v.shop_id + "'>" + v.shop_name + '</option>');
						});
                        $("input[name=wx_id]").val(res.data.meiyewxid);
					}else{

						alert('暂时没有门店信息');
					}
				});

		})


	})

	function submitinfo (){
		var wxid = $('input[name=wx_id]').val();
		var shop_id = $(".shopSelect").find("option:selected").val();
		var shop_name = $(".shopSelect").find("option:selected").text();

		$.getJSON("{{ URL::asset('index.php/store/set_default') }}"+"?shopid="+shop_id+"&shopname="+shop_name+'&wxid='+wxid,function(res){
			if(res.data.data == 1)
			{
				$(".shopSelect").css('display','none');
			}else{
				alert('门店修改失败啦');
			}
		});
	}
</script>
</html>
