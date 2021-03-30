<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>公众号列表-banner设置</title>
		@include('Operate.common.head')
		<script src="{{URL::asset('operate/js/Sortable.js')}}" type="text/javascript" charset="utf-8"></script>
		<script src="{{URL::asset('operate/js/zxxFile.js')}}" type="text/javascript" charset="utf-8"></script>
		<style type="text/css">
			.gh_img{
				display: block;
				width: 50px;
				height: 50px;
				margin: 0 auto;
			}
			.banner_form{
				width: 720px;
				margin: 0 auto;
				padding-bottom: 20px;
			}
			.choose_box{
				width: 220px;
				height: 160px;
				border-radius: 4px;
				background: #EBEBEB;
				position: relative;
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
				display: block;
				width: 40px;
				height: 40px;
				background: url(/operate/img/icon-add.png) no-repeat center;
				background-size: 100% 100%;
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
				background: url(/operate/img/icon_delete.png) no-repeat center;
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
				margin-left: 0;
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
				<div class="header">banner图设置</div>
				<form action="" method="post" role="form" class="banner_form">
					
					<p>提示：图片格式必须为png、jpg；建议图片尺寸为1920px*900px。</p>
					<div class="img_upload clearfix">
						<input type="file" name="index_banner" multiple="multiple" value="" accept="image/png,image/jpeg" style="display: none;" class="choose_input" id="indexBanner" />
						<div class="choose_box" style="float: left;margin: 0 20px 20px 0;">
							<img class="selected_pic" />
							<div class="upload_box">
								<span class="add_icon"></span>
								<div class="upload-text">上传图片</div>
							</div>
						</div>
						<ul id="drags">
							
						</ul>
					</div>
					
					
					<input type="button" value="确定" class="submit" id="fileSubmit"/>
					<input type="button" value="返回修改" class="prev" onclick="history.go(-1)"/>
				</form>
				
				
				
			</div>
		</div>	
	</body>
	<script type="text/javascript">
		$(function(){
			
			//左边菜单栏缩略
			$('.menu-title').click(function(){
				var $this=$(this);
				var $menu=$this.parent('.menu-header');
				var $list=$this.siblings('.menu-list');
				if($list.is(':hidden')){
					$menu.addClass('open');
					$list.show();
				}else{
					$menu.removeClass('open');
					$list.hide();
				}
			})
			
			
			$('.choose_box').click(function(){
		    	$(this).siblings('.choose_input').click()
		    })
			
			
			var sortable=Sortable.create(document.getElementById('drags'), 
			{
				animation: 150, //动画参数
				dataIdAttr: 'data-sort',
				onUpdate: function (evt){
					console.log(evt)
					console.log(this.toArray())
					var sortArr = this.toArray()
					var arrFile=[]
					for(var i = 0,size = sortArr.length; i < size; i++){
//						arrFile[i]=ZXXFILE.fileFilter[parseInt(sortArr[i])]
						arrFile[i] = ZXXFILE.fileFilter.find(function(item){
							return item.index == parseInt(sortArr[i])
						})
					}
					ZXXFILE.fileFilter = arrFile;
					console.log(ZXXFILE.fileFilter)
				}
			});
			
		})
	</script>
	<script type="text/javascript">
		var params = {
			fileInput: $("#indexBanner").get(0),
//			dragDrop: $("#fileDragArea").get(0),
			upButton: $("#fileSubmit").get(0),
			url: $("#addAgencyForm").attr("action"),
			filter: function(files) {
				var arrFiles = [];
				for (var i = 0, file; file = files[i]; i++) {
					if (file.type.indexOf("image") == 0) {
							arrFiles.push(file);			
					} else {
						alert('文件"' + file.name + '"不是图片' + file.type + '。');	
					}
				}
				return arrFiles;
			},
			onSelect: function(files) {
				var html = '', i = 0;
				var funAppendImage = function() {
					file = files[i];
					if (file) {
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
							console.log(html)
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
		ZXXFILE = $.extend(ZXXFILE, params);
		ZXXFILE.init();
	</script>
</html>
