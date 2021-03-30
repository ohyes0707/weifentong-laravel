<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-公众号订单-新增订单</title>
		@include('Operate.common.head')
		<style type="text/css">
			.form{
				width: 700px;
			}
			.text-input{
				width: 580px;
			}
			.area-list{
				white-space: normal;
			}
			.area-list .text-input{
				padding-bottom: 10px;
			}
			.select_shop{
				display: inline-block;
				border: 1px solid #cbcad8;
			    width: 225px;
			   	height: 34px;
			    border-radius: 4px;
			}
			div.text-input{
				height:auto;
			}
			.chosen-show span {
				float: left;
			}

			span.tag {
				position: relative;
				margin: 5px 8px;
			}
			span.tag>span {
				padding:0;
				height: 30px;
				line-height: 30px;
				padding-right: 6px;
				padding-left: 4px;
				border: 1px solid #3EA9F5;
				border-radius: 4px;
				background: #fff;
			}
			span.tag a {
				text-indent: -9999px;
				position: absolute;
				top: 0;
				right: 0;
				width: 16px;
				height: 16px;
				background: url(/operate/img/icon23.png) no-repeat center;
			}

			.chosen-show span{
				float: left;
			}
			.city-chosen {
				float: left;
			}
			.chosen-show>span, .chosen-show>a {
				margin: 9px 0;
				float: left;
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
				width:580px;
			}
			#ul_hide{
				left: 110px;
				right: auto;
				top:34px;
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
				<div class="header">新增订单</div>
				
				<form action="" method="post" class="form">
					{{csrf_field()}}
					<div class="form-list position">
						<label>选择公众号：</label>
						<input type="text" id="inputv" onkeyup="checkFunction()" name="gzh" class="form-control text-input">
						<ul id="ul_hide">
							@if(isset($wx_list) && !empty($wx_list))
								@foreach($wx_list as $k=>$v)
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
						{{--<select name="gzh" class="text-input">--}}
							{{--<option value="">请选择</option>--}}
							{{--@if(isset($wx_list) && !empty($wx_list))--}}
								{{--@foreach($wx_list as $k=>$v)--}}
									{{--<option value="{{$v['wx_id']}}">{{$v['wx_name']}}</option>--}}
								{{--@endforeach--}}
							{{--@endif--}}
						{{--</select>--}}
					</div>
					<div class="form-list area-list">
						<label>选择品牌：</label>
						<div class="text-input">
							<div class="chosen-show clearfix">
								<span>当前选择：</span>
								<a href="javascript: void(0);" class="clear">[清空已选]</a>
								<div class="city-chosen">
									<input name="tags" id="tags" value="" />
								</div>
							</div>
							<div class="choose">
								<select name="" id="select_area" class="select_shop">
									<option value="0">请选择目标区域</option>
									@if(isset($area) && !empty($area))
										@foreach($area as $k=>$v)
											<option value="{{$v['bid']}}">{{$v['nick_name']}}</option>
										@endforeach
									@endif
								</select>
								<select name="" class="select_shop" id="select_shop">
									<option value="0">请选择</option>
									@if(isset($brand) && !empty($brand))
										@foreach($brand as $k=>$v)
											<option value="{{$v['brand_id']}}">{{$v['brand_name']}}</option>
										@endforeach
									@endif
								</select>
							</div>
							<div id="hidden_area">

							</div>
						</div>
					</div>
					<input type="button" value="确定" class="submit"/>
					<input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此公众号？
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认"/>
								<button type="button" class="btn btn-cancel">取消</button>
							</div>
						</div>
					</div>
				</form>
				
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
//			var $citypicker1=new CityPicker($('#city-picker1'),
//				{
//					ChineseDistricts:ChineseDistricts,
//					nodistrict: true
//				});
				
			$('#tags').tagsInput({
				width: 'auto',
				height: '38px',
                onRemoveTag:function(tag){
                    $('#hidden_area input').each(function(){
                        if($(this).attr('txt') === tag){
                            $(this).remove()
                        }
                    })
                    console.log()
                },
			});
			$('#tags_tag').hide();

			$('#select_area').on('change',function(){
				var val = $(this).val();
				var str='<option value="0">请选择</option>';
				$.getJSON('getBrand',{'area':val},function(data){
					$.each(data,function(i,v){
						str += '<option value="'+ v.brand_id+'">'+ v.brand_name+'</option>'
					})
					$('#select_shop').html(str)
				})

			})

			$('#select_shop').on('change',function(){

//					if($(this).val() != '0'){
//						var city = $('#select_area').find('option:selected').text();
//						var opt = $(this).find('option:selected').text();
//						var val = city+'/'+opt;
//						if(!$('#tags').tagExist(val)){
//							$('#tags').addTag(val);
//						}
//					}
                if($(this).val() != '0'){
                    var city = $('#select_area').find('option:selected').text();
                    var opt = $(this).find('option:selected').text();
                    var city_code=$('#select_area').val();
                    var opt_code=$(this).val()
                    var val = city+'/'+opt;
                    var select_code=city_code+'/'+opt_code
                    if(!$('#tags').tagExist(val)){
                        $('#tags').addTag(val);
                        $('#hidden_area').append('<input type="hidden" name="select_brand[]" value="'+ select_code+'" txt="'+val+'"/>')
                    }
                }

				
			})
            $('.clear').click(function(){
                $('#tags').importTags('');
                $('#hidden_area').html('')
            })
			$('.clear').click(function(){
				$('#tags').importTags('');
			})

			$('.submit').click(function(){
				$('.myalert').show()
			})
			$('.btn-cancel').click(function(){
				$('.myalert').hide()
			})
		})
	</script>
</html>
