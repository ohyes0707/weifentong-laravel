<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>分析报表</title>
    <script>
        {{--var changePwd_url = "{{ URL::asset('operate/user/changeover') }}"--}}
//        这里是加js
    </script>
    @include('Operate.common.head')
</head>
<body>
@include('Operate.common.top')

<div class="main clearfix">
    <!--左侧-->
    @include('Operate.common.left')

            <!--右侧-->
    <div class="main-right">

        <form action="{{URL::asset('index.php/operate/analyzeplatform')}}" method="get" class="form-inline" role="form" id="f-report">
            <div class="r_form clearfix">
                <div class="f_radio">
                    <a href="javascript: void(0)" class="on_radio">平台</a>
                    <a href="{{URL::asset('index.php/operate/analyzeorder')}}">订单</a>
                    <a href="{{URL::asset('index.php/operate/analyzechannel')}}">渠道</a>
                </div>
            </div>

            <div class="form-group">
                <label>
                    用户选择：
                </label>
                <select name="user" class="form-control">
                    @if(isset($Get['user']) && $Get['user']==0)
                        <option selected value="0">全部</option>
                        <option value="1">新用户</option>
                        <option value="2">老用户</option>
                    @elseif(isset($Get['user']) && $Get['user']==1)
                        <option value="0">全部</option>
                        <option selected value="1">新用户</option>
                        <option value="2">老用户</option>
                    @elseif(isset($Get['user']) && $Get['user']==2)
                        <option value="0">全部</option>
                        <option value="1">新用户</option>
                        <option selected value="2">老用户</option>
                    @else
                        <option selected value="0">全部</option>
                        <option value="1">新用户</option>
                        <option value="2">老用户</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{isset($Get['startDate'])?$Get['startDate']:""}}"  readonly /></label>

                <label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{isset($Get['endDate'])?$Get['endDate']:""}}"  readonly /></label>


            </div>
            <input type="hidden" name="excel" value="0">
            <input type="button" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
            <input type="button" value="导出excel" class="excel"/>
        </form>
        <table class="table-bordered table-responsive table-striped detail colspan-6" id="reportTable">
            <tr>
                <th>日期</th>
                <th>已涨粉量</th>
                <th>取关量</th>
                <th>取关率</th>
                <th>操作</th>
            </tr>
            @if(isset($reportlist) && count($reportlist)>0)
            @foreach($reportlist as $v)
                <tr>
                    <td>{{ isset($v['date_time'])?$v['date_time']:0}}</td>
                    <td>{{ isset($v['all_fans'])?$v['all_fans']:0}}</td>
                    <td>{{isset($v['un_subscribe'])?$v['un_subscribe']:0}}</td>
                    <td>{{$v['un_attention']}}</td>
                    {{--getworkorderlist?action=upda&stat=1&new=3&id={{ $data['now']['id'] }}--}}
                    @if($v['date_time'] == '总计')
                        <td><a href="{{URL::asset('index.php/operate/analyzepicture?action=1&date='.$v['date_time'].'&allfans='.$v['all_fans'].'&startDate='.$Get['startDate'].'&endDate='.$Get['endDate'])}}">详情</a></td>
                        @else
                        <td><a href="{{URL::asset('index.php/operate/analyzepicture?action=1&date='.$v['date_time'].'&allfans='.$v['all_fans'].'&startDate='.$v['date_time'].'&endDate='.$v['date_time'])}}">详情</a></td>
                    @endif
                </tr>
            @endforeach
                @endif
        </table>
        @if(isset($reportlist) && isset($paginator))
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
//		        startDate:new Date()
        }).on("click",function(){
            $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
        });
        $("#datetimeEnd").datetimepicker({
            format: 'yyyy-mm-dd',
            minView:'month',
            language: 'zh-CN',
            autoclose:true,
//		        startDate:new Date()
        }).on("click",function(){
            $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart").val())
        });


        //左边列表栏缩略
        $('.sub_file').click(function(){
            var $this=$(this);
            var $list=$this.find('.sub_list')
            if($list.is(':hidden')){
                $list.show();
                $this.addClass('on_file').removeClass('off_file');
                $this.find('.sub_close').hide().siblings('.sub_open').show()
            }else{
                $list.hide();
                $this.addClass('off_file').removeClass('on_file');
                $this.find('.sub_close').show().siblings('.sub_open').hide()
            }
        })

        $(".reset").click(function(){
            window.location.href='/operate/analyzeplatform';
        })

        $(".find").click(function(){
            var status = $(".on_radio").attr('value');
            $("#status").val(status);
//            $("#f-report").attr('action','platCount');
            var startDate = new Date($('#datetimeStart').val()).getTime()
            var endDate = new Date($('#datetimeEnd').val()).getTime()
            var delta=parseInt((endDate-startDate)/1000/60/60/24);
            if(delta>29){
                alert('数据太多啦，请导出Excel查看')
            }else{
                $("#f-report").submit();
            }
        })

        $(".excel").click(function(){
            $("input[name=excel]").val(1);
            var excel = $("input[name=excel]").val();
            $("#f-report").submit();
            $("input[name=excel]").val(0);
        })

    })
</script>
</html>
