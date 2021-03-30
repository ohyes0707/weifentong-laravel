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
    <style type="text/css">

    </style>
</head>
<body>
@include('Operate.common.top')

<div class="main clearfix">
    <!--左侧-->
    @include('Operate.common.left')

            <!--右侧-->
    <div class="main-right">
        <form action="{{URL::asset('index.php/operate/analyzeorder')}}" method="get" class="form-inline" role="form" id="f-report">
            <div class="r_form clearfix">
                <div class="f_radio">
                    <a href="{{URL::asset('index.php/operate/analyzeplatform')}}">平台</a>
                    <a href="javascript: void(0)" class="on_radio">订单</a>
                    <a href="{{URL::asset('index.php/operate/analyzechannel')}}">渠道</a>
                </div>
            </div>

            <div class="form-group position">
                <label>
                    公众号：
                </label>
                <input type="text" id="inputv" onkeyup="checkFunction()" name="gzh" value="{{isset($Get['gzh'])?$Get['gzh']:""}}" class="form-control">
                <ul id="ul_hide">
                    @if(isset($namelist)&& count($namelist)>0)
                    @foreach($namelist as $k=>$v)
                        <li class="option_obj" style="display: none;">{{$v[0]}}</li>
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
                <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart" value="{{isset($Get['startDate'])?$Get['startDate']:""}}" readonly /></label>

                <label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{isset($Get['endDate'])?$Get['endDate']:""}}" readonly /></label>

            </div>
            <input type="hidden" name="excel" value="0">
            <input type="button" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
            <input type="button" value="导出excel" class="excel"/>
        </form>
        <table class="table-bordered table-responsive table-striped detail colspan-7" id="reportTable">
            <tr>
                <th>公众号</th>
                <th>下单时间</th>
                <th>已涨粉量</th>
                <th>取关量</th>
                <th>取关率</th>
                <th>操作</th>
            </tr>
            @if(isset($reportlist) && $reportlist!= null)
            @foreach($reportlist as $key =>$value)
                <tr>
                    <td>{{$value['wx_name']}}</td>
                    <td>{{$value['o_start_date']}}</td>
                    <td>{{$value['all_fans']=="" ? 0: $value['all_fans']}}</td>
                    <td>{{$value['un_subscribe']=="" ? 0: $value['un_subscribe']}}</td>
                    <td>{{$value['un_attention']}}</td>
                    {{--这里具体传什么值待定--}}
                    <td><a href="{{URL::asset('index.php/operate/analyzepicture?action=2&date='.$value['o_start_date'].'&allfans='.$value['all_fans'].'&oid='.$value['order_id'].'&orderdate='.$value['o_start_date'])}}">查看详情</a></td>

                </tr>
            @endforeach
                @endif

        </table>
        {{--,'reportlist'=>$reportlist_arr,'paginator'=>$paginator--}}

        @if(isset($paginator) && $parameter)
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

        $(".reset").click(function(){
            window.location.href='/operate/analyzeorder';
        })
    })
</script>

</html>
