<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>系统权限-角色列表-编辑</title>
    @include('Operate.common.head')
    {{--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="css/city-picker.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="css/common.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="css/public.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="css/page.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="css/statistics.css"/>--}}

    {{--<script src="js/jquery-2.1.4.min.js" type="text/javascript" charset="utf-8"></script>--}}
    {{--<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>--}}
    {{--<script src="js/function.js" type="text/javascript" charset="utf-8"></script>--}}
    <style type="text/css">
        .detail input{
            width: 18px;
            height: 18px;
            vertical-align: bottom;
        }
        .detail th input{
            margin-left: 40px;
            margin-right: 10px;
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
        <div class="header">编辑</div>

        <form action="" method="post" class="role-form">
            <div class="form-list">
                <label>用户组：</label><input type="input" name="userGroup" value="{{$data['data']['roleInfo'][0]['title']}}" class="text-input"/>
            </div>

            <table class="table-bordered table-responsive detail init-table">
                <tr>
                    <th>管理模块</th>
                    <th><input type="checkbox" name="look" class="look-input"/>查看</th>
                    <th><input type="checkbox" name="look" class="operate-input"/>操作</th>
                </tr>
                @foreach($data['data']['topmodele'] as $key =>$value)
                    <tr class="f_channel off_channel" channelId="{{$value['topModule']}}">
                        <td>{{$value['topModule']}}</td>
                        <td><input type="checkbox" name="look" class="look-input"/></td>
                        <td><input type="checkbox" name="look" class="operate-input"/></td>
                    </tr>
                    @foreach($data['data']['bottommodele'] as $k=>$v)
                        @if($v['topModule'] ==$value['topModule'])
                            <tr class="sub_channel" fatherId="{{$v['topModule']}}">
                                <td>{{$v['bottomModule']}}</td>
                                <td><input type="checkbox" name="look" value="{{$v['id']}}" class="look-input"/></td>
                                <td><input type="checkbox" name="look" value="{{$v['id']}}" class="operate-input"/></td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </table>
            <input type="hidden" name="roleInfo" value="{{json_encode($data['data']['roleInfo'])}}"/>
            <input type="hidden" name="nameId" value="{{$id}}"/>
            <div class="btns">
                <input type="button" value="确定" class="submit"/>
                <input type="button" value="返回" class="shopcancel" onclick="history.go(-1)"/>
            </div>
            <div class="myalert" style="display: none;">
                <div class="mask"></div>
                <div class="alertbox">
                    <a href="#" class="close">&times;</a>
                    <div class="alertHead">提示</div>
                    <div class="alertMain">
                        确认是否保存此修改？
                    </div>
                    <div class="alertbtn">
                        <input type="button" class="btn btn-sure" value="确认"/>
                        <input type="button" value="取消" class="btn btn-cancel"/>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
</body>
<script type="text/javascript">
    $(function(){


        //弹窗
        $('.submit').click(function(){
            $('.myalert').show()
        })

        $('.btn-cancel,.close').click(function(){
            $('.myalert').hide()
        })




        /*-------------------------2017-09-06-------------------------*/
        $('table').delegate('.f_channel','click',function(){
            var $this=$(this);
            var code=$this.attr('channelId');
            var $sub=$this.parents('table').find('.sub_channel[fatherId="'+code+'"]');
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

        $('.f_channel').each(function(){
            $(this).find('td:gt(0)').click(function(e){
                e.stopPropagation()
            })
        })

        $('th input').click(function(){
            var $this=$(this)
            var className=$this.attr('class');
            if($this.prop('checked')){
                $('.'+className).prop('checked',true)
            }else{
                $('.'+className).prop('checked',false)
            }
        })

        $('.f_channel input').click(function(){
            var $this=$(this)
            var className=$this.attr('class');
            var code=$this.parents('.f_channel').attr('channelId')
            var $sub=$('.sub_channel[fatherId="'+code+'"]').find('.'+className);
            var total=$('.f_channel .'+className).length
            var checkedNum=$('.f_channel .'+className+':checked').length
            if($this.prop('checked')){
                $sub.prop('checked',true)
            }else{
                $sub.prop('checked',false)
            }
            if(checkedNum == total){
                $('th .'+className).prop('checked',true)
            }else{
                $('th .'+className).prop('checked',false)
            }
        })

        $('.sub_channel input').click(function(){
            var $this=$(this)
            var className=$this.attr('class');
            var code=$this.parents('.sub_channel').attr('fatherId');
            var $father=$('.f_channel[channelId="'+code+'"]').find('.'+className);//父级的选择框
            var $sub=$('.sub_channel[fatherId="'+code+'"]');//父级的所有子级
            var checkedNum=$sub.find('.'+className+':checked').length;

            if(checkedNum == $sub.length){
                $father.prop('checked',true)
            }else{
                $father.prop('checked',false)
            }
            var fatherNum=$('.f_channel .'+className+':checked').length;//选中的父级长度
            if(fatherNum == $('.f_channel').length){
                $('th .'+className).prop('checked',true)
            }else{
                $('th .'+className).prop('checked',false)
            }
        })


        var data=$('input[name=roleInfo]').val();
        data=JSON.parse(data)
        var lookData=data[0].lookdata.split(',');
        var operateData=data[0].operatedata.split(',');
        var lookinput=$('.sub_channel .look-input');
        var operateinput=$('.sub_channel .operate-input')

        lookinput.each(function(){
            var val=$(this).val()
            if(lookData.indexOf(val)>=0){
                $(this).prop('checked',true)
            }else {
                $(this).prop('checked',false)
            }
        })

        operateinput.each(function(){
            var val=$(this).val()
            if(operateData.indexOf(val)>=0){
                $(this).prop('checked',true)
            }else {
                $(this).prop('checked',false)
            }
        })

        $('.f_channel').each(function(){
            var $this=$(this);
            var code=$this.attr('channelId')
            var $sub=$('.sub_channel[fatherId="'+code+'"]');
            var lookinput=$('.sub_channel[fatherId="'+code+'"] .look-input:checked')
            var operateinput=$('.sub_channel[fatherId="'+code+'"] .look-input:checked')
            if(lookinput.length == $sub.length){
                $this.find('.look-input').prop('checked',true)
            }else{
                $this.find('.look-input').prop('checked',false)
            }
            if(operateinput.length == $sub.length){
                $this.find('.operate-input').prop('checked',true)
            }else{
                $this.find('.operate-input').prop('checked',false)
            }
        })

        /**
         * 提交数据
         */
        $('.btn-sure').click(function () {

            var lookData = [];
            var operateData = [];
            var $lookinput = $('.sub_channel .look-input:checked');
            var $operateinput = $('.sub_channel .operate-input:checked');
            var name = $('input[name=userGroup]').val();
            var id = $('input[name=nameId]').val();


            $lookinput.each(function (i) {
                lookData[i] = $(this).val()
            })
            $operateinput.each(function (i) {
                operateData[i] = $(this).val();
            })
            lookData=lookData.join(",");
            operateData=operateData.join(",");

            $.getJSON('{{URL::asset('index.php/operate/editRole') }}', {
                        "lookData": lookData,
                        "operateData": operateData,
                        "name": name,
                        'id':id
                    },
                    function (data) {
                        if (data.data > 0) {
                            if (data['data'] == 9999) {
                                alert('该角色以存在')
                            } else {
                                window.location.href = '/operate/roleList'
                            }
                        }
                    });
        });



    })
</script>
</html>
