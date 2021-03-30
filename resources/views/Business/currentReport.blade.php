<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>任务中心-当前任务</title>
    @include('Business.common.head')
</head>
<body>
<!--导航栏-->
@include('Business.common.top')

<div class="main clearfix">
    <!--左侧-->
    @include('Business.common.left')
    <!--右侧-->
    <div class="main-right">
        <div class="head task-head">当前任务</div>

        <table class="table-bordered table-responsive checktable">
            <tr>
                <th>公众号</th>
                <th>时间</th>
                <th>订单剩余涨粉</th>
                <th>当日剩余涨粉量 </th>
                <th>已涨粉</th>
                <th>单价</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            @if(isset($arr) && !empty($arr) && isset($arr['data']))
                @foreach($arr['data'] as $k=>$v)
                    @if(isset($v['wx_name']))
                    <tr>
                        <td>{{$v['wx_name']}}</td>
                        <td>{{$v['task_time']}}</td>
                        <td>{{$v['plan_fans']}}</td>
                        <td>{{$v['every_fans']}}</td>
                        <td>{{$v['all_fans']}}</td>
                        <td>{{$v['o_per_price']}}</td>
                        @if($v['task_status']==1)
                            <td>开启</td>
                        @elseif($v['task_status']==2)
                            <td>暂停</td>
                        @elseif($v['task_status']==3)
                            <td>关闭</td>
                        @endif
                        <td><button value="{{$v['order_id']}}" class="refuse-btn orderid">拒绝任务</button></td>
                    </tr>
                    @endif
                @endforeach
            @endif
        </table>

        @if(isset($paginator) && $parameter)
            {{$paginator->appends($parameter)->render()}}
        @endif

    </div>
</div>
<input type="hidden" id="orderid" value="" >
<div class="myalert" style="display: none;">
    <div class="mask"></div>
    <div class="alertbox">
        <a href="#" class="close">&times;</a>
        <div class="alertHead">提示</div>
        <div class="alertMain">
            请确认是否拒绝该任务？
        </div>
        <div class="alertbtn">
            <button id="right" class="blue-btn btn-sure">确定</button>
            <button class="goback btn-cancel">取消</button>
        </div>
    </div>
</div>

</body>
<script type="text/javascript">
    $(function(){
        //弹框
        $('.refuse-btn').click(function(){
            var order_id = $(this).val();
            $("#orderid").val(order_id);
            $('.myalert').show();
        })
        $('.btn-sure').click(function(){
            //点击确认
            $('.myalert').hide()
        })
        $('.close,.btn-cancel').click(function(){
            //点击取消
            $('.myalert').hide()
        })
    })

    $('#right').click(function(){

        var orderid = $('#orderid').val();  //这里的值不会取

        $.getJSON("{{ URL::asset('index.php/buss/refuseReport/reportlist') }}"+"?orderid="+orderid, function (res) {

            if(res.data>0)
            {
                window.location.href = '/buss/getCurrentReport/reportlist'

            }else {


            }


        })

    })

</script>
</html>
