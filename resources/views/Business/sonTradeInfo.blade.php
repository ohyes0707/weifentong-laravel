<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商家中心-子商户统计</title>
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
        <div class="head task-head">子商户统计中心</div>
        <form action="" method="get" class="form-inline checkform" role="form" id="f-history">
            <div class="form-group">
                <label>
                    子商户：
                </label>
                <select name="subShop" class="form-control">

                    @if(isset($namelist) && !empty($namelist))
                        @foreach($namelist as $k)
                            @if(isset($Get['subShop']) && $Get['subShop']==$k['buss_id'])
                                <option selected value="{{$k['buss_id']}}">{{$k['nick_name']}}</option>
                            @else
                                <option value="{{$k['buss_id']}}">{{$k['nick_name']}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label class="datelabel">选择时间：<input type="text" name="start_date" class="form-control date" id="datetimeStart"@if(isset($start_date))value="{{$start_date}}"@endif  readonly /></label>

                <label class="datelabel">至 <input type="text" name="end_date" class="form-control date" id="datetimeEnd" @if(isset($end_date))value="{{$end_date}}"@endif  readonly /></label>

            </div>
            <input type="hidden" name="excel" value="0">
            <input type="submit" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
            <input type="button" value="导出excel" class="excel"/>
        </form>

        <table class="table-bordered table-responsive checktable">
            <tr>
                <th>子商户</th>
                <th>连接数</th>
                <th>带粉数</th>
                <th>取关注数</th>
                <th>取关率</th>
            </tr>

            @if(isset($arr['data']) && !empty($arr['data']))
                @foreach($arr['data'] as $k=>$v)
                    <tr>
                        <td>{{$v['nick_name']}}</td>
                        <td>{{$v['complet_repeat']}}</td>
                        <td>{{$v['all_fans']}}</td>
                        <td>{{$v['un_subscribe']}}</td>
                        <td>{{$v['unfollowRate']}}</td>
                    </tr>
                @endforeach
            @endif

        </table>
        @if(isset($paginator) && $parameter)
            {{$paginator->appends($parameter)->render()}}
        @endif

    </div>
</div>

</body>
<script type="text/javascript">
    $(function(){
        $(".excel").click(function(){
            $("input[name=excel]").val(1);
            var excel = $("input[name=excel]").val();
            $("#f-history").submit();
            $("input[name=excel]").val(0);
        })


        $(".reset").click(function(){
            window.location.href='/buss/getSonTradeReport/reportlist';
        })


    })
</script>
</html>
