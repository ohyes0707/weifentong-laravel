<?php
namespace App\Http\Controllers\Operate;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
class AnalyzeOrderController extends Controller
{
    public function platformdata()
    {

        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;  // 0 全部 1 新用户 2 老用户

        $userSelect = isset($_REQUEST['user']) ? $_REQUEST['user'] : 0;  // 0 全部 1 新用户 2 老用户
        $start_date = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : date('Y-m-d',strtotime('-7days'));

        $end_date = isset($_REQUEST['endDate']) && $_REQUEST['endDate'] != "" ? $_REQUEST['endDate'] : date('Y-m-d',strtotime('-1days'));

        $_GET['startDate'] = $start_date;
        $_GET['endDate'] = $end_date;

        if ($excel == 1) {
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 9999;
        } else {
            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 10;
        }


        $parameter = array('userSelect' => $userSelect, 'start_date' => $start_date, 'end_date' => $end_date, 'page' => $page, 'pagesize' => $pagesize, 'action' => 'platform', 'excel' => $excel);

        $parameter1 = array('user' => $userSelect, 'startDate' => $start_date, 'endDate' => $end_date, 'page' => $page, 'pagesize' => $pagesize, 'action' => 'platform', 'excel' => $excel);

        $data = HttpRequest::getApiServices('Operate', 'getReportData', 'GET', $parameter);
        $arr = $data['data']['data'];

        if(count($arr)==0)
        {
            return view('Operate.analyzeplatform', ['parameter' => $parameter, 'arr' => $arr, 'Get' => $_GET,'startDate'=>$start_date,'endDate'=>$end_date]);
            exit();
        }

        // 取关
        foreach ($arr as $k => $value) {
            if ($value['all_fans'] != 0) {
                $un_attention = (int)$value['un_subscribe'] / (int)$value['all_fans'];
                $un_attention = number_format($un_attention, 4);

            } else {
                $un_attention = 0.00;
            }

            $un_attention = ($un_attention * 100) . '%';
            $arr[$k]['un_attention'] = $un_attention;
        }


        if ($excel == 1) {
            if ($arr) {
                $name = '平台统计报表';
                $head['head'] = array('日期',' 已涨粉', '取关量', '取关率');
                $newArray = array();
                foreach ($arr as $kk => $value)
                {
                    $Array['date_time'] = $value['date_time'];
                    $Array['all_fans'] = $value['all_fans'];
                    $Array['un_subscribe'] = $value['un_subscribe'];
                    $Array['un_attention'] = $value['un_attention'];
                    $newArray[] = $Array;
                }
                self::export($name, $head, $newArray);

            }

        }else {

            if (!empty($arr)) {
                $count = $data['data']['count'];

                //实现分页
                $paginator = self::pagslist($arr, $count, $pagesize);
                $reportlist_arr = $paginator->toArray()['data'];

                return view('Operate.analyzeplatform', ['parameter' => $parameter1, 'arr' => $arr, 'Get' => $_GET, 'reportlist' => $reportlist_arr, 'paginator' => $paginator,'startDate'=>$start_date,'endDate'=>$end_date]);
            }
        }

    }


    /**
     *  获取订单报表数据
     */

