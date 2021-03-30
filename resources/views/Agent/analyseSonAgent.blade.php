<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>代理管理-子代理列表-报表</title>
    @include('Agent.common.head')

    <style>
        .icon-folder img{
            display: inline-block;
        }
        .icon-arrow {
            top: 50%;
            margin-top: -4px;
        }
    </style>
</head>
<body>
@include('Agent.common.top')

<div class="main clearfix">
    <!--左侧 缺少必要的参数,记得改-->
    @include('Agent.common.left')

    <!--右侧-->
    <div class="main-right">
        <div class="head">子代理名称</div>


        <form action="" method="post" class="form-inline" role="form" id="f-report">
            {!! csrf_field() !!}
            <div class="form-group">
                <label class="datelabel">选择时间：<input type="text" name="startDate" value="{{isset($start_date)?$start_date:''}}" class="form-control date" id="datetimeStart" readonly /></label>

                <label class="datelabel">至&nbsp;<input type="text" name="endDate" value="{{isset($end_date)?$end_date:''}}" class="form-control date" id="datetimeEnd" readonly /></label>

            </div>
            <input type="hidden" name="id" value="{{$id}}">
            <input type="hidden" name="isagentmoudle" value="{{isset($isagentmoudle)?$isagentmoudle:''}}"/>
            <input type="hidden" name="excel" value="0">
            <input type="submit" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
            <input type="button" value="导出excel" class="excel"/>
        </form>
        <table class="table-bordered table-responsive detail">
            <tr>
                <th>时间</th>
                <th>成功关注</th>
                <th>取关数</th>
                <th>取关率</th>
                <th>销售额</th>
            </tr>

            @if(isset($arr) && count($arr)>0)
            @foreach($arr as $key=>$value)
            <tr>
                <td>{{$value['date_time']}}</td>
                <td>{{$value['total_fans']}}</td>
                <td>{{$value['un_subscribe']}}</td>
                <td>{{$value['percent']}}</td>
                <td>{{$value['money']}}</td>
            </tr>
            @endforeach
            @endif

        </table>

        @if(isset($arr))
            {{$paginator->appends($parameter)->render()}}
        @endif

    </div>
</div>


</body>
<script type="text/javascript">
    $(function(){
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

        $(".reset").click(function(){
            var id = $("input[name=id]").val();
            var isagentmoudle =  $("input[name=isagentmoudle]").val();
                window.location.href='/index.php/agent/report/analyseSonAgent?id='+id;
        })


        $(".excel").click(function(){
            $("input[name=excel]").val(1);
            var excel = $("input[name=excel]").val();
            $("#f-report").submit();
            $("input[name=excel]").val(0);
        })


        $('.menu-title').click(function(){
            var $this=$(this);
            var $menu=$this.parent('.menu-header');
            var $list=$this.siblings('.menu-list');
            if($list.is(':hidden')){
                $menu.addClass('open');
                $list.show();
            }else{
                $menu.removeClass('open');
                $list.hide();
            }
        })

    })
</script>
</html>
