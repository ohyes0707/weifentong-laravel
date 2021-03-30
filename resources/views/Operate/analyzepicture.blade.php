<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>分析报表</title>
    @include('Operate.common.head')
</head>
<body>
@include('Operate.common.top')

<div class="main clearfix">
    @include('Operate.common.left')
    <!--左侧-->


    <!--右侧-->

    <div class="main-right">
        <form action="" method="get" class="form-inline" role="form" id="f-report">
            <div class="form-group">
                @if($action!=2)
                <label>
                    用户选择：
                </label>
                @endif

                <input type="hidden" name="action" value="{{$action}}"/>
                @if($action==1)
                    <input type="hidden" name="allfans" value="{{$allfans}}"/>
                    <input type="hidden" name="date" value="{{$date}}"/>
                 @elseif($action==2)
                <input type="hidden" name="allfans" value="{{$allfans}}"/>
                    @elseif($action==3)

                    <input type="hidden" name="allfans" value="{{$allfans}}"/>
                    <input type="hidden" name="ob" value="{{$ob}}"/>
                    <input type="hidden" name="parent_id" value="{{$parent_id}}"/>

                @endif
                <input type="hidden" name="cid" value="{{$cid}}"/>
                <input type="hidden" name="oid" value="{{$oid}}"/>

                @if($action!=2)

                    <select name="user" class="form-control">
                        @if(isset($user) && $user==0)
                            <option selected value="0">全部</option>
                            <option value="1">新用户</option>
                            <option value="2">老用户</option>
                        @elseif(isset($user) &&$user==1)
                            <option value="0">全部</option>
                            <option selected value="1">新用户</option>
                            <option value="2">老用户</option>
                        @elseif(isset($user) &&$user==2)
                            <option value="0">全部</option>
                            <option value="1">新用户</option>
                            <option selected value="2">老用户</option>
                        @endif
                    </select>
                    @else


                    @endif

            </div>
            <div class="form-group">
                <label class="datelabel">选择时间：<input type="text" name="startDate" class="form-control date" id="datetimeStart"  value="{{isset($startDate)?$startDate:""}}" readonly /></label>

                <label class="datelabel">至&nbsp;<input type="text" name="endDate" class="form-control date" id="datetimeEnd" value="{{isset($endDate)?$endDate:""}}"readonly /></label>

            </div>

            <input type="submit" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
        </form>

        <!--平台粉丝性别分析图-->
        <div class="chart clearfix">
            <div class="chart-title"><span></span>平台粉丝性别分析图</div>
            <div class="chart-main">
                <div id="sexChart" style="width: 40%;height: 400px;"></div>
                <div class="sexTable">

                    @if($action==3)
                        <table class="table-bordered table-responsive table-striped detail colspan-3">
                            <tr>
                                <th>性别</th>
                                <th>粉丝数量</th>
                                <th>占比</th>
                            </tr>
                            @if(isset($data['data']['sexComparison']))
                                <tr>
                                    <td>男</td>
                                    <td>{{$data['data']['sexComparison']['boyfans']}}</td>
                                    <td>{{$data['data']['sexComparison']['boypercentage']}}</td>
                                </tr>
                                <tr>
                                    <td>女</td>
                                    <td>{{$data['data']['sexComparison']['girfans']}}</td>
                                    <td>{{$data['data']['sexComparison']['girlpercentage']}}</td>
                                </tr>
                                <tr>
                                    <td>未知</td>
                                    <td>{{$data['data']['sexComparison']['nbgfans']}}</td>
                                    <td>{{$data['data']['sexComparison']['nbgpercentage']}}</td>
                                </tr>
                                @endif
                        </table>
                    @else

                        <table class="table-bordered table-responsive table-striped detail colspan-3">
                            <tr>
                                <th>渠道</th>
                                <th>粉丝数量</th>
                                <th>占比</th>
                            </tr>
                            @if(isset($data['data']['channeldata']))
                                @foreach($data['data']['channeldata']['data'] as $key =>$value)
                                <tr>
                                    <td>{{$value['username']}}</td>
                                    <td>{{$value['total_fans']}}</td>
                                    <td>{{$value['busspercent']}}</td>
                                </tr>
                                @endforeach
                            @endif
                        </table>

                        @if(isset($bussparameter)  &&  isset($busspaginator))
                            {{$busspaginator->appends($bussparameter)->render()}}
                        @endif
                    @endif

                </div>
            </div>
        </div>
        <script type="text/javascript">

            var color=['#3ea9f5','#ffce56','#4abd90'];
            var sexChart = echarts.init(document.getElementById('sexChart'));

            sexChart.setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },
                legend: {
                    orient: 'horizontal',
                    left: 'center',
                    bottom: '20',
                    itemGap: 40,
                    itemWidth: 30,
                    itemHeight: 14,
                    data:['男','女','未知']
                },
                series: [
                    {
                        name:'平台粉丝性别分析图',
                        type:'pie',
                        radius: ['50%', '70%'],
                        label: {
                            normal: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                show: true,
                                textStyle: {
                                    fontSize: '30',
                                    fontWeight: 'bold'
                                }
                            }
                        },
                        labelLine: {
                            normal: {
                                show: false
                            }
                        },
                        data:[
                            {
                                value:{{isset($data['data']['sexComparison']['boyfans'])?$data['data']['sexComparison']['boyfans']:0 }},
                                name:'男',
                                itemStyle: {
                                    normal: {
                                        color: color[0]
                                    }
                                }
                            },{
                                value:{{isset($data['data']['sexComparison']['girfans'])?$data['data']['sexComparison']['girfans']:0 }},
                                name:'女',
                                itemStyle: {
                                    normal: {
                                        color: color[1]
                                    }
                                }
                            },{
                                value:{{isset($data['data']['sexComparison']['nbgfans'])?$data['data']['sexComparison']['nbgfans']:0 }},
                                name:'未知',
                                itemStyle: {
                                    normal: {
                                        color: color[2]
                                    }
                                }
                            }
                        ]
                    }
                ]
            });


