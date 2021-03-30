<!DOCTYPE html>
<html>
		<head>
		<meta charset="utf-8" />
		<title>申请报备</title>
			 @include('Agent.common.head')
            <script>
                var checkWxNameUrl = "{{action('Home\ReportController@checkReportName')}}";
            </script>
            <script src="{{ URL::asset('home/js/report.js') }}" type="text/javascript" charset="utf-8"></script>
		</head>
	<body>
		 @include('Agent.common.top')
		
		<div class="main clearfix">
			<!--左侧-->
		 @include('Agent.common.left')
			
			<!--右侧-->
			<div class="main-right">
				
				<div class="head">申请报备</div>
				<div class="process clearfix">
					<div class="step active">
						<img src="{{ URL::asset('home/img/icon_big3.png') }}"/>
						<p>申请报备</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big1.png') }}"/>
						<p>客户授权</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big4.png') }}"/>
						<p>审核下单</p>
					</div>
					<img src="{{ URL::asset('home/img/icon_big7.png') }}" class="icon-step"/>
					<div class="step">
						<img src="{{ URL::asset('home/img/icon_big2.png') }}"/>
						<p>报备成功</p>
					</div>
				</div>
                {!! $errors->first('saveError')!==null?'<p class="tip exist" style="display: block;">'.$errors->first('saveError').'</p>':''!!}
				<form action="" method="post" id="f_add" class="form">
                    {!! csrf_field() !!}
					<div class="form-list">
						<label for="gh-name">公众号：</label><input onblur="checkWxName();" name="wx_name" type="text" id="gh-name" class="text-input"/>
                        <p class="tip exist" id="wx_name_error" style="display: none;"></p>
                        {!! $errors->first('wx_name')!==null?'<p class="tip exist" style="display: block;">'.$errors->first('wx_name').'</p>':''!!}
                        {!! $errors->first('wxExist')!==null?'<p class="tip exist" style="display: block;">'.$errors->first('wxExist').'</p>':''!!}
                    </div>
					<div class="form-list">
						<label for="company">公司名称：</label><input onblur="checkCompany();" name="company" type="text" id="company" class="text-input"/>
                        <p class="tip exist" id="company_error" style="display: none;"></p>
                        {!! $errors->first('company')!==null?'<p class="tip exist" style="display: block;">'.$errors->first('company').'</p>':''!!}
                    </div>
					<div class="form-list">
						<label for="linkman">联系人：</label><input onblur="checkContacts();" name="contacts" type="text" id="linkman" class="text-input"/>
                        <p class="tip exist" id="contacts_error" style="display: none;"></p>
                        {!! $errors->first('contacts')!==null?'<p class="tip exist" style="display: block;">'.$errors->first('contacts').'</p>':''!!}
                    </div>
					<div class="form-list">
						<label for="linkway">联系方式：</label><input onblur="checkTelphone();" name="telphone" type="text" id="linkway" class="text-input" />
                        <p class="tip exist" id="telphone_error" style="display: none;"></p>
                        {!! $errors->first('telphone')!==null?'<p class="tip exist" style="display: block;">'.$errors->first('telphone').'</p>':''!!}
					</div>
                    <div class="form-list">
			<label for="linkway">所属代理：</label>
                        <select name="agent" style="width: 300px;height: 34px;border: 1px solid #ccc;border-radius: 4px;padding: 0 10px;float: left;">
                                @if(count($data)>0)
                                    @foreach ($data as $agentList)
                                    <option value="{{ $agentList['id'] }}" >{{ $agentList['nick_name'] }}</option>
                                    @endforeach
                                @endif
                            </select>   
                        <p class="tip exist" id="telphone_error" style="display: none;"></p>
                    </div>
                    <div class="form-list">
                        <label>绑定方式：</label>
                        <label class="label-radio l_radio onradio">{{--<input onclick="alert('本期只开放门店类型公众号报备')" type="button">--}}<input onclick="checkWxType()" type="radio" name="type" value="1">公众号授权</label>
                        <label class="label-radio offradio"><input onclick="checkWxType()" type="radio" name="type" value="2">门店添加</label>
                        <p class="tip exist" id="type_error" style="display: none"></p>
                    </div>
                    
					<input type="button" value="申请" class="submit"/>
					<input type="button" value="取消" class="cancel" onclick="history.go(-1)"/>
				</form>	
				
			</div>
		</div>
	</body>
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
		
		function selectItem(){
			var str='';
			var items=$('td input[type=checkbox]:checked');
			console.log(items)
			items.each(function(){
				var $text=$(this).parents('tr').find('td').eq(2).text();
				str+='<span>'+$text+'</span>'
			})
			return str;
		}
	</script>
</html>
