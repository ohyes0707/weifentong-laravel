    //检测手机号
    function check_phone(mobile){
        var mobilePhone = /^(13|14|15|18|17)\d{9}$/;
        if (!mobilePhone.test(mobile)){
            return false;
        }
        return true;
    }

    //判断公众号是否报备
    function checkWxNameExist(wx_name){
        var token = $("input[name=_token]").val();
        var open = true;
        $.ajax({
            type : "post",
            dataType:'json',
            url : checkWxNameUrl,
            data :{'wx_name':wx_name,'_token':token},
            async:false,//这里选择异步为false，那么这个程序执行到这里的时候会暂停，等待
                        //数据加载完成后才继续执行
            success : function(res){
                if(res.code==1002){
                    open =  false;
                }
            }
        });
        return open;

/*        $.post(checkWxNameUrl,{'wx_name':wx_name,'_token':token},function(res){
            if(res.code==1002){
                $("#wx_name_error").text('该公众号已报备');
                $("#wx_name_error").show();
            }else{
                $("#wx_name_error").hide();
            }
        },"json")*/
    }

//检测公众号
    function checkWxName(){
        var wx_name = $.trim($("input[name='wx_name']").val());
        if(wx_name==''||wx_name=='undefined'){
            $("#wx_name_error").text('公众号名必填');
            $("#wx_name_error").show();
            return false
        }
        if(!checkWxNameExist(wx_name)){
            $("#wx_name_error").text('该公众号已报备');
            $("#wx_name_error").show();
            return false
        }
        $("#wx_name_error").hide();
        return true;
    }
//检测公司名
    function checkCompany(){
        var company = $.trim($("input[name='company']").val());
        if(company==''||company=='undefined'){
            $("#company_error").text('公司名必填');
            $("#company_error").show();
            return false;
        }
        $("#company_error").hide();
        return true;
    }
//检测联系人
    function checkContacts(){
        var contacts = $.trim($("input[name='contacts']").val());
        if(contacts==''||contacts=='undefined'){
            $("#contacts_error").text('联系人必填');
            $("#contacts_error").show();
            return false;
        }
        $("#contacts_error").hide();
        return true;
    }
//检测联系方式
    function checkTelphone(){
        var telphone = $.trim($("input[name='telphone']").val());
        if(telphone==''||telphone=='undefined'){
            $("#telphone_error").text('联系方式必填');
            $("#telphone_error").show();
            return false;
        }
        if(!check_phone(telphone)){
            $("#telphone_error").text('手机号格式不正确');
            $("#telphone_error").show();
            return false;
        }
        $("#telphone_error").hide();
        return true;
    }

//检测报备公众号类型
    function checkWxType(){
        var wx_type = $('input:radio[name="type"]:checked').val();
        if(wx_type != 1 && wx_type != 2){
            $("#type_error").text('报备公众号类型必填');
            $("#type_error").show();
            return false;
        }
        $("#type_error").hide();
        return true;
    }

//检测表单提交数据
    function checkForms(){
        var open = true;
        var checkname = checkWxName();
        var checkcompany = checkCompany();
        var checkcontacts = checkContacts();
        var checkphone = checkTelphone();
        var checktype = checkWxType();
        if(!checkname||!checkcompany||!checkcontacts||!checkphone||!checktype){
            open = false;
        }
        return open;
    }

    $(document).ready(function(){
        $(".submit").click(function(){
            if(checkForms()){
                $(".submit").prop("disabled",true);
                $(".form").submit();
            }
        })
    })