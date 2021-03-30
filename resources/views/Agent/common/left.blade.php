<div class="main-left">
    <div class="left-menu">
        <a href="javascript: menuToggle();" class="menu-header">
            <span class="icon-folder">
                <img src="{{ URL::asset('Business/img/icon.png') }}" class="close-folder"/>
                <img src="{{ URL::asset('Business/img/icon2.png') }}" class="open-folder" style="display: none;"/>
            </span>
            代理系统
            <span class="icon-arrow">
                <img src="{{ URL::asset('Business/img/icon8.png') }}" class="bottom-arrow"/>
                <img src="{{ URL::asset('Business/img/icon7.png') }}" class="top-arrow" style="display: none;"/>
            </span>
        </a>
        <ul class="menu-list" style="display: block;">
            <li class="left_bar reportlist" data="reportlist">
                <a href="{{ URL::asset('index.php/agent/report/reportlist') }}">报备详情</a>
            </li>
            <li class="left_bar getworkorderlist" data="getworkorderlist">
                <a href="{{URL::asset('index.php/agent/workorder/getworkorderlist')}}">工单详情</a>
            </li>
            <li class="left_bar">
                <a href="sales.html">销售统计</a>
            </li>
            <li class="left_bar agentList" data="agentList">
                <a href="{{URL::asset('index.php/agent/agentList')}}">代理管理</a>
            </li>
        </ul>
    </div>
</div>

<script src="{{ URL::asset('js/jquery.cookie.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
        $(function(){
            //日期选择
            $("#datetimeStart").datetimepicker({
                format: 'yyyy-mm-dd',
                minView:'month',
                language: 'zh-CN',
                autoclose:true,
            }).on("click",function(){
                $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
            });
            $("#datetimeEnd").datetimepicker({
                format: 'yyyy-mm-dd',
                minView:'month',
                language: 'zh-CN',
                autoclose:true,
            }).on("click",function(){
                $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
            });

            //导航栏下拉菜单
            $('#navDropdown').on('show.bs.dropdown',function(){
                $('.top-caret').hide()
                $('.bottom-caret').show()
            })

            $('#navDropdown').on('hide.bs.dropdown',function(){
                $('.top-caret').show()
                $('.bottom-caret').hide()
            })


            $(document).ready(function(){
                $(".left_bar").click(function(){
                    var on_here = $(this).attr('data');
                    $.cookie("on_here",on_here,{ path: '/' });
                    //var on_here = $.cookie("on_here");
                })
                var on_here = $.cookie("on_here");
                if(on_here){
                    $("."+on_here).addClass('active');
                    $("."+on_here).parent().prev().click();
                }else{
                    $(".report").addClass('active');
                    $(".report").parent().prev().click();
                }
            })
            
        })
    </script>
