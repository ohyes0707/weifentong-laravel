<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>实时数据表</title>
		@include('Operate.common.head')	
	</head>
	<body>
		@include('Operate.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
			@include('Operate.common.left')
			
			<!--右侧-->
			<div class="main-right">
				<form action="" method="get" class="form-inline" role="form" id="f-report">
					<div class="r_form real-form clearfix">
						<div class="f_radio">
							<a href="realtime">平台数据</a>
							<a href="javascript: void(0)" class="on_radio">渠道数据</a>
						</div>
					</div>
					
					<div class="form-group">
					    <label>
					    	父渠道：				    	
					    </label>
                                            <select name="f-channel" class="form-control" id="f-channel">
					    	<option value="">全部</option>
					    </select>						    
					</div>
					<div class="form-group">
					    <label>
					    	子渠道：				    	
					    </label>
					    <select name="s-channel" class="form-control" id="s-channel" disabled>
					    	<option value="0">全部</option>
					    	<option value="1">数芳科技</option>
					    	<option value="2">酒店</option>
					    	<option value="3">爱上网</option>
					    </select>						    
					</div>
					<input type="button" value="查询" class="find"/>	
                                        <input type="submit" hidden="" class="find"/>	
					<input type="reset" value="重置" class="reset"/>	
				</form>
				
				<table class="table-bordered table-responsive detail">
					<tr>
						<th>渠道名称</th>
						<th>获取公众号</th>
						<th>成功获取公众号</th>
						<th>填充率</th>
						<th>微信认证</th>
						<th>认证率</th>
						<th>成功关注</th>
						<th>关注率</th>
					</tr>
<!--					<tr>
						<td>数芳科技</td>
						<td>500</td>
						<td>400</td>
						<td>80%</td>
						<td>300</td>
						<td>75%</td>
						<td>200</td>
						<td>66%</td>
					</tr>
					<tr>
						<td>顺巴</td>
						<td>500</td>
						<td>400</td>
						<td>80%</td>
						<td>300</td>
						<td>75%</td>
						<td>200</td>
						<td>66%</td>
					</tr>-->
				</table>
				
				
				
			</div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function(){
//		    //左边列表栏缩略
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
			
			$('#f-channel').change(function(){
                            
				if($(this).val() == '0'){
					$('#s-channel').prop('disabled',true)
				}else{
                                        getData3();
					$('#s-channel').prop('disabled',false)
				}
			})
		   
		    
		})
	</script>
        
        <script type="text/javascript">
            getData();
            getData2();
		setInterval(function(){
			getData();
		},5000)
		
		
		function getData(){
			var str='<tr><th>渠道名称</th><th>获取公众号</th><th>成功获取公众号</th><th>填充率</th><th>微信认证</th><th>认证率</th><th>成功关注</th><th>关注率</th></tr>';
                        $.ajax({
				type:"get",
				url:"http://{{Config::get('config.API_URL')}}data/getSumDesc/v1.0",
				success: function(data){
                                    var arr=data.data;
                                   $.each(arr,function(i,v){ 
                                        var fillrate = division(v.getwx,v.sumgetwx);
                                        var confirmrate = division(v.complet,v.getwx);
                                        var followate = division(v.follow,v.complet);
                                        str+='<tr><td>'+v.pbusername+'</td><td>'+v.sumgetwx+'</td><td>'+v.getwx+'</td><td>'+fillrate+'%</td><td>'+v.complet+'</td><td>'+confirmrate+'%</td><td>'+v.follow+'</td><td>'+followate+'%</td></tr>'
                                       });
                                       
                                       
                                    //console.log(data.data);
//					str+='<tr><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td></tr>'
					$('table.detail').html(str);
				}
			});
		}
                
		function getData2(){
			var str='<tr><th>渠道名称</th><th>获取公众号</th><th>成功获取公众号</th><th>填充率</th><th>微信认证</th><th>认证率</th><th>成功关注</th><th>关注率</th></tr>';
			var select='<option value="">全部</option>';
                        $.ajax({
				type:"get",
				url:"http://{{Config::get('config.API_URL')}}data/getSumDesc/v1.0",
				success: function(data){
                                    var arr=data.data;
                                   $.each(arr,function(i,v){ 
                                        var fillrate = division(v.getwx,v.sumgetwx);
                                        var confirmrate = division(v.complet,v.getwx);
                                        var followate = division(v.follow,v.complet);
                                        str+='<tr><td>'+v.pbusername+'</td><td>'+v.sumgetwx+'</td><td>'+v.getwx+'</td><td>'+fillrate+'%</td><td>'+v.complet+'</td><td>'+confirmrate+'%</td><td>'+v.follow+'</td><td>'+followate+'%</td></tr>'
                                        select+='<option value="'+i+'">'+v.pbusername+'</option>';
                                       });
                                       
                                       
                                    //console.log(data.data);
//					str+='<tr><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td><td>'+data.data.sumgetwx+'</td></tr>'
					$('table.detail').html(str);
                                        $('#f-channel').html(select)
				}
			});
                        $('#s-channel').prop('disabled',true)
		}
                
		function getData3(){
			var select='<option value="">全部</option>';
                        var val=$('.form-control').val();
                        $.ajax({
				type:"get",
				url:"http://{{Config::get('config.API_URL')}}data/getSumDesc/v1.0",
                                data:{ "pbid": val },
				success: function(data){
                                    var arr=data.data;
                                   $.each(arr,function(i,v){ 

                                        $.each(v.list,function(ii,vv){
                                            select+='<option value="'+vv.bussid+'">'+vv.username+'</option>';
                                        });
                                        
                                       });
                                        $('#s-channel').html(select)
				}
			});
		}
                
                function division(num1,num2){
			var result;
			if(num2 == 0){
				result=0;
			}else{
				result=parseFloat(num1/num2*100).toFixed(2);
			}
			return result;
		}
                
                $(function(){
                        $('.find').click(function(){
                            if($('#f-channel').val()>0){
                                if($('#s-channel').val()>0){
                                    var path = "realtimebussdesc";  
                                    $('.form-inline').attr("action", path).submit();
                                }else{
                                    var path = "realtimepbdesc";  
                                    $('.form-inline').attr("action", path).submit();
                                }
                            }else{
                                var path = "realtimedesc";  
                                $('.form-inline').attr("action", path).submit();
                            }
                        })
                        
                        $('.reset').click(function(){
                            window.location.href="realtimedesc"; 
                        })
                })
        </script>
</html>
