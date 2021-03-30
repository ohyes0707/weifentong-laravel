<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>美业管理-品牌管理-Portal设置</title>
		@include('Operate.common.head')
		<style type="text/css">
			.gh_img{
				display: block;
				width: 50px;
				height: 50px;
				margin: 0 auto;
			}
			.banner_form{
				width: 500px;
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
			.choose_box img{
				width: 100%;
				height: 100%;
				border-radius: 4px;
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
		
			.submit{
				margin-left: 0;
				margin-right: 10px;
			}
			.prev{
				
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
				<div class="header">Portal设置</div>
				<form action="" method="post" role="form" enctype="multipart/form-data" class="banner_form">
					{{csrf_field()}}
					<input type="hidden" name="brand_id" value="{{$brand_id}}">
					<p>提示：图片格式必须为png；图片尺寸为750*886、640*756。</p>
					<div class="img_upload clearfix">
						<input type="file" name="portal" accept="image/png" style="display: none;" class="choose_input" onchange="filechange(event)"/>
						<div class="choose_box" style="float: left;margin: 0 20px 20px 0;">
							<img class="selected_pic" />
							<div class="upload_box">
								<span class="add_icon"></span>
								<div class="upload-text">上传图片</div>
							</div>
						</div>
					</div>
					
					
					<input type="submit" value="确定" class="submit" id="fileSubmit"/>
					<input type="button" value="返回" class="goback" onclick="history.go(-1)"/>
				</form>
				
				
				
			</div>
		</div>	
	</body>
	<script type="text/javascript">
		$(function(){
			
			$('.choose_box').click(function(){
		    	$(this).siblings('.choose_input').click()
		    })
			
			
			
		})
	</script>
	<script type="text/javascript">
		var filechange=function(event){
			console.log(event)
		    var files = event.target.files, file;
		    var $this=$(event.target);

		    if (files && files.length > 0) {
		        // 获取目前上传的文件
		        file = files[0];
		        var fileName = file.name;

				var fileType = fileName.slice(fileName.lastIndexOf(".")+1).toLowerCase()

				if(fileType != 'png'){
		            alert('图片格式错误');
		            return false;
				}
                var reader = new FileReader();
                reader.onload = function (e) {
                    var data = e.target.result;
                    //加载图片获取图片真实宽度和高度
                    var image = new Image();
                    image.onload = function () {
                        var width = image.width;
                        var height = image.height;
                        if((width==750 && height==886) || (width==640 && height==756)){

                            // 获取 window 的 URL 工具
                            var URL = window.URL || window.webkitURL;
                            // 通过 file 生成目标 url
                            var imgURL = URL.createObjectURL(file);
                            //用attr将img的src属性改成获得的url
                            $this.parents('.img_upload').find('.selected_pic').attr("src",imgURL);
                            $this.parents('.img_upload').find('.upload-text').text('重新上传')
                            // 使用下面这句可以在内存中释放对此 url 的伺服，跑了之后那个 URL 就无效了
                            // URL.revokeObjectURL(imgURL);
                        }else{
//                            $('.submit').attr('type','button');
                            alert('图片应为750*886或640*756');
                        }
                    };
                    image.src = data;

                };
                reader.readAsDataURL(file);
		        
		    }
            $("#file").on('change', function () {
                if (this.files) {
                    //读取图片数据
                    var f = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var data = e.target.result;
                        //加载图片获取图片真实宽度和高度
                        var image = new Image();
                        image.onload = function () {
                            var width = image.width;
                            var height = image.height;
                            if(width==580 && height==840){
                                $('.submit').attr('type','submit');
                            }else{
                                $('.submit').attr('type','button');
                                alert('图片应为580*840');
                            }
                        };
                        image.src = data;
                    };
                    reader.readAsDataURL(f);
                }
            })
		};
	</script>
</html>
