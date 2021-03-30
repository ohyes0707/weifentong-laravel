<nav class="navbar" role="navigation" id="nav1">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="{{ URL::asset('Business/img/logo.png') }}"/></a>
    </div>
    <div class="navbar-right">
        <div class="dropdown" id="navDropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{$userid = session()->get('username')}}
                <b class="icon-caret">
                	<img src="{{ URL::asset('Business/img/icon10.png') }}" class="top-caret"/>
                	<img src="{{ URL::asset('Business/img/icon18.png') }}" class="bottom-caret" style="display: none;"/>
                </b>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="exit"><a href="{{action('Business\UserController@loginOut')}}">退出</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav>

