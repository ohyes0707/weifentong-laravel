
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>代理管理-代理列表-新增代理</title>
		@include('Operate.common.head')	
		<script src="{{ URL::asset('js/ajaxfileupload.js') }}" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.agency_form{
				width: 75%;
				margin: 0 auto;
				overflow: visible;
				white-space: nowrap;
				padding-bottom: 40px;
			}
			.form-list .in_label{
				text-align: right;
				margin-right: 10px;
				width: 170px;
			}
			.form-list .text-input{
				width: 63%;
			}
			.tip-text{
				white-space: normal;
			}
			.add_icon{
				display: block;
				width: 40px;
				height: 40px;
				background: url({{ URL::asset('operate/img/icon-add.png') }}) no-repeat center;
				background-size: 100% 100%;
			}
			.form-list-right{
				float: left;
				width: 63%;
			}
			.choose_box{
				width: 160px;
				height: 160px;
				border-radius: 4px;
				background: #EBEBEB;
				position: relative;
			}
			.choose_box img{
				display: block;
				width: 100%;
				height: 100%;
				border-radius: 4px;
			}
			.banner_choose_box{
				width: 220px;
			}
			.upload_box{
				width: 100%;
				height: 100%;
				position: absolute;
				left: 0;
				top: 0;
				text-align: center;
			}
			.add_icon{
				margin: 45px auto 10px;
			}
			.upload-text{
				line-height: 1;
				color: #777;
			}
			
			#drags li{
				float: left;
				margin-right: 20px;
				margin-bottom: 20px;
			}
			.img_show_box{
				width: 220px;
				height: 160px;
				border-radius: 4px;
				position: relative;
				cursor: move;
			}
			.img_show_box .show_pic{
				width: 100%;
				height: 100%;
				border-radius: 4px;
			}
			.pic_delete{
				width: 26px;
				height: 26px;
				position: absolute;
				right: 10px;
				top: 10px;
				background: url({{ URL::asset('operate/img/icon_delete.png') }}) no-repeat center;
				background-size: 100% 100%;
				opacity: 0;
				transition: opacity 1s;
				-webkit-transition: opacity 1s; 
				cursor: pointer; 
			}
			.pic_drag{
				width: 100%;
				height: 40px;
				position: absolute;
				left: 0;
				bottom: 0;
				text-align: center;
				color: #fff;
				background: rgba(0,0,0,.4);
				line-height: 40px;
				border-bottom-left-radius: 4px;
				border-bottom-right-radius: 4px;
				opacity: 0;
				transition: opacity 1s;
				-webkit-transition: opacity 1s;  
			}
			.img_show_box:hover .pic_delete{
				opacity: 1;
			}
			.img_show_box:hover .pic_drag{
				opacity: 1;
			}
			.submit{
				margin-left: 180px;
				margin-right: 10px;
			}
			.prev{
				color: #3EA9F5;
				border: none;
				background: #fff;
				height: 34px;
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
				<div class="header">新增代理</div>
				
				<form action="" method="post" class="agency_form" enctype="multipart/form-data" id="addAgencyForm">
				{{csrf_field()}}
					<div class="step">
						<div class="form-list">
							<label class="in_label">账号：</label><input type="input" name="account" placeholder="手机号码" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">密码：</label><input type="password" name="password" placeholder="初始密码默认为123456" class="text-input" disabled/>
						</div>
						<div class="form-list">
							<label class="in_label">昵称：</label><input type="input" name="agencyName" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">保底价：</label><input type="input" name="minPrice" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">OEM：</label>
							<label class="label-radio l_radio"><input type="radio" name="OEM" checked value="1"/>支持</label>
							<label class="label-radio"><input type="radio" name="OEM" value="2"/>不支持</label>
						</div>
						<input type="button" value="下一步" class="submit next"/>
					</div>
					
					
					<div class="step" style="display: none;">
						<div class="form-list">
							<label class="in_label">公司名称：</label><input type="input" name="company" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">联系电话：</label><input type="input" name="phone" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">QQ：</label><input type="input" name="qq_bumber" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">公司地址：</label><input type="input" name="address" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">产品名：</label><input type="input" name="production" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">网站域名：</label><input type="input" name="website" class="text-input"/>
						</div>
						<div class="form-list">
							<label class="in_label">公司简介：</label><textarea name="description" class="text-input"></textarea>
						</div>
						<div class="form-list">
							<label class="in_label">公司logo：</label>
							<div class="form-list-right">
								<p class="tip-text">提示：图片格式必须为png；建议图片尺寸高度为50px。</p>
								<div class="img_upload">
									<input type="file" name="logo" value="" accept="image/png" style="display: none;" class="choose_input" onchange="filechange(event)"/>
									<div class="choose_box">
										<img id="logo" class="selected_pic"/>
										<div class="upload_box">
											<span class="add_icon"></span>
											<div class="upload-text">上传logo</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-list">
							<label class="in_label">公司介绍页面banner：</label>
							<div class="form-list-right">
								<p class="tip-text">提示：图片格式必须为png、jpg；建议图片尺寸1200px*400px。</p>
								<div class="img_upload">
									<input type="file" name="company_banner" value="" accept="image/png,image/jpeg" style="display: none;" class="choose_input" onchange="filechange(event)"/>
									<div class="choose_box banner_choose_box">
										<img class="selected_pic"/>
										<div class="upload_box">
											<span class="add_icon"></span>
											<div class="upload-text">上传图片</div>
										</div>	
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-list">
							<label class="in_label">首页banner：</label>
							<div class="form-list-right">
								<p class="tip-text">提示：图片格式必须为png、jpg；建议图片尺寸1920*900px。</p>
								<div class="img_upload">
									<input type="file" name="index_banner" value="" accept="image/png,image/jpeg" style="display: none;" class="choose_input" id="indexBanner" onchange="onc()" />
									<div class="choose_box banner_choose_box" style="float: left;margin: 0 20px 20px 0;">
										<img class="selected_pic"/>
										<div class="upload_box">
											<span class="add_icon"></span>
											<div class="upload-text">上传图片</div>
										</div>	
									</div>
									<ul id="drags">
										
									</ul>
								</div>
							</div>
						</div>
						<input type="text" name="index_banner_imgs" class="index_banner_imgs" value="" style="display: none;" />
						<input type="button" value="确定" class="submit" id="sub-btn"/>
						<input type="button" value="返回修改" class="prev"/>
					</div>

					<div class="myalert myalert_1" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain_1">
								
							</div>
							<div class="alertbtn">
								<button class="btn btn-cancel" type="button">确定</button>
							</div>
						</div>
					</div>
					
					<div class="myalert" style="display: none;">
						<div class="mask"></div>
						<div class="alertbox">
							<a href="#" class="close">&times;</a>
							<div class="alertHead">提示</div>
							<div class="alertMain">
								确认是否增加此代理？
							</div>
							<div class="alertbtn">
								<input type="submit" class="btn btn-sure" value="确认" id="fileSubmit"/>
								<button class="btn btn-cancel" type="button">取消</button>
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
			
			
			//弹窗
			$('#sub-btn').click(function(){

				var company = $("input[name=company]").val();
				var phone = $('input[name=phone]').val();
				var qq_bumber = $('input[name=qq_bumber]').val();
				var address = $("input[name=address]").val();
				var production = $('input[name=production]').val();
				var website = $('input[name=website]').val();
				var description = $("textarea[name=description]").val();
				var logo = $('input[name=logo]').val();
				var company_banner = $('input[name=company_banner]').val();
				var index_banner_imgs = $("input[name=index_banner_imgs]").val();
				var index_banner = [];

	        	$('#drags .show_pic').each(function(){
	        		var scr=$(this).attr('src')
	        		index_banner.push(scr)
	        	})
				
				if(company=='' || phone=='' || qq_bumber=='' || address=='' || production=='' || website=='' || production=='' || website=='' || description=='' || logo=='' || company_banner=='' ||  index_banner=='' || index_banner_imgs ==''){
					$('.myalert_1').show()
					$('.alertMain_1').html('<p>请填写正确信息</p>');
				}else{
					$('.myalert').show()
				}

				
			})
			
			$('.btn-cancel,.close').click(function(){
				$('.myalert').hide()
			})
			
			var l_radios = $('.label-radio');
	
			$.each(l_radios, function () {
		        var l = $(this), input = $(this).children("input[type='radio']");
		        if (input.prop('checked')) {
		            l.removeClass('offradio').addClass('onradio');
		        } else {
		            l.removeClass('onradio').addClass('offradio');
		        }
		        input.click(function () {
		            if (l.attr('class').indexOf('offradio') > -1) {
		                var inputName = $(this).attr('name');
		                var allCheckbox = $('input[name="' + inputName + '"]');
		                $.each(allCheckbox, function () {
		                    $(this).parent('label').removeClass('onradio').addClass('offradio');
		                });
		                l.removeClass('offradio').addClass('onradio');
		            }
		        });
		    });
		    
		    
		    $('.choose_box').click(function(){
		    	$(this).siblings('.choose_input').click()
		    })

// 		    var sortable=Sortable.create(document.getElementById('drags'), 
// 			{
// 				animation: 150, //动画参数
// 				dataIdAttr: 'data-sort',
// 				onUpdate: function (evt){
// 					console.log(evt)
// 					console.log(this.toArray())
// 					var sortArr = this.toArray()
// 					var arrFile=[]
// 					for(var i = 0,size = sortArr.length; i < size; i++){
// //						arrFile[i]=ZXXFILE.fileFilter[parseInt(sortArr[i])]
// 						arrFile[i] = ZXXFILE.fileFilter.filter(function(item){
// 							return item.index == parseInt(sortArr[i])
// 						})[0]
// 					}
// 					ZXXFILE.fileFilter = arrFile;
// 					console.log(ZXXFILE.fileFilter)
// 				}
// 			});
			
			$('.prev').click(function(){
				$(this).parents('.step').hide().siblings('.step').show()
			})
			$('.next').click(function(){
				var account = $("input[name=account]").val();
				var agencyName = $('input[name=agencyName]').val();
				var minPrice = $('input[name=minPrice]').val();
				if(account=='' || agencyName=='' || minPrice==''){
					$('.myalert_1').show()
					$('.alertMain_1').html('<p>请填写正确信息</p>');
				}else{
					var $this=$(this)
					var OEM=$('input[name=OEM]:checked').val()
					if(OEM == "2"){
						$('.myalert').show()
					}else{
						$this.parents('.step').hide().siblings('.step').show()
					}
				}
			})

			// document.getElementById('fileSubmit').addEventListener("click",
			//  function(e) {
			//   	ZXXFILE.funUploadFile(e);
			//   	// $('#addAgencyForm').submit()
			//  }, false)
			
			// $('.pic_delete').click(function(){
			// 	var $this= $(this);
			// 	alert('kkk')
			// 	console.log($this.parents('li'))
			// })
			$("#drags").on("click",".pic_delete", function() {
			     var $this= $(this);
				$this.parents('li').remove()
				
			 });
		})
	</script>
	
	<script type="text/javascript">

		function onc(){
			// var files = document.getElementById("indexBanner").files;
			// 	for(var i=0; i< files.length; i++){
				

				$.ajaxFileUpload({
			        url:"{{url('operate/agent/uploads')}}",
			      
			        secureuri:false,
			        fileElementId:'indexBanner',//file标签的id
			        // dataType: 'json',//返回数据的类型
			        async:false,
			        success: function (data) {//把图片替换
			        	var fileName = $(data).contents().find('body').html();
			        	// ss = fileName.split("|");
			        	var html = '';
			        	var srcArr = [];
			        	$('#drags .show_pic').each(function(){
			        		var scr=$(this).attr('src')
			        		srcArr.push(scr)
			        	})
			        	srcArr.push(fileName)

			           	$.each(srcArr,function(i,v){
			           		html = html + '<li id="uploadList_'+ i +'" class="upload_append_list" data-sort="'+i+'"><div class="img_show_box">'+ 
								'<a href="javascript:" class="pic_delete" title="删除" data-index="'+ i +'"></a>' +
								'<img id="uploadImage_' + i + '" src="' + v + '" class="show_pic" />'+ 
								
							'</div></li>';
			           	})
			           	
			           	$("input[name=index_banner_imgs]").val(srcArr)
			           	$('#drags').html(html)
			        },
			        // error: function (data)//服务器响应失败处理函数
           //          {
           //              alert(data);
           //          }
			    });
			   
			// }	
		}

		var filechange=function(event){
			console.log(event)
		    var files = event.target.files, file;
		    var $this=$(event.target)
		    if (files && files.length > 0) {
		        // 获取目前上传的文件
		        file = files[0];
		        // 获取 window 的 URL 工具
		        var URL = window.URL || window.webkitURL;
		        // 通过 file 生成目标 url
		        var imgURL = URL.createObjectURL(file);
		        //用attr将img的src属性改成获得的url
		        $this.parents('.img_upload').find('.selected_pic').attr("src",imgURL);
		        $this.parents('.img_upload').find('.upload-text').text('重新上传')
		        // 使用下面这句可以在内存中释放对此 url 的伺服，跑了之后那个 URL 就无效了
		        // URL.revokeObjectURL(imgURL);
		        
		    }
		};
		

		var params = {
			fileInput: $("#indexBanner").get(0),
//			dragDrop: $("#fileDragArea").get(0),
			upButton: $("#fileSubmit").get(0),
			url: $("#addAgencyForm").attr("action"),
			filter: function(files) {
				var arrFiles = [];
				for (var i = 0, file; file = files[i]; i++) {
					if (file.type.indexOf("image") == 0) {
//						if (file.size >= 5512000) {
//							alert('您这张"'+ file.name +'"图片大小过大，应小于5500k');	
//						} else {
							arrFiles.push(file);	
//						}			
					} else {
						alert('文件"' + file.name + '"不是图片' + file.type + '。');	
					}
				}
				return arrFiles;
			},
			onSelect: function(files) {
				var html = '', i = 0;
//				$("#drags").html('<div class="upload_loading"></div>');
				var funAppendImage = function() {

					file = files[i];
					if (file) {
						console.log(file)
						var reader = new FileReader()
						reader.onload = function(e) {
							html = html + '<li id="uploadList_'+ i +'" class="upload_append_list" data-sort="'+i+'"><div class="img_show_box">'+ 
								'<a href="javascript:" class="pic_delete" title="删除" data-index="'+ i +'"></a>' +
								'<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="show_pic" />'+ 
								'<div class="pic_drag">拖动排序</div></div>' +
							'</div></li>';
//							html+=''
							
							i++;
							funAppendImage();
						}
						reader.readAsDataURL(file);
					} else {
						$("#drags").html(html);
						if (html) {
							//删除方法
							$(".pic_delete").click(function() {
								ZXXFILE.funDeleteFile(files[parseInt($(this).attr("data-index"))]);
								return false;	
							});
							
						}
					}
				};
				funAppendImage();		
			},
			onDelete: function(file) {
				$("#uploadList_" + file.index).remove();

			},
			onDragOver: function() {
				$(this).addClass("upload_drag_hover");
			},
			onDragLeave: function() {
				$(this).removeClass("upload_drag_hover");
			},
			onProgress: function(file, loaded, total) {
				var eleProgress = $("#uploadProgress_" + file.index), percent = (loaded / total * 100).toFixed(2) + '%';
				eleProgress.show().html(percent);
			},
			onSuccess: function(file, response) {
				
		
			},
			onFailure: function(file) {
				
			},
			onComplete: function() {
				
			}
		};
		// ZXXFILE = $.extend(ZXXFILE, params);
		// ZXXFILE.init();
	</script>
</html>
