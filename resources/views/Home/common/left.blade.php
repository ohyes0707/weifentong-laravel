<div class="main-left">
				<div class="left-menu">
					<a href="javascript: menuToggle();" class="menu-header">
						<span class="icon-folder">
							<img src="{{ URL::asset('home/img/icon.png') }}" class="close-folder"/>
							<img src="{{ URL::asset('home/img/icon2.png') }}" class="open-folder" style="display: none;"/>
						</span>
						用户系统
						<span class="icon-arrow">
							<img src="{{ URL::asset('home/img/icon8.png') }}" class="bottom-arrow"/>
							<img src="{{ URL::asset('home/img/icon7.png') }}" class="top-arrow" style="display: none;"/>
						</span>
					</a>
					<ul class="menu-list" style="display: none;">
						<li>
							<a href="{{ URL::asset('index.php/home/report/reportlist') }}">报备详情</a>
						</li>
						<li>
							<a href="{{ URL::asset('index.php/home/workorder/getworkorderlist') }}">工单详情</a>
						</li>
						<li>
							<a href="{{ URL::asset('index.php/home/sell/list') }}">销售统计</a>
                            {{--<a href="javascript:alert('该功能暂未开放');">销售统计</a>--}}
						</li>
					</ul>
				</div>
			</div>
<script type="text/javascript">
    var str = window.location.pathname.toLowerCase();
    $(".left-menu").find(".menu-list").find("li a").each(function(i,index){
        var res =$(this).attr("href").toLowerCase();
        if(res.indexOf(str)!=-1){
            $(this).parent().attr('class','active');
            return false;
        }
    });
    $(".left-menu").find(".menu-header")[0].click();
</script>