//            // 异步加载数据
//            $.get('data.json').done(function (data) {
//                // 填入数据
//                sexChart.setOption({
//                    series: [{
//                        // 根据名字对应到相应的系列
//                        name: '平台粉丝性别分析图',
//                        data: data.data
//                    }]
//                });
//            });
        </script>


        <!--订单粉丝所在地分布图-->
        <div class="chart" style="padding-bottom: 50px;">
            <div class="chart-title"><span></span>订单粉丝所在地分布图</div>
            <div class="chart-main clearfix">
                <div id="areaChart" style="width: 40%;height: 500px;">
                    <div class="jb_img"><img src="{{ URL::asset('operate/img/colorone.png')}}"/></div>
                </div>
                <div class="areaTable">
                    <table class="table-bordered table-responsive table-striped detail init-table colspan-3">
                        <tr>
                            <th>所在地</th>
                            <th>粉丝数量</th>
                            <th>占比</th>
                        </tr>


                        @foreach($arr as $kk=>$value)

                            <tr class="{{isset($arr[$kk]['city'])?"f_channel off_channel":"f_channel on_channel" }}" channelId="{{$kk}}">
                                <td>{{$value['province']}}</td>
                                <td>{{$value['time']}}</td>
                                <td>{{$value['times']}}</td>
                            </tr>
                        @if(isset($arr[$kk]['city']))
                            @foreach($arr[$kk]['city'] as $k=>$v)
                                @if($v['province']==$value['province'])
                                    <tr class="sub_channel"fatherId="{{$kk}}" >
                                        <td>{{$v['city']}}</td>
                                        <td>{{$v['time']}}</td>
                                        <td>{{$v['times']}}</td>
                                    </tr>
                                    @endif

                            @endforeach
                            @endif

                            @endforeach
                    </table>
                    <input type="hidden" name="data" value="{{isset($data['data']['provinceAreafans'])?json_encode($data['data']['provinceAreafans']):0}}">
                    @if(isset($parameter)  &&  isset($paginator))
                    {{$paginator->appends($parameter)->render()}}
                        @endif
                </div>
            </div>
        </div>
        <script type="text/javascript">

            var dataStatus = [　　　{
                id: 'HKG',
                name: '香港',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'HAI',
                name: '海南',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'YUN',
                name: '云南',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'BEJ',
                name: '北京',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'TAJ',
                name: '天津',
                fans: '',
                precent: ''
            }, 　　　 {
                id: 'XIN',
                name: '新疆',
                fans: '',
                precent: ''
            }, 　　　 {
                id: 'TIB',
                name: '西藏',
                fans: '',
                precent: ''
            }, 　　　 {
                id: 'QIH',
                name: '青海',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'GAN',
                name: '甘肃',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'NMG',
                name: '内蒙古',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'NXA',
                name: '宁夏',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'SHX',
                name: '山西',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'LIA',
                name: '辽宁',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'JIL',
                name: '吉林',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'HLJ',
                name: '黑龙江',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'HEB',
                name: '河北',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'SHD',
                name: '山东',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'HEN',
                name: '河南',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'SHA',
                name: '陕西',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'SCH',
                name: '四川',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'CHQ',
                name: '重庆',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'HUB',
                name: '湖北',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'ANH',
                name: '安徽',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'JSU',
                name: '江苏',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'SHH',
                name: '上海',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'ZHJ',
                name: '浙江',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'FUJ',
                name: '福建',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'TAI',
                name: '台湾',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'JXI',
                name: '江西',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'HUN',
                name: '湖南',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'GUI',
                name: '贵州',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'GXI',
                name: '广西',
                fans: '',
                precent: ''
            }, 　　　　 {
                id: 'GUD',
                name: '广东',
                fans: '',
                precent: ''
            }　　];
            //数据库数据 alldata

            var alldata = $('input[name=data]').val();
            var alldatan = JSON.parse(alldata);
            var alldatalist = alldatan.data;



                for(var i = 0;i< dataStatus.length;i++)
            {
                var province = dataStatus[i]['name'];

                for(var j=0;j<alldatalist.length;j++)
                {


                  if(province == alldatalist[j]['province'])
                  {
                      dataStatus[i]['fans'] = alldatalist[j]['time'];
                      dataStatus[i]['precent'] = alldatalist[j]['times'];

                  }


                }


            }




            $('#areaChart').vectorMap({
                map: 'china_zh',
//				　　　　	backgroundColor: false,
                color: "#bbd9fd",
//				　　　	hoverColor: false,
                //显示各地区名称和活动
                onLabelShow: function (event, label, code) {
                    $.each(dataStatus, function (i, items) {
                        if (code == items.id) {
                            label.html(items.name+'</br>粉丝数：' + items.fans+'</br>占比：'+items.precent);
                        }
                    });
                },
            })

            //					var sumtol = 0;
            //					$.each(dataStatus,function(i,items){
            //						if(items.count){
            //							sumtol += parseInt(items.fans);
            //						}
            //					});
            $.each(dataStatus, function (i, items) {
                var colorpre;
//	                		var n = parseInt(items.count) / sumtol;
                var n=parseInt(items.precent);
                if(n == 0){
                    colorpre = '#bedfff';
                }
                else if(n<=10){
                    colorpre = '#abd6ff';
                }else if(n<=25){
                    colorpre = '#82c1fe';
                }else if(n<=40){
                    colorpre = '#50a9ff';
                }else if(n<=55){
                    colorpre = '#1b8fff';
                }else if(n<=70){
                    colorpre = '#0072e0';
                }else if(n<=85){
                    colorpre = '#0058b3';
                }else if(n<=100){
                    colorpre = '#00329a';
                }else{
                    colorpre = '#bbd9fd';
                }
                var josnStr = "{" + items.id + ":'" + colorpre +"'}";
                $('#areaChart').vectorMap('set', 'colors', eval('(' + josnStr + ')'));

            });

            $('.jb_img').show();
        </script>



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
        /*-----------------js修改部分------------------*/

        /*-----------------js修改部分------------------*/



        //渠道统计报表子渠道缩略
        $('table').delegate('.f_channel','click',function(){
            var $this=$(this);
            var code=$this.attr('channelId');
            var $sub=$('.sub_channel[fatherId="'+code+'"]')
            if($sub.length>0){
                if($sub.is(':hidden')){
                    $sub.show();
                    $this.addClass('on_channel').removeClass('off_channel');
                }else{
                    $sub.hide();
                    $this.addClass('off_channel').removeClass('on_channel');
                }
            }
        })



        $(".reset").click(function(){

            $("#datetimeStart").val('');
            $("#datetimeEnd").val('');
            $("select[name=user]").val(0);
            $("#f-report").submit();
//            window.location.href='/operate/analyzepicture?action=3';
    })


    })
</script>
</html>
