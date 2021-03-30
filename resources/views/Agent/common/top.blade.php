<nav class="navbar" role="navigation" id="nav1">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="{{ URL::asset('Agent/img/logo.png') }}"/></a>
    </div>
    <div class="navbar-right">
        <div class="dropdown" id="navDropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{$userid = session()->get('agent_username')}}
                <b class="icon-caret">
                    <img src="{{ URL::asset('Agent/img/icon10.png') }}" class="top-caret"/>
                    <img src="{{ URL::asset('Agent/img/icon18.png') }}" class="bottom-caret" style="display: none;"/>
                </b>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="info">
                    <a href="{{ url('agent/user/info') }}">个人信息</a>
                </li>
                <li class="change">
                    <a href="{{ url('agent/user/changePwd') }}">修改密码</a>
                </li>
                <li class="exit"><a href="{{ url('agent/user/loginOut') }}">退出</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav>


