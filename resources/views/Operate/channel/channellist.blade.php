
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>用户管理-渠道列表</title>
		@include('Operate.common.head')	
                <style type="text/css">
			.f_channel>td:nth-child(1){
				padding-left: 0;
				background: none;
			}
			.sub_channel>td:nth-child(1){
				padding-left: 0;
				background: none;
			}
			.sub_channel>td:nth-child(2){
				padding-left: 68px;
				background: url(../img/icon-open3.png) no-repeat 40px center;
			}
			
			.on_channel>td:nth-child(2){
				background: url(../img/icon-open2.png) no-repeat 10px center;
			}
			.off_channel>td:nth-child(2){
				background: url(../img/icon-close2.png) no-repeat 10px center;
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
				
				<div class="main-top clearfix">
					<div class="oprate-btns">
						<a href="ManageAddChannel" class="btn btn-blue">新增</a>
						<button class="btn btn-blue btn-use" disabled>启用</button>
						<button class="btn btn-red btn-forbidden" disabled>禁用</button>
<!--						<button class="btn btn-red btn-delete" disabled>删除</button>-->
					</div>
					<form action="" method="get" class="checkform">
						<input type="text" name="keycode" placeholder="查询渠道" class="input"/>
						<input type="submit" value="查询" class="find"/>
					</form>
				</div>
                            <form action="ManageUpdateChannels" method="get" name = "form" id="updata"> 
				<table class="table-bordered table-responsive detail d-table check-table">
					<tr>
						<th><input type="checkbox" name="checkbox"/></th>
						<th>渠道</th>
						<th>结算一口价</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
                                          
                                            @foreach ($paginator['data'] as $key => $datalist)


                                                <tr class="f_channel 
                                                    @if(isset($datalist['list']))
                                                        off_channel
                                                    @else
                                                        on_channel
                                                    @endif
                                                    " channelId="{{$key}}">
                                                        <td><input type="checkbox" name="checkbox[]" value="{{$key}}"/></td>
                                                        <td>{{$datalist['nick_name']}}</td>
                                                        <td>{{$datalist['cost_price']}}</td>
                                                        @if($datalist['status']==1)
                                                        <td class="blue">启用中</td>
                                                        @else
                                                        <td class="red">已禁用</td>
                                                        @endif
                                                        
                                                        <td>
                                                                <a href="ManageEditeChannel?id={{$key}}" class="btn btn-blue">编辑</a>
                                                                <button type="button" class="btn btn-blue btn-use" tit="{{$key}}">启用</button>
                                                                <button type="button" class="btn btn-red btn-forbidden" tit="{{$key}}">禁用</button>
<!--                                                                <button type="button" class="btn btn-red btn-delete" tit="{{$key}}">删除</button>-->
                                                                <a href="ManageAddSonChannel?id={{$key}}" class="btn btn-blue">新增子渠道</a>
                                                        </td>
                                                </tr>
                                                @if(isset($datalist['list']))
                                                    @foreach ($datalist['list'] as $key2 => $datalist2)
                                                        <tr class="sub_channel" fatherId="{{$key}}">
                                                                <td><input type="checkbox" name="checkbox[]" value="{{$datalist2['id']}}"/></td>
                                                                <td>{{$datalist2['nick_name']}}</td>
                                                                <td>{{$datalist2['cost_price']}}</td>
                                                                @if($datalist2['status']==1)
                                                                <td class="blue">启用中</td>
                                                                @else
                                                                <td class="red">已禁用</td>
                                                                @endif
                                                                <td>
                                                                        <a href="ManageEditeSonChannel?id={{$datalist2['id']}}" class="btn btn-blue">编辑</a>
                                                                        <button type="button" class="btn btn-blue btn-use" tit="{{$datalist2['id']}}">启用</button>
                                                                        <button type="button" class="btn btn-red btn-forbidden" tit="{{$datalist2['id']}}">禁用</button>
<!--                                                                        <button type="button" class="btn btn-red btn-delete" tit="{{$datalist2['id']}}">删除</button>-->
                                                                </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            
                                          
				</table>
                                    <input type = "text" name = "type" value = "" hidden="" id="updataType"> 
                                    <input type = "submit" name = "tijiao" value = "提交" onclick="check_black();" hidden="">   
                                </form>        
				{{ $paginator->appends($termarray)->render() }}
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
                    var id;
                    var type;

			
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
                                id = $(this).attr("tit");
                                type = 'startup';
				$('.myalert').show()
				var selectItems=selectItem()
				$('.alertMain').html('<p>请确认是否启用以下项目：</p><div>'+selectItems+'</div>')
			})
			$('.detail .btn-use').click(function(){
                                id = $(this).attr("tit");
                                type = 'startup';
				$('.myalert').show()
				$('.alertMain').html('<p class="txt-align">请确认是否启用？</p>')
			})
			//禁用
			$('.oprate-btns .btn-forbidden').click(function(){
                                id = $(this).attr("tit");
                                type = 'prohibit';
				$('.myalert').show();
				var selectItems=selectItem()
				$('.alertMain').html('<p>请确认是否禁用以下项目：</p><div>'+selectItems+'</div>')
			})
			$('.detail .btn-forbidden').click(function(){
                                id = $(this).attr("tit");
                                type = 'prohibit';
				$('.myalert').show()
				$('.alertMain').html('<p class="txt-align">请确认是否禁用？</p>')
			})
			//删除
			$('.oprate-btns .btn-delete').click(function(){
                                id = $(this).attr("tit");
                                type = 'delete';
				$('.myalert').show()
				var selectItems=selectItem()
				$('.alertMain').html('<p>请确认是否删除以下项目：</p><div>'+selectItems+'</div>')
			})
			$('.detail .btn-delete').click(function(){
                                id = $(this).attr("tit");
                                type = 'delete';
				$('.myalert').show()
				$('.alertMain').html('<p class="txt-align">请确认是否删除？</p>')
			})
			//取消按钮
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide()
			})
			//确认按钮
			$('.btn-sure').click(function(){
                            var myalertHtml = $('.alertMain').html();
                                if(myalertHtml.indexOf('txt-align') >= 0){
                                    window.location.href="ManageUpdateChannel?id="+id+"&type="+type;
                                    $('.myalert').hide()
                                }else{
                                    $('#updataType').val(type);
                                    document.getElementById("updata").submit();
                                }

			})
			
			
		})
                function selectItem(){
			var str='';
			var items=$('td input[type=checkbox]:checked');
			console.log(items)
			items.each(function(){
				var $text=$(this).parents('tr').find('td').eq(1).text();
				str+='<span>'+$text+'</span>'
			})
			return str;
		}

	</script>
</html>

