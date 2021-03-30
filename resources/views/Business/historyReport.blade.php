<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>任务中心-历史任务</title>
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
        <div class="head task-head">历史任务</div>
        <form action="" method="get" class="form-inline checkform" role="form" id="f-history">
            <div class="form-group position">
                <label>
                    公众号：
                </label>
                {{--<select name="subShop" class="form-control">--}}
                {{--@if(isset($namelist) && !empty($namelist))--}}
                {{--@foreach($namelist as $k)--}}
                {{--@if(isset($Get['subShop']) && $Get['subShop']==$k)--}}
                {{--<option selected value="{{$k}}">{{$k}}</option>--}}
                {{--@else--}}
                {{--<option value="{{$k}}">{{$k}}</option>--}}
                {{--@endif--}}
                {{--@endforeach--}}
                {{--@endif--}}
                {{--</select>--}}
                <input type="text" id="inputv" onkeyup="checkFunction()" name="subShop" value="{{isset($Get['subShop'])?$Get['subShop']:""}}" class="form-control">
                <ul id="ul_hide">
                    @if(isset($namelist)&& count($namelist)>0)
                        @foreach($namelist as $k=>$v)
                            <li class="option_obj" style="display: none;">{{$v}}</li>
                        @endforeach
                    @endif
                </ul>
                <script>
                    $(".option_obj").click(function(){
                        var wxname = $(this).text();
                        $("#inputv").val(wxname);
                        $(".option_obj").hide();
                    })

                    function checkFunction(){
                        var inputv,filter,ul,li,a,i;
                        inputv = document.getElementById('inputv');
                        filter = inputv.value.toUpperCase();
                        ul =  document.getElementById('ul_hide');
                        li = ul.getElementsByTagName('li');
                        if(filter==''){
                            $(".option_obj").hide();
                            return false;
                        }
                        for(i=0;i<li.length;i++){
                            var tt = li[i].innerHTML.toUpperCase().indexOf(filter);
                            if(tt>=0){
                                li[i].style.display = "";
                            }else{
                                li[i].style.display = "none";
                            }
                        }
                    }
                </script>

            </div>
            <div class="form-group">
                <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" @if(isset($startDate))value="{{$startDate}}"@endif readonly /></label>

                <label class="datelabel">至 <input type="text" name="endDate" class="form-control date" id="datetimeEnd" @if(isset($endDate))value="{{$endDate}}"@endif readonly /></label>

            </div>
            <input type="hidden" name="excel" value="0">
            <input type="submit" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
            <input type="button" value="导出excel" class="excel"/>
        </form>

        <table class="table-bordered table-responsive checktable">
            <tr>
                <th>下单时间</th>
                <th>公众号</th>
                <th>成功关注</th>
                <th>取关量</th>
                <th>取关率</th>
            </tr>

            @if(isset($arr['data']) && !empty($arr['data']))
            @foreach($arr['data'] as $k=>$v)
                @if($v['all_fans']!=0)
                    <tr>
                        <td>{{$v['task_time']}}</td>
                        <td>{{$v['wx_name']}}</td>
                        <td>{{$v['all_fans']}}</td>
                        <td>{{$v['un_subscribe_nu']}}</td>
                        <td>{{$v['unfollowRate']}}</td>
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
            window.location.href='/buss/getHistoryReport/reportlist';
        })


    })
</script>
</html>
