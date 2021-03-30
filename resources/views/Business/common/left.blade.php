
<div class="main-left">
    <div class="left-menu">
        <ul class="sub_menu">
            <li class="menu-header open">
                <div class="menu-title">
                    <span class="icon-folder"></span>
                    带粉中心
                    <span class="icon-arrow"></span>
                </div>
                <ul class="menu-list">
                    <li class="left_bar fansEarn" data="fansEarn">
                        <a href="{{ URL::asset('index.php/business/Fans/fansEarn') }}">带粉收益</a>
                    </li>
                    <li class="left_bar fansCount" data="fansCount">
                        <a href="{{ URL::asset('index.php/business/Fans/fansCount') }}">带粉统计</a>
                    </li>
                    <li class="left_bar getParentBuss" data="getParentBuss">
                        <a href="{{ URL::asset('index.php/business/Settlement/getParentBuss') }}">结算管理</a>
                    </li>
                </ul>
            </li>
            
            <li class="menu-header open">
                <div class="menu-title">
                    <span class="icon-folder"></span>
                    任务中心
                    <span class="icon-arrow"></span>
                </div>
                <ul class="menu-list">
                    <li class="left_bar CurrentReport" data="CurrentReport">
                        <a href="{{ URL::asset('index.php/buss/getCurrentReport/reportlist') }}">当前任务</a>
                    </li>
                    <li class="left_bar HistoryReport" data="HistoryReport">
                        <a href="{{ URL::asset('index.php/buss/getHistoryReport/reportlist') }}">历史任务</a>
                    </li>
                </ul>
            </li>
            @if(session()->get('parent_id')==0)
            <li class="menu-header open">
                <div class="menu-title">
                    <span class="icon-folder"></span>
                    商家中心
                    <span class="icon-arrow"></span>
                </div>
                <ul class="menu-list">
                    <li class="left_bar getChildBusiness" data="getChildBusiness">
                        <a href="{{ URL::asset('index.php/business/user/getChildBusiness') }}">子商户</a>
                    </li>
                    <li class="left_bar childManage" data="childManage">
                        <a href="{{ URL::asset('index.php/business/Settlement/childManage') }}">子商户结算管理</a>
                    </li>
                    <li class="left_bar SonTradeReport" data="SonTradeReport">
                        <a href="{{ URL::asset('index.php/buss/getSonTradeReport/reportlist') }}">子商户统计</a>
                    </li>
                </ul>
            </li>
            @endif
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
