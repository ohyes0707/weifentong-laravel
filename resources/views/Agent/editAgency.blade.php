<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>代理管理-编辑</title>
    @include('Agent.common.head')
</head>
<body>
@include('Agent.common.top')

<div class="main clearfix">
    <!--左侧-->
    @include('Agent.common.left')

    <!--右侧-->
    <div class="main-right">
        <div class="head">编辑</div>

        <form action="" method="post" class="form">
            {!! csrf_field() !!}
            <div class="form-list">
                <label>账号：</label><input type="input" name="username" value="{{$data[0]['username']}}" class="text-input"/>
            </div>
            <div class="form-list">
                <label>密码：</label><label class="input-label"><input type="checkbox" name="password"/>重置为初始密码123456</label>
            </div>
            <div class="form-list">
                <label>代理名称：</label><input type="input" name="nick_name" value="{{$data[0]['nick_name']}}" class="text-input"/>
            </div>
            <div class="form-list">
                <label>保底价：</label><input type="input" name="ti_money" value="{{$data[0]['ti_money']}}" class="text-input"/>
            </div>

            <input type="button" value="确定" class="submit"/>
            <input type="button" value="返回" class="cancel" onclick="history.go(-1)"/>
            <div class="myalert" style="display: none;">
                <div class="mask"></div>
                <div class="alertbox">
                    <a href="#" class="close">&times;</a>
                    <div class="alertHead">提示</div>
                    <div class="alertMain">
                        确认是否保存此修改？
                    </div>
                    <div class="alertbtn">
                        <input type="submit" class="btn btn-sure" value="确认"/>
                        <button type="button" class="btn btn-cancel">取消</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
</body>
<script type="text/javascript">
    $(function(){
        //下拉菜单
        $('#navDropdown').on('show.bs.dropdown',function(){
            $('.top-caret').hide()
            $('.bottom-caret').show()
        })

        $('#navDropdown').on('hide.bs.dropdown',function(){
            $('.top-caret').show()
            $('.bottom-caret').hide()
        })

        //弹窗
        $('.submit').click(function(){
            $('.myalert').show()
        })

        $('.btn-cancel,.close').click(function(){
            $('.myalert').hide();
        })


    })
</script>
<script type="text/javascript">
    //左边菜单栏切换
    var a=false;
    function menuToggle(){
        a = !a;
        if(a){
            $('.close-folder').hide();
            $('.open-folder').show();
            $('.bottom-arrow').hide();
            $('.top-arrow').show();
            $('.menu-list').show();
        }else{
            $('.close-folder').show();
            $('.open-folder').hide();
            $('.bottom-arrow').show();
            $('.top-arrow').hide();
            $('.menu-list').hide();
        }
    }

</script>
</html>