    public function orderdata(){

        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;  // 0 全部 1 新用户 2 老用户
        $wxname = isset($_REQUEST['gzh'])?$_REQUEST['gzh']:'';
        $wxname = $wxname=='全部'?'':$wxname;
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $end_date = isset($_REQUEST['endDate'])&&$_REQUEST['endDate']!=""?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));

        $_GET['startDate'] = $start_date;
        $_GET['endDate'] = $end_date;

        if($excel==1)
        {
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:9999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }

        $parameter = array('wxname'=>$wxname,'start_date'=>$start_date,'end_date'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'action'=>'order');

        $pageparameter = array('gzh'=>$wxname,'startDate'=>$start_date,'endDate'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'action'=>'order');

        $data = HttpRequest::getApiServices('Operate','getReportData','GET',$parameter);

        $arr = $data['data']['data'];

        if(count($arr)==0)
        {
            return view('Operate.analyzeorder',['parameter'=>$parameter,'arr'=>$arr,'Get'=>$_GET,'startDate'=>$start_date,'endDate'=>$end_date]);
            exit();

        }
        // 取关率
        foreach ($arr as $k=>$value)
        {
            if($value['all_fans']!=0){
                $un_attention =  (int)$value['un_subscribe']/(int)$value['all_fans'];
                $un_attention = number_format($un_attention,4);
            }else{
                $un_attention = 0;
            }

            $un_attention = ($un_attention*100).'%';

            $arr[$k]['un_attention'] = $un_attention;
        }

        if($excel==1)
        {
            $name = '平台统计报表';

            $head['head'] = array('公众号', '下单时间', '已涨粉量', '取关量','取关率	');

            $newArray = array();

            foreach ($arr as $kk => $value)
            {
                $Array['wx_name'] = $value['wx_name'];
                $Array['o_start_date'] = $value['o_start_date'];
                $Array['all_fans'] = $value['all_fans'];
                $Array['un_subscribe'] = $value['un_subscribe'];
                $Array['un_attention'] = $value['un_attention'];
                $newArray[] = $Array;
            }

            self::export($name, $head, $newArray);

        }else{
            if(!empty($arr)){

                $count= $data['data']['count'];

                //实现分页
                $paginator =self::pagslist($arr, $count, $pagesize);

                $reportlist_arr = $paginator->toArray()['data'];

                $nameArray = count($data['data']['wxname'])?$data['data']['wxname']:array();


                return view('Operate.analyzeorder',['parameter'=>$pageparameter,'arr'=>$arr,'Get'=>$_GET,'reportlist'=>$reportlist_arr,'paginator'=>$paginator,'namelist'=>$nameArray,'startDate'=>$start_date,'endDate'=>$end_date ]);

            }
        }

    }


    /**
     * @return 渠道数据
     */
    public function channeldata(){

        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;  // 0 全部 1 新用户 2 老用户
        $channelname = isset($_REQUEST['channel'])?$_REQUEST['channel']:'';

        $cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:'';

        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $end_date = isset($_REQUEST['endDate'])&&$_REQUEST['endDate']!=""?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));

        $_GET['startDate'] = $start_date;
        $_GET['endDate'] = $end_date;

        if($excel==0)
        {
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:9999;
        }

        $parameter = array('bussid'=>$channelname,'start_date'=>$start_date,'end_date'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'action'=>'channel','excel'=>$excel);

            if($channelname && $channelname!="")
            {
                $data = HttpRequest::getApiServices('Operate','getReportData','GET',$parameter);

                if($excel==1){

                    $name = '渠道统计报表';
                    $head['head'] = array('渠道', '总涨粉量', ' 已涨粉量', '取关量	','取关率');
                    self::export($name, $head, $data['data']);

                }else{
                    return view('Operate.analyzechannel',['data'=>$data,'Get'=>$_GET,'cid'=>$cid,'startdate'=>$start_date,'enddate'=>$end_date,'show'=>'sole']);
                }
            }else{

                $arr = HttpRequest::getApiServices('Operate','getReportData','GET',$parameter);

                if($excel==1){

                    $name = '渠道统计报表';
                    $head['head'] = array('渠道', '总涨粉量', ' 已涨粉量', '取关量	','取关率');
                    self::export($name, $head, $arr['data']);
                }else{
                    $count= isset($arr['data']['count'])?$arr['data']['count']:0;

                    //实现分页
                    $paginator =self::pagslist($arr, $count, $pagesize);
                    $reportlist_arr = $paginator->toArray()['data'];

                    return view('Operate.analyzechannel',['Get'=>$_GET,'arr'=>$reportlist_arr,'paginator'=>$paginator,'parameter'=>$parameter,'cid'=>$cid,'startdate'=>$start_date,'enddate'=>$end_date,'show'=>'all']);
                }

            }

    }

       // 报表数据
    public function analyzepicture(){

        // action 1 为平台表 2 为订单 3 渠道
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $allfans = isset($_REQUEST['allfans'])?$_REQUEST['allfans']:"";
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:'';
        $end_date = isset($_REQUEST['endDate'])&&$_REQUEST['endDate']!=""?$_REQUEST['endDate']:'';

        $busspage= isset($_REQUEST['busspage'])?$_REQUEST['busspage']:1;
        $busspagesize= isset($_REQUEST['busspagesize'])?$_REQUEST['busspagesize']:3;

        $oid = isset($_REQUEST['oid'])?$_REQUEST['oid']:"";
        $cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:"";

        $ob = isset($_REQUEST['ob'])&&$_REQUEST['ob']!=""?$_REQUEST['ob']:''; // all总级别  father父级别 son 子级别
        $parent_id = isset($_REQUEST['parent_id'])&&$_REQUEST['parent_id']!=""?$_REQUEST['parent_id']:''; // all总级别  father父级别 son 子级别

        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;

        if($_REQUEST['action']==1)
        {
            $date = isset($_REQUEST['date'])?$_REQUEST['date']:'';
            if($date == "总计"){
                $start_date  =  $start_date==""? date('Y-m-d',strtotime('-7days')):$start_date;
                $end_date  =  $end_date==""? date('Y-m-d',strtotime('-1days')):$end_date;
            }
            $parameter = array('action'=>$_REQUEST['action'],'date'=>$date,'allfans'=>$allfans,'user'=>$user,'startDate'=>$start_date,'endDate'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'busspage'=>$busspage,'busspagesize'=>$busspagesize);




        }elseif($_REQUEST['action']==2)
        {
             $date = isset($_REQUEST['date'])?$_REQUEST['date']:'';
            //http://operatetest.youfentong.com/index.php/operate/analyzepicture?action=2&date=2017-08-07%2013:54:52&allfans=1414&oid=138&orderdate=2017-08-07%2013:54:52

            if($oid == 0){
                $start_date  =  $start_date==""? date('Y-m-d',strtotime('-7days')):$start_date;
                $end_date  =  $end_date==""? date('Y-m-d',strtotime('-1days')):$end_date;
            }
             $orderdate = isset($_REQUEST['orderdate'])? $_REQUEST['orderdate']:"";
            $parameter = array('action'=>$_REQUEST['action'],'allfans'=>$allfans,'oid'=>$oid,'user'=>$user,'orderdate'=>$orderdate,'startDate'=>$start_date,'endDate'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'busspage'=>$busspage,'busspagesize'=>$busspagesize);


        }elseif($_REQUEST['action']==3)
        {
            $date = isset($_REQUEST['date'])?$_REQUEST['date']:'';
            $parameter = array('action'=>$_REQUEST['action'],'allfans'=>$allfans,'cid'=>$cid,'user'=>$user,'startDate'=>$start_date,'endDate'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'ob'=>$ob,'parent_id'=>$parent_id);
        }


        $data = HttpRequest::getApiServices('Operate','getPictureData','GET',$parameter);


        if(isset($data['data']['provinceAreafans']))
        {
            $arr = $data['data']['provinceAreafans'];
            $count = $data['data']['provinceAreafans']['count'];

            //实现分页
            $paginator =self::pagslist($arr, $count, $pagesize);

            $reportlist_arr = $paginator->toArray()['data']['data'];

            if($_REQUEST['action']!=3){

                $bussarr = $data['data']['channeldata']['data'];
                $busscount = $data['data']['channeldata']['count'];
                $busspaginator =self::onlyPagslist($bussarr, $busscount, $busspagesize);
                   if($_REQUEST['action']==1){
                       $bussparameter = array('action'=>$_REQUEST['action'],'date'=>$date,'allfans'=>$allfans,'user'=>$user,'startDate'=>$start_date,'endDate'=>$end_date,'busspage'=>$busspage,'busspagesize'=>$busspagesize);
                   }else{

                       $bussparameter = array('action'=>$_REQUEST['action'],'allfans'=>$allfans,'oid'=>$oid,'user'=>$user,'orderdate'=>$orderdate,'startDate'=>$start_date,'endDate'=>$end_date,'page'=>$page,'pagesize'=>$pagesize,'busspage'=>$busspage,'busspagesize'=>$busspagesize);
                   }




                return view('Operate.analyzepicture',['data'=>$data,'action'=>$_REQUEST['action'],'arr'=>$reportlist_arr,'paginator'=>$paginator,'parameter'=>$parameter,'oid'=>$oid,'cid'=>$cid,'allfans'=>$allfans,'date'=>$date,'startDate'=>$start_date,'endDate'=>$end_date,'user'=>$user,'ob'=> $ob,'parent_id'=>$parent_id,'busspaginator'=>$busspaginator,'bussparameter'=>$bussparameter]);
            }


            return view('Operate.analyzepicture',['data'=>$data,'action'=>$_REQUEST['action'],'arr'=>$reportlist_arr,'paginator'=>$paginator,'parameter'=>$parameter,'oid'=>$oid,'cid'=>$cid,'allfans'=>$allfans,'date'=>$date,'startDate'=>$start_date,'endDate'=>$end_date,'user'=>$user,'ob'=> $ob,'parent_id'=>$parent_id]);

        }else{
            $arr = array();




            return view('Operate.analyzepicture',['data'=>$data,'action'=>$_REQUEST['action'],'arr'=>$arr,'parameter'=>$parameter,'oid'=>$oid,'cid'=>$cid,'allfans'=>$allfans,'date'=>$date,'startDate'=>$start_date,'endDate'=>$end_date,'user'=>$user,'ob'=> $ob,'parent_id'=>$parent_id]);
        }


    }





}