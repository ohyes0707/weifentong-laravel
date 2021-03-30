<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>代理管理-子代理列表</title>
    @include('Operate.common.head')
    <style type="text/css">
        .detail tr>th:nth-child(1){
            width: 16%;
        }
    </style>
</head>
<body>
@include('Operate.common.top')

<div class="main clearfix">
    <!--左侧-->

    @include('Operate.common.left')
    <!--右侧-->
    <div class="main-right">
        <form action="" method="post" class="form-inline" role="form" id="f-report">
            {{csrf_field()}}
            <div class="form-group">
                <label>
                    子代理名称：
                </label>
                {{--<input type="text" name="agency" placeholder="子代理代理" value="{{$nick_name==""?'':$nick_name}}" class="input"/>--}}
                <input type="text" name="sonagency" placeholder="子代理代理" value="{{$sonagency}}" class="input"/>

            </div>
            <div class="form-group">
                <label>
                    所属代理：
                </label>
                <select name="agency" class="form-control">
                    @if(isset($namelist)&& count($namelist)>0)
                        @foreach($namelist as $k=>$v)
                            @if($agency==$v['nick_name'])
                                <option value="{{$v['nick_name']}}" selected>{{$v['nick_name']}}</option>
                            @else
                            <option value="{{$v['nick_name']}}">{{$v['nick_name']}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <input type="submit" value="查询" class="find"/>
            <input type="reset" value="重置" class="reset"/>
        </form>
        {!! csrf_field() !!}
        <table class="table-bordered table-responsive detail">
            <tr>
                <th>账号</th>
                <th>子代理名称</th>
                <th>所属代理</th>
                <th>报备</th>
                <th>授权</th>
                <th>报备完成</th>
                <th>工单</th>
                <th>订单</th>
                <th>总销售额</th>
                <th>操作</th>
            </tr>
            @if(isset($reportlist) &&  count($reportlist)>0 && isset($reportlist[0]['username']))
            @foreach($reportlist as $key=>$value)
            <tr>
                <td>{{$value['username']}}</td>
                <td>{{$value['sonname']}}</td>
                <td>{{$value['fatrhername']}}</td>
                <td>{{$value['reportFail']}}</td>
                <td>{{$value['auth']}}</td>
                <td>{{$value['report']}}</td>
                <td>{{$value['work']}}</td>
                <td>{{$value['order']}}</td>
                <td>{{$value['agentMoney']}}</td>
                <td>
                    <a href="{{URL::asset('index.php/agent/analyseSonAgent?id='.$value['id'])}}" class="btn btn-blue">报表</a>
                </td>
            </tr>
                @endforeach
           @endif
        </table>
        @if(isset($reportlist)&& count($reportlist)>0&& isset($reportlist[0]['username']))
            {{$paginator->appends($parameter)->render()}}
        @endif
    </div>
</div>


</body>
<script type="text/javascript">
    $(function(){

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

        $(".reset").click(function(){
            window.location.href='/agent/sonAgentList';
        })



    })
</script>
</html>
