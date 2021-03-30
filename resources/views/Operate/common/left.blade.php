<div class="main-left">
				<div class="left-menu">

                    @foreach(session()->get('leftdata')['data']['topModule'] as $key=>$value)
                        <div class="menu-header">
                            <div class="menu-title">
                                <span class="icon-folder"></span>
                                {{$value}}
                                <span class="icon-arrow"></span>
                            </div>
                            <ul class="menu-list" style="display: none;">
                                @foreach(session()->get('leftdata')['data']['data'] as $k=>$v)
                                    @if($v['topModule'] ==$value )
                                <li class="left_bar {{$v['id']}}" data="{{$v['id']}}">
                                    <a href="{{ URL::asset($v['url']) }}">{{$v['bottomModule']}}</a>
                                </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

				</div>
			</div>
<script src="{{ URL::asset('js/jquery.cookie.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //左边列表栏缩略
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

    $(document).ready(function(){
        $(".left_bar").click(function(){
            var on_here = $(this).attr('data');
            $.cookie("on_here",on_here,{ path: '/' });
            //var on_here = $.cookie("on_here");
        })
        var on_here = $.cookie("on_here");
        if(on_here){
            $("."+on_here).addClass('active');
            $("."+on_here).parent().prev().click();
        }else{
            $(".7").addClass('active');
            $(".7").parent().prev().click();
        }
    })
</script>