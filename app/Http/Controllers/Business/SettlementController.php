<?php

namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;

class SettlementController extends Controller{
    public function getParentBuss(Request $request) {
        // var_dump(session()->get('buss_id'));
        // var_dump(session()->get('buss_name'));
        // var_dump(session()->get('parent_id'));
        // die;
        $termarray=array(
            'buss_id' =>session()->get('buss_id'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize')
        );
        // var_dump($termarray);die;
        // 
        $startDate = $request->input('startdate');
        $endDate = $request->input('endDate');
        if(empty($startDate)){
            $startDate = date('Y-m-d',strtotime("-1 week"));
        }
        if(empty($endDate)){
            $endDate = date('Y-m-d',strtotime("-1 day"));
        }

        $listdata = HttpRequest::getApiServices('buss','getParentBuss','GET',$termarray);
        // var_dump($listdata);die;
        if(empty($listdata['data']['data'])){
            $Total = 0;
            $total = 0;
            $item = '';
        }else{
            $item=$listdata['data']['data'];//展示的数据
            $total=$listdata['data']['count'];//总共有几条数据
            
        }
        $setpage=  self::pagslist($item, $total,10);
        // // print_r($setpage->toArray()['data']);
        $return['paginator']=$setpage;
        // var_dump($listdata);die;
        // 总额
        if(!empty($listdata['data']['ParentSum'])){
            $Total = $listdata['data']['ParentSum']['money'];
        }else{
            $Total = 0;
        }
        $return['termarray']=$termarray;
        if(empty($item)){
            return view('Business.accountManage',['paginator' => '','termarray' => $termarray,'startDate'=>$startDate,'endDate'=>$endDate,'total' => $Total,'withdrawals' => $listdata['data']['Withdrawals'],'balance' => $listdata['data']['balance']]);
        }
        return view('Business.accountManage',['paginator' => $setpage,'termarray' => $termarray,'startDate'=>$startDate,'endDate'=>$endDate,'total' => $Total,'withdrawals' => $listdata['data']['Withdrawals'],'balance' => $listdata['data']['balance']]);
    }

    public function getWithdrawDeposit(Request $request) {
        $type = $request->input('type');
        if(!empty($type)){
            if($type == 1){
                $termarray=array(
                    'type' =>$type,
                    'bid' =>session()->get('buss_id'),
                    'payee'=>$request->input('payee'),
                    'account'=>$request->input('account'),
                    'amount'=>$request->input('amount'),
                );
            }elseif ($type == 2) {
                $termarray=array(
                    'type' =>$type,
                    'bid' =>session()->get('buss_id'),
                    'payee'=>$request->input('payee'),
                    'bank'=>$request->input('bank'),
                    'cardnumber'=>$request->input('cardnumber'),
                    'amount'=>$request->input('amount')
                );
            }
            $listdata = HttpRequest::getApiServices('buss','getWithdrawDeposit','GET',$termarray);

            if($listdata['success']){
                return redirect()->intended('business/Settlement/getParentBuss');
            }else{
                die("提现失败");
            }
            
        }
        $termarray=array(
            'buss_id' =>session()->get('buss_id'),
        );
        $listdata = HttpRequest::getApiServices('buss','getParentSum','GET',$termarray);

        return view('Business.withdrawDeposit',['withdrawals' => $listdata['data']['Withdrawals'],'balance' => $listdata['data']['balance']]);
    }

    public function getWithdrawLook(Request $request) {
        $termarray=array(
            'buss_id' =>session()->get('buss_id'),
            'lid' =>$request->input('lid'),
        );
        
        $listdata = HttpRequest::getApiServices('buss','getWithdrawLook','GET',$termarray);
        // var_dump($listdata);die;
        return view('Business.cashDetail',['paginator' => $listdata['data']]);
    }

    public function getLook(Request $request) {
        $termarray=array(
            'buss_id' =>session()->get('buss_id'),
            'lid' =>$request->input('lid'),
            'op_money' =>$request->input('op_money'),
            'sbid' =>$request->input('sbid'),
        );
        $listdata_id = HttpRequest::getApiServices('buss','getLook','GET',$termarray);
        if($listdata_id['data']){
            return 1;
        }else{
            return error;
        }
        
    }

    public function getReject(Request $request) {
        $termarray=array(
            'buss_id' =>session()->get('buss_id'),
            'lid' =>$request->input('lid'),
            'reject' =>$request->input('reject'),
        );
        $listdata_id = HttpRequest::getApiServices('buss','getReject','GET',$termarray);
        if($listdata_id['data']){
            echo 'true';
        }else{
            echo false;
        }
        
    }

    public function getSonBuss(Request $request) {
        $termarray=array(
            'buss_id' =>session()->get('buss_id'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize'),
            'status'=>$request->input('state'),
            'buss_one'=>$request->input('subShop'),
        );
        // var_dump($termarray);die;
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        if(empty($startDate)){
            $startDate = date('Y-m-d',strtotime("-1 week"));
        }
        if(empty($endDate)){
            $endDate = date('Y-m-d',strtotime("-1 day"));
        }

        $listdata = HttpRequest::getApiServices('buss','getSonBuss','GET',$termarray);
        if(!empty($listdata['data']['data'])){
            $item=$listdata['data']['data'];//展示的数据
        }else{
            $item= '';
        }
        if(!empty($listdata['data']['count'])){
            $total=$listdata['data']['count'];//总共有几条数据
        }else{
            $total= 0;
        }
        if (!empty($item)) {
            $setpage =  self::pagslist($item, $total,10);
        }else{
            $setpage = 0;
        }
        
        // print_r($setpage->toArray()['data']);
        $state = $request->input('state');
        if(empty($state)){
            $state = 0;
        }

        $subShop = $request->input('subShop');
        if(empty($subShop)){
            $subShop = 0;
        }
        
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;

        if(!empty($listdata['data']['name_list'])){
            $name_list = $listdata['data']['name_list'];
        }else{
            $name_list = 0;
        }

        if(empty($item)){
            return view('Business.childManage',['paginator' => '','termarray' => $termarray,'startDate'=>$startDate,'endDate'=>$endDate,'name_list' => $name_list,'state' => $state,'subShop' => $subShop]);
        }

        return view('Business.childManage',['paginator' => $setpage,'termarray' => $termarray,'startDate'=>$startDate,'endDate'=>$endDate,'name_list' => $name_list,'state' => $state,'subShop' => $subShop]);
    }

    /**  获取当前任务列表
     * @param Request $request
     */
    public function getCurrentReport(Request $request){
        //$bussid = 227;
        $bussid = session()->get('buss_id');
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('bussid'=>$bussid,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Buss','getCurentReport','GET',$parameter);

        $count= isset($data['data']['count'])?$data['data']['count']:0;

        $paginator =self::pagslist($data, $count, $pagesize);
        $reportlist_arr = $paginator->toArray()['data']['data'];
        return view('Business.currentReport',['Get'=>$_GET,'arr'=>$reportlist_arr,'paginator'=>$paginator,'parameter'=>$parameter]);

    }
    /**  获取历史任务列表
     * @param Request $request
     */
    public function getHistoryReport(Request $request){
//        $bussid = 227;
        $bussid = session()->get('buss_id');
        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;
        $channelname = isset($_REQUEST['subShop'])?$_REQUEST['subShop']:'';

        $channelname = $channelname=="全部"? '':$channelname;

        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $end_date = isset($_REQUEST['endDate'])&&$_REQUEST['endDate']!=""?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1 day'));

        $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('bussid'=>$bussid,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$start_date,'end_date'=>$end_date,'excel'=>$excel,'wxname'=>$channelname);
        $data = HttpRequest::getApiServices('Buss','historyTaskList','GET',$parameter);

        if($excel ==0){
            $count= isset($data['data']['count'])?$data['data']['count']:0;
            $paginator =self::pagslist($data, $count, $pagesize);
            $reportlist_arr = $paginator->toArray()['data']['data'];

            $namelist = isset($reportlist_arr['namelist'])&&count($reportlist_arr['namelist'])>0? $reportlist_arr['namelist']:null;

            $_GET['startDate'] = $start_date;
            $_GET['endDate'] = $end_date;
            return view('Business.historyReport',['Get'=>$_GET,'arr'=>$reportlist_arr,'paginator'=>$paginator,'parameter'=>$parameter,'startDate'=>$start_date,'endDate'=>$end_date,'namelist'=>$namelist]);

        }else{
            $name = '历史任务列表';
            //  // 时间 公众号 成功关注 取关量 取关率
            $head['head'] = array('时间', '公众号', ' 成功关注', '取关量','取关率');
            self::export($name, $head, $data['data']);
        }



    }
    /**  获取子商户统计列表
     * @param Request $request
     */
    public function getSonTradeReport(Request $request){
//        $bussid = 227;
        $bussid = session()->get('buss_id');
        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;
        $channelname = isset($_REQUEST['subShop'])?$_REQUEST['subShop']:'';

        $start_date = isset($_REQUEST['start_date'])?$_REQUEST['start_date']:date('Y-m-d',strtotime('-7 day'));
        $end_date = isset($_REQUEST['end_date'])&&$_REQUEST['end_date']!=""?$_REQUEST['end_date']:date('Y-m-d',strtotime('-1 day'));
        $channelname = $channelname==0? '':$channelname;
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('bussid'=>$bussid,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$start_date,'end_date'=>$end_date,'excel'=>$excel,'wxname'=>$channelname);
        $data = HttpRequest::getApiServices('Buss','sonBussList','GET',$parameter);

        if($excel ==0){
            $count= isset($data['data']['count'])?$data['data']['count']:0;
            $paginator =self::pagslist($data, $count, $pagesize);
            $reportlist_arr = $paginator->toArray()['data']['data'];

            $namelist = isset($reportlist_arr['namelist'])&&count($reportlist_arr['namelist'])>0? $reportlist_arr['namelist']:null;

            return view('Business.sonTradeInfo',['Get'=>$_GET,'arr'=>$reportlist_arr,'paginator'=>$paginator,'parameter'=>$parameter,'start_date'=>$start_date,'end_date'=>$end_date,'namelist'=>$namelist]);
        }else{

            $name = '子商户统计报表';
            $head['head'] = array('子商户', '时间', ' 连接数', '带粉数	','取关数','取关率');
            self::export($name, $head, $data['data']);

        }

    }

    /**
     *  拒绝任务
     */
    public function refuseReport(){

//        $bussid = 227;
        $bussid = session()->get('buss_id');
        $orderid = isset($_REQUEST['orderid'])?$_REQUEST['orderid']:'';
        $parameter = array('orderid'=>$orderid,'bussid'=>$bussid);
        $data = HttpRequest::getApiServices('Buss','refuseReport','GET',$parameter);
        echo json_encode($data);

    }


}