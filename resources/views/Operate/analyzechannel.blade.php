<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>分析报表</title>
    <script>
        //        {{--var changePwd_url = "{{ URL::asset('operate/user/changeover') }}"--}}
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
        <form action="{{URL::asset('index.php/operate/analyzechannel')}}" method="get" class="form-inline" role="form"
              id="f-report">
            <div class="r_form clearfix">
                <div class="f_radio">
                    <a href="{{URL::asset('index.php/operate/analyzeplatform')}}">平台</a>
                    <a href="{{URL::asset('index.php/operate/analyzeorder')}}">订单</a>
                    <a href="javascript: void(0)" class="on_radio">渠道</a>
                </div>
            </div>

            <input type="hidden" name="cid" value="{{isset($cid)?isset($cid):''}}"/>

            <div class="form-group position">
                <label>
                    渠道：
                </label>
                <input type="text" id="inputv" onkeyup="checkFunction()" name="channel" value="{{isset($Get['channel'])?$Get['channel']:""}}" class="form-control">
                @if(isset($arr['data']['bname']))
                    <ul id="ul_hide">
                        @foreach($arr['data']['bname'] as $k=>$v)
                            <li class="option_obj" style="display: none;">{{$v['bname']}}</li>
                        @endforeach
                    </ul>
                   @elseif(isset($data['data']['bname']))
                    <ul id="ul_hide">
                        @foreach($data['data']['bname'] as $k=>$v)
                            <li class="option_obj" style="display: none;">{{$v['bname']}}</li>
                        @endforeach
                    </ul>
                @endif

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
                <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date"
                                                     id="datetimeStart"
                                                     value="{{isset($Get['startDate'])?$Get['startDate']:""}}"
                                                     readonly/></label>

                <label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date"
                                                       id="datetimeEnd"
                                                       value="{{isset($Get['endDate'])?$Get['endDate']:""}}" readonly/></label>

            </div>
            <input type="hidden" name="excel" value="0">
            <input type="button" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
            <input type="button" value="导出excel" class="excel"/>
        </form>

        <!--全部渠道-->
        <table style="display:{{isset($show)&&$show=='all'? '':'none'}}"
               class="table-bordered table-responsive table-striped detail init-table colspan-6">
            <tr>
                <th>渠道</th>
                <th>已涨粉量</th>
                <th>取关量</th>
                <th>取关率</th>
                <th>操作</th>
            </tr>
            @if(isset($arr['data']['data']))
                @foreach($arr['data']['data'] as $key => $value)
                    <tr class="f_channel off_channel" channelId="{{$value['parent_id']}}">
                        <td>{{$value['bussname']}}</td>
                        <td>{{$value['all_fans']}}</td>
                        <td>{{$value['un_subscribe']}}</td>
                        <td>{{$value['percentage']}}</td>
                        <td><a href="{{URL::asset('index.php/operate/analyzepicture?startDate='.$startdate.'&endDate='.$enddate.'&action=3&ob=all&cid='.$value['bussname'].'&allfans='.$value['all_fans'])}}">查看详情</a>&nbsp;&nbsp;&nbsp;&nbsp;<label value="{{$value['bussname']}}" class="checkson" style="color: #428BCA" >查看子渠道</label></td>

                        </td>
                    </tr>
                    @if( isset($value['timedata']) && count($value['timedata'])>0)
                    @foreach($value['timedata'] as $k=>$v)
                        @if($v['buss_id']==$value['parent_id'])
                            <tr class="sub_channel" fatherId="{{$value['parent_id']}}">
                                <td>{{$v['date_time']}}</td>
                                <td>{{$v['all_fans']}}</td>
                                <td>{{$v['un_subscribe']}}</td>
                                <td>{{$v['percentage']}}</td>
                                <td></td>
                            </tr>
                        @endif

                    @endforeach
                    @endif
                @endforeach
            @endif

        </table>

        <!--单个渠道-->
        <table style="display:{{isset($show)&&$show=='sole'? '':'none'}}"
               class="table-bordered table-responsive table-striped detail init-table colspan-6">
            <tr>
                <th>渠道</th>
                <th>已涨粉量</th>
                <th>取关量</th>
                <th>取关率</th>
                <th>操作</th>
            </tr>

            @if(isset($data['data']['alldata']) && count($data['data']['alldata'])>0)
                {{--@foreach($data['data']['alldata'] as $key=>$value)--}}
                <tr class="f_channel off_channel" channelId="1">
                    <td>{{$data['data']['alldata'][0]['bussname']}}</td>
                    <td>{{$data['data']['alldata'][0]['all_fans']}}</td>
                    <td>{{$data['data']['alldata'][0]['un_subscribe']}}</td>
                    <td>{{$data['data']['alldata'][0]['percentage']}}</td>
                    <td><a href="{{URL::asset('index.php/operate/analyzepicture?startDate='.$startdate.'&endDate='.$enddate.'&action=3&ob=all&cid='.$data['data']['alldata'][0]['bussname'].'&allfans='.$data['data']['alldata'][0]['all_fans'])}}">查看详情</a></td>
                @foreach($data['data']['alldata']['timedata'] as $key=>$v)
                    <tr class="sub_channel" fatherId="1">
                        <td>{{$v['date_time']}}</td>
                        <td>{{$v['all_fans']}}</td>
                        <td>{{$v['un_subscribe']}}</td>
                        <td>{{$v['percentage']}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    @if($data['data']['falldata'][0]['all_fans']!="" && $data['data']['falldata'][0]['un_subscribe']!="")
                    <tr class="f_channel off_channel" channelId="father">
                        <td>{{$data['data']['falldata'][0]['bussname']}}</td>
                        <td>{{$data['data']['falldata'][0]['all_fans']}}</td>
                        <td>{{$data['data']['falldata'][0]['un_subscribe']}}</td>
                        <td>{{$data['data']['falldata'][0]['percentage']}}</td>
                        <td><a href="{{URL::asset('index.php/operate/analyzepicture?startDate='.$startdate.'&endDate='.$enddate.'&action=3&ob=father&cid='.$data['data']['falldata'][0]['bussname'].'&allfans='.$data['data']['falldata'][0]['all_fans'])}}">查看详情</a></td>
                    @foreach($data['data']['falldata']['timedata'] as $key=>$v)
                        <tr class="sub_channel " fatherId="father">
                            <td>{{$v['date_time']}}</td>
                            <td>{{$v['all_fans']}}</td>
                            <td>{{$v['un_subscribe']}}</td>
                            <td>{{$v['percentage']}}</td>
                            <td></td>
                        </tr>
                        @endforeach
                @endif
                @if(count($data['data']['sondata'])>0)
                        @foreach($data['data']['sondata'] as $key=>$value)
                                <tr class="f_channel off_channel" channelId="{{$value['buss_id']}}">
                                    <td>{{$value['bussname']}}</td>
                                    <td>{{$value['all_fans']}}</td>
                                    <td>{{$value['un_subscribe']}}</td>
                                    <td>{{$value['percentage']}}</td>
                                    <td><a href="{{URL::asset('index.php/operate/analyzepicture?startDate='.$startdate.'&endDate='.$enddate.'&action=3&parent_id='.$data['data']['falldata'][0]['bussname'].'&ob=son&cid='.$value['buss_id'].'&allfans='.$value['all_fans'])}}">查看详情</a></td>
                                </tr>
                    @foreach($value['timedata'] as $k=>$v)
                    <tr class="sub_channel" fatherId="{{$v['buss_id']}}">
                        <td>{{$v['bussname']}}</td>
                        <td>{{$v['all_fans']}}</td>
                        <td>{{$v['un_subscribe']}}</td>
                        <td>{{$v['percentage']}}</td>
                        <td></td>
                    </tr>

                    @endforeach
                @endforeach
                    @endif

                        @endif

        </table>
        @if(isset($arr))
            {{$paginator->appends($parameter)->render()}}
            @endif

    </div>


</div>
</body>
<script type="text/javascript">
    $(function () {
        $("#datetimeStart").datetimepicker({
            format: 'yyyy-mm-dd',
            minView: 'month',
            language: 'zh-CN',
            autoclose: true,
//		        startDate:new Date()
        }).on("click", function () {
            $("#datetimeStart").datetimepicker("setEndDate", $("#datetimeEnd").val())
        });
        $("#datetimeEnd").datetimepicker({
            format: 'yyyy-mm-dd',
            minView: 'month',
            language: 'zh-CN',
            autoclose: true,
//		        startDate:new Date()
        }).on("click", function () {
            $("#datetimeEnd").datetimepicker("setStartDate", $("#datetimeStart").val())
        });


        //左边列表栏缩略
        $('.sub_file').click(function () {
            var $this = $(this);
            var $list = $this.find('.sub_list')
            if ($list.is(':hidden')) {
                $list.show();
                $this.addClass('on_file').removeClass('off_file');
                $this.find('.sub_close').hide().siblings('.sub_open').show()
            } else {
                $list.hide();
                $this.addClass('off_file').removeClass('on_file');
                $this.find('.sub_close').show().siblings('.sub_open').hide()
            }
        })


        //渠道统计报表子渠道缩略
        $('table').delegate('.f_channel', 'click', function () {
            var $this = $(this);
            var code = $this.attr('channelId');
            var $sub = $('.sub_channel[fatherId="' + code + '"]')
            if ($sub.length > 0) {
                if ($sub.is(':hidden')) {
                    $sub.show();
                    $this.addClass('on_channel').removeClass('off_channel');
                } else {
                    $sub.hide();
                    $this.addClass('off_channel').removeClass('on_channel');
                }
            }
        })

        $(".excel").click(function(){
            $("input[name=excel]").val(1);
            var excel = $("input[name=excel]").val();
            $("#f-report").submit();
            $("input[name=excel]").val(0);
        })

        $(".reset").click(function(){
            window.location.href='/operate/analyzechannel';
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


        $(".checkson").click(function(){
           var parent_id =  $(this).attr('value');
           var startDate =  $("input[name=startDate]").val();
           var  endDate  = $("input[name=endDate]").val()

            window.location.href = "/operate/analyzechannel?cid="+parent_id+"&channel="+parent_id+"&startDate="+startDate+"&endDate="+endDate+"&excel=0";

        });


    })
</script>

</html>
