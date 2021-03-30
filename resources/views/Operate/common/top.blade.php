<nav class="navbar" role="navigation" id="nav1">
		    <div class="container-fluid">
		    <div class="navbar-header">
		        <a class="navbar-brand" href="#"><img src="{{ URL::asset('operate/img/logo.png') }}"/></a>
		    </div>
		    <div class="navbar-right">
		        <div class="dropdown" id="navDropdown">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{$userid = session()->get('operate_username')}}
		                <b class="icon-caret">
		                	<img src="{{ URL::asset('operate/img/icon10.png') }}" class="top-caret"/>
		                	<img src="{{ URL::asset('operate/img/icon18.png') }}" class="bottom-caret" style="display: none;"/>
		                </b>
		            </a>
		            <ul class="dropdown-menu dropdown-menu-right">
						{{--<li class="info">--}}
							{{--<a href="{{URL::route('operate/info')}}">个人信息</a>--}}
						{{--</li>--}}
						<li style="padding-left: 64px;" class="change">
							<a href="{{URL::route('operate/changepwd')}}">修改密码</a>
						</li>
		                <li class="exit"><a href="{{action('Operate\UserController@loginOut')}}">退出</a></li>
		            </ul>
		        </div>
		    </div>
		    </div>
	      <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}"/>
		</nav>
<script type="text/javascript">
	var url = $('input[name=url]').val();
	var urlArray = url.split("/");
	var sessionKey =  urlArray.pop()

	$.getJSON('{{URL::asset('index.php/operate/getSession') }}', {
				"sessionKey": sessionKey
			},
			function (data) {
				if (data==0){
					var width=$(document).width()-280;
					$('body').append('<div style="position: fixed;top:50px;right: 0;z-index: 100;width: '+width+'px;height: 100%;background: rgba(0,0,0,0);"></div>')
				}
			});
</script>