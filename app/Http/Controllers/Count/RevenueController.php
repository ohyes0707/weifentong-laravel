<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/20
 * Time: 10:54
 */
namespace App\Http\Controllers\Count;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class RevenueController extends Controller{
    public function revenueCount_buss(){
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:0;
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $buss = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'buss'=>$buss);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueCount','GET',$parameter);
        if(isset($data['data']['data']) && !empty($data['data']['data'])){
            if(isset($data['data']['list']) && !empty($data['data']['list'])){
                foreach($data['data']['list'] as $k=>$v){
                    if(isset($v['list']) && !empty($v['list'])){
                        $data['data']['list'][$k]['count']['follow'] = 0;
                        $data['data']['list'][$k]['count']['float'] = 0;
                        $data['data']['list'][$k]['count']['cost'] = 0;
                        $data['data']['list'][$k]['count']['rest'] = 0;
                        foreach($v['list'] as $kk=>$vv){
                            $data['data']['list'][$k]['count']['follow'] += $vv['follow'];
                            $data['data']['list'][$k]['count']['float'] += $vv['float'];
                            $data['data']['list'][$k]['count']['cost'] += $vv['cost'];
                            $data['data']['list'][$k]['count']['rest'] += $vv['rest'];
                        }
                    }
                }
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['cost'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list'])){
                        foreach($v['list'] as $key=>$value){
                            $data['data']['data'][$k]['count']['follow'] += $value['follow'];
                            $data['data']['data'][$k]['count']['float'] += $value['float'];
                            $data['data']['data'][$k]['count']['cost'] += $value['cost'];
                            $data['data']['data'][$k]['count']['rest'] += $value['rest'];
                        }
                    }
                }
                if($excel == 1){
                    foreach($data['data']['data'] as $k=>$v){
                        $arr[] = array(
                            'buss'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['count']['follow'],
                            'float'=>$v['count']['float'],
                            'cost'=>$v['count']['cost'],
                            'real'=>$v['count']['float']-$v['count']['cost'],
                            'rest'=>$v['count']['rest'],
                        );
                        if(isset($v['list']) && !empty($v['list'])){
                            foreach($v['list'] as $kk=>$vv){
                                $arr[] = array(
                                    'buss'=>'',
                                    'date_time'=>$vv['date_time'],
                                    'follow'=>$vv['follow'],
                                    'float'=>$vv['float'],
                                    'cost'=>$vv['cost'],
                                    'real'=>$vv['float']-$vv['cost'],
                                    'rest'=>$vv['rest'],
                                );
                            }
                        }
                    }
                    $name = '营收统计渠道报表';
                    $head['head'] = array('渠道','时间','成功关注',' 流水','成本','实际利润','扣量利润');
                    self::export($name,$head,$arr);
                }
                return view('Operate.revenue_buss',['data'=>$data['data']['data'],'list'=>$data['data']['list'],'user'=>$user,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'buss'=>$data['data']['buss']]);
            }else{
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['cost'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $key=>$value){
                            $data['data']['data'][$k]['count']['follow'] += $value['follow'];
                            $data['data']['data'][$k]['count']['float'] += $value['float'];
                            $data['data']['data'][$k]['count']['cost'] += $value['cost'];
                            $data['data']['data'][$k]['count']['rest'] += $value['rest'];
                        }
                    }
                }
                $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
                $userlist = $setpage->toArray()['data'];
                if($excel == 1){
                    foreach($userlist as $k=>$v){
                        $arr[] = array(
                            'buss'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['count']['follow'],
                            'float'=>$v['count']['float'],
                            'cost'=>$v['count']['cost'],
                            'real'=>$v['count']['float']-$v['count']['cost'],
                            'rest'=>$v['count']['rest'],
                        );
                        if(isset($v['list']) && !empty($v['list'])){
                            foreach($v['list'] as $kk=>$vv){
                                $arr[] = array(
                                    'buss'=>'',
                                    'date_time'=>$vv['date_time'],
                                    'follow'=>$vv['follow'],
                                    'float'=>$vv['float'],
                                    'cost'=>$vv['cost'],
                                    'real'=>$vv['float']-$vv['cost'],
                                    'rest'=>$vv['rest'],
                                );
                            }
                        }
                    }
                    $name = '营收统计渠道报表';
                    $head['head'] = array('渠道','时间','成功关注',' 流水','成本','实际利润','扣量利润');
                    self::export($name,$head,$arr);
                }
                return view('Operate.revenue_buss',['data'=>$userlist,'paginator'=>$setpage,'user'=>$user,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'buss'=>$data['data']['buss']]);
            }
        }//,'buss'=>$data['data']['buss']
        return view('Operate.revenue_buss',['user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
    }
    public function revenueCount_bussOne(){
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $buss = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'buss'=>$buss);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueCount','GET',$parameter);
        if(isset($data['data']['data']) && !empty($data['data']['data'])){
            if(isset($data['data']['list']) && !empty($data['data']['list'])){
                foreach($data['data']['list'] as $k=>$v){
                    if(isset($v['list']) && !empty($v['list'])){
                        $data['data']['list'][$k]['count']['follow'] = 0;
                        $data['data']['list'][$k]['count']['float'] = 0;
                        $data['data']['list'][$k]['count']['cost'] = 0;
                        $data['data']['list'][$k]['count']['rest'] = 0;
                        foreach($v['list'] as $kk=>$vv){
                            $data['data']['list'][$k]['count']['follow'] += $vv['follow'];
                            $data['data']['list'][$k]['count']['float'] += $vv['float'];
                            $data['data']['list'][$k]['count']['cost'] += $vv['cost'];
                            $data['data']['list'][$k]['count']['rest'] += $vv['rest'];
                        }
                    }
                }
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['cost'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list'])){
                        foreach($v['list'] as $key=>$value){
                            $data['data']['data'][$k]['count']['follow'] += $value['follow'];
                            $data['data']['data'][$k]['count']['float'] += $value['float'];
                            $data['data']['data'][$k]['count']['cost'] += $value['cost'];
                            $data['data']['data'][$k]['count']['rest'] += $value['rest'];
                        }
                    }
                }
                if($excel == 1){
                    foreach($data['data']['data'] as $k=>$v){
                        $arr[] = array(
                            'buss'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['count']['follow'],
                            'float'=>$v['count']['float'],
                            'cost'=>$v['count']['cost'],
                            'real'=>$v['count']['float']-$v['count']['cost'],
                            'rest'=>$v['count']['rest'],
                        );
                        if(isset($v['list']) && !empty($v['list'])){
                            foreach($v['list'] as $kk=>$vv){
                                if($vv['follow'] > 0){
                                    $arr[] = array(
                                        'buss'=>'',
                                        'date_time'=>$vv['date_time'],
                                        'follow'=>$vv['follow'],
                                        'float'=>$vv['float'],
                                        'cost'=>$vv['cost'],
                                        'real'=>$vv['float']-$vv['cost'],
                                        'rest'=>$vv['rest'],
                                    );
                                }
                            }
                        }
                    }
                    foreach($data['data']['list'] as $k=>$v){
                        $arr[] = array(
                            'buss'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['count']['follow'],
                            'float'=>$v['count']['float'],
                            'cost'=>$v['count']['cost'],
                            'real'=>$v['count']['float']-$v['count']['cost'],
                            'rest'=>$v['count']['rest'],
                        );
                        if(isset($v['list']) && !empty($v['list'])){
                            foreach($v['list'] as $kk=>$vv){
                                if($vv['follow'] > 0){
                                    $arr[] = array(
                                        'buss'=>'',
                                        'date_time'=>$vv['date_time'],
                                        'follow'=>$vv['follow'],
                                        'float'=>$vv['float'],
                                        'cost'=>$vv['cost'],
                                        'real'=>$vv['float']-$vv['cost'],
                                        'rest'=>$vv['rest'],
                                    );
                                }
                            }
                        }
                    }
                    $name = '营收统计渠道报表';
                    $head['head'] = array('渠道','时间','成功关注',' 流水','成本','实际利润','扣量利润');
                    self::export($name,$head,$arr);
                }
                return view('Operate.revenue_bussOne',['data'=>$data['data']['data'],'list'=>$data['data']['list'],'user'=>$user,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'buss'=>$data['data']['buss']]);
            }else{
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['cost'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $key=>$value){
                            $data['data']['data'][$k]['count']['follow'] += $value['follow'];
                            $data['data']['data'][$k]['count']['float'] += $value['float'];
                            $data['data']['data'][$k]['count']['cost'] += $value['cost'];
                            $data['data']['data'][$k]['count']['rest'] += $value['rest'];
                        }
                    }
                }
                $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
                $userlist = $setpage->toArray()['data'];
                if($excel == 1){
                    echo 8;
                    echo "<pre>";
                    print_r($userlist);
                    echo "<pre/>";
                    exit();
                }
                return view('Operate.revenue_bussOne',['data'=>$userlist,'paginator'=>$setpage,'user'=>$user,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'buss'=>$data['data']['buss']]);
            }
        }
        return view('Operate.revenue_bussOne',['user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
    }
    /**
     * 营收渠道报表excel导出数据
     */
    public function revenueCount_bussExcel(){
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:'';
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:'';
        $buss = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        $parameter = array('user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'buss'=>$buss);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueCountExcel','GET',$parameter);
        if(isset($data['data']['data'])){
            if($buss && $excel == 1){
                foreach($data['data']['list'] as $k=>$v){
                    $data['data']['list'][$k]['count']['follow'] = 0;
                    $data['data']['list'][$k]['count']['float'] = 0;
                    $data['data']['list'][$k]['count']['cost'] = 0;
                    $data['data']['list'][$k]['count']['rest'] = 0;
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $data['data']['list'][$k]['count']['follow'] += $vv['follow'];
                            $data['data']['list'][$k]['count']['float'] += $vv['float'];
                            $data['data']['list'][$k]['count']['cost'] += $vv['cost'];
                            $data['data']['list'][$k]['count']['rest'] += $vv['rest'];
                        }
                    }
                }
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['cost'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list'])){
                        foreach($v['list'] as $key=>$value){
                            $data['data']['data'][$k]['count']['follow'] += $value['follow'];
                            $data['data']['data'][$k]['count']['float'] += $value['float'];
                            $data['data']['data'][$k]['count']['cost'] += $value['cost'];
                            $data['data']['data'][$k]['count']['rest'] += $value['rest'];
                        }
                    }
                }
                foreach($data['data']['data'] as $k=>$v){
                    $list[] = array(
                        'nick_name' => $v['nick_name'],
                        'date_time' => '',
                        'follow'=>$v['count']['follow'],
                        'float'=>$v['count']['float'],
                        'cost'=>$v['count']['cost'],
                        'real'=>$v['count']['float']-$v['count']['cost'],
                        'rest'=>$v['count']['rest'],
                    );
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $list[] = array(
                                'nick_name' => '',
                                'date_time' => $vv['date_time'],
                                'follow'=>$vv['follow'],
                                'float'=>$vv['float'],
                                'cost'=>$vv['cost'],
                                'real'=>$vv['float']-$vv['cost'],
                                'rest'=>$vv['rest'],
                            );
                        }
                    }
                }
                foreach($data['data']['list'] as $k=>$v){
                    $list[] = array(
                        'nick_name' => $v['nick_name'],
                        'date_time' => '',
                        'follow'=>$v['count']['follow'],
                        'float'=>$v['count']['float'],
                        'cost'=>$v['count']['cost'],
                        'real'=>$v['count']['float']-$v['count']['cost'],
                        'rest'=>$v['count']['rest'],
                    );
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $list[] = array(
                                'nick_name' => '',
                                'date_time' => $vv['date_time'],
                                'follow'=>$vv['follow'],
                                'float'=>$vv['float'],
                                'cost'=>$vv['cost'],
                                'real'=>$vv['float']-$vv['cost'],
                                'rest'=>$vv['rest'],
                            );
                        }
                    }
                }
            }else{
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['cost'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list'])){
                        foreach($v['list'] as $key=>$value){
                            $data['data']['data'][$k]['count']['follow'] += $value['follow'];
                            $data['data']['data'][$k]['count']['float'] += $value['float'];
                            $data['data']['data'][$k]['count']['cost'] += $value['cost'];
                            $data['data']['data'][$k]['count']['rest'] += $value['rest'];
                        }
                    }
                }
                foreach($data['data']['data'] as $k=>$v){
                    $list[] = array(
                        'nick_name'=>$v['nick_name'],
                        'date_time'=>'',
                        'follow'=>$v['count']['follow'],
                        'float'=>$v['count']['float'],
                        'cost'=>$v['count']['cost'],
                        'real'=>$v['count']['float']-$v['count']['cost'],
                        'rest'=>$v['count']['rest'],
                    );
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $list[] = array(
                                'nick_name'=>'',
                                'date_time'=>$vv['date_time'],
                                'follow'=>$vv['follow'],
                                'float'=>$vv['float'],
                                'cost'=>$vv['cost'],
                                'real'=>$vv['float']-$vv['cost'],
                                'rest'=>$vv['rest'],
                            );
                        }

                    }
                }
            }
            $name = '营收统计渠道报表';
            $head['head'] = array('渠道','时间','成功关注',' 流水','成本','实际利润','扣量利润');
            $arr = $list;
            self::export($name,$head,$arr);
        }else{
            return self::alert_back('数据为空');
        }
    }

    /**
     * 营收报表渠道查看详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function revenueDetail_buss(){
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $bid = isset($_REQUEST['bid'])?$_REQUEST['bid']:'';
        $wx_id = isset($_REQUEST['wx_id'])?$_REQUEST['wx_id']:'';
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel==1 || $wx_id){
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('bid'=>$bid,'start_date'=>$startDate,'end_date'=>$endDate,'page'=>$page,'pagesize'=>$pagesize,'wx_id'=>$wx_id);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueDetail_buss','GET',$parameter);
        if($data){
            if(isset($data['data']['data']) && !empty($data['data']['data'])){
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['real_follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $data['data']['data'][$k]['count']['follow'] += $vv['follow'];
                            $data['data']['data'][$k]['count']['real_follow'] += $vv['real_follow'];
                            $data['data']['data'][$k]['count']['float'] += $vv['float'];
                            $data['data']['data'][$k]['count']['rest'] += $vv['rest'];
                        }
                    }
                }
            }
            if($excel){
                foreach($data['data']['data'] as $k=>$v){
                    $list[] = array(
                        'wx_name'=>$v['wx_name'],
                        'date_time'=>'',
                        'follow'=>$v['count']['follow'],
                        'real_follow'=>$v['count']['real_follow'],
                        'float'=>$v['count']['float'],
//                        'rest'=>$v['count']['rest'],
                    );
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $list[] = array(
                                'wx_name'=>'',
                                'date_time'=>$vv['date_time'],
                                'follow'=>$vv['follow'],
                                'real_follow'=>$vv['real_follow'],
                                'float'=>$vv['float'],
//                                'rest'=>$vv['rest'],
                            );
                        }
                    }
                }
                $name = '营收统计渠道报表（公众号）';
                $head['head'] = array('公众号','时间','成功关注','实际关注',' 流水');
                self::export($name,$head,$list);
            }
            if($wx_id){
                $setpage = array();
                $userlist = $data['data']['data'];
            }else{
                $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
                $userlist = $setpage->toArray()['data'];
            }
            return view('Operate.revenueDetail_buss',['data'=>$userlist,'paginator'=>$setpage,'wx_id'=>$wx_id,'wx_name'=>$data['data']['wx_name'],'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST,'bid'=>$bid]);
        }
        return view('Operate.revenueDetail_buss',['wx_id'=>$wx_id,'wx_name'=>$data['data']['wx_name'],'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST,'bid'=>$bid]);
    }

    public function revenueCount_wechat(){
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $bid = isset($_GET['bid'])?$_GET['bid']:'';
        $wx_id = isset($_REQUEST['wx_id'])?$_REQUEST['wx_id']:'';
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel==1){
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('bid'=>$bid,'start_date'=>$startDate,'end_date'=>$endDate,'page'=>$page,'pagesize'=>$pagesize,'wx_id'=>$wx_id);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueDetail_buss','GET',$parameter);
        if($data){
            if(isset($data['data']['data']) && !empty($data['data']['data'])){
                foreach($data['data']['data'] as $k=>$v){
                    $data['data']['data'][$k]['count']['follow'] = 0;
                    $data['data']['data'][$k]['count']['real_follow'] = 0;
                    $data['data']['data'][$k]['count']['float'] = 0;
                    $data['data']['data'][$k]['count']['rest'] = 0;
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $data['data']['data'][$k]['count']['follow'] += $vv['follow'];
                            $data['data']['data'][$k]['count']['real_follow'] += $vv['real_follow'];
                            $data['data']['data'][$k]['count']['float'] += $vv['float'];
                            $data['data']['data'][$k]['count']['rest'] += $vv['rest'];
                        }
                    }
                }
                if($wx_id){
                    $setpage = array();
                    $userlist = $data['data']['data'];
                }else{
                    $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
                    $userlist = $setpage->toArray()['data'];
                }
                if($excel){
                    foreach($data['data']['data'] as $k=>$v){
                        if($wx_id){
                            if($v['o_wx_id'] == $wx_id){
                                $list[] = array(
                                    'wx_name'=>$v['wx_name'],
                                    'date_time'=>'',
                                    'follow'=>$v['count']['follow'],
                                    'real_follow'=>$v['count']['real_follow'],
                                    'float'=>$v['count']['float'],
                                );
                                if(isset($v['list']) && !empty($v['list'])){
                                    foreach($v['list'] as $kk=>$vv){
                                        $list[] = array(
                                            'wx_name'=>'',
                                            'date_time'=>$vv['date_time'],
                                            'follow'=>$vv['follow'],
                                            'real_follow'=>$vv['real_follow'],
                                            'float'=>$vv['float'],
                                        );
                                    }
                                }
                            }
                        }else{
                            $list[] = array(
                                'wx_name'=>$v['wx_name'],
                                'date_time'=>'',
                                'follow'=>$v['count']['follow'],
                                'real_follow'=>$v['count']['real_follow'],
                                'float'=>$v['count']['float'],
                            );
                            if(isset($v['list']) && !empty($v['list'])){
                                foreach($v['list'] as $kk=>$vv){
                                    $list[] = array(
                                        'wx_name'=>'',
                                        'date_time'=>$vv['date_time'],
                                        'follow'=>$vv['follow'],
                                        'real_follow'=>$vv['real_follow'],
                                        'float'=>$vv['float'],
                                    );
                                }
                            }
                        }
                    }
                    $name = '营收统计公众号报表';
                    $head['head'] = array('公众号','时间','成功关注','实际关注',' 流水');
                    self::export($name,$head,$list);
                }
                return view('Operate.revenue_wechat',['data'=>$userlist,'paginator'=>$setpage,'wx_id'=>$wx_id,'wx_name'=>$data['data']['wx_name'],'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST,'bid'=>$bid]);

            }
        }
        return view('Operate.revenue_wechat',['wx_id'=>$wx_id,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST,'bid'=>$bid]);
    }

    public function revenueDetail_wechat(){
        $wid = isset($_REQUEST['wid'])?$_REQUEST['wid']:'';
        $wx_name = isset($_REQUEST['wx_name'])?$_REQUEST['wx_name']:'';
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $bid = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel==1){
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('wid'=>$wid,'page'=>$page,'pagesize'=>$pagesize,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'bid'=>$bid);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueDetail_wechat','GET',$parameter);
        if($data && isset($data['data']['data'])){
            foreach($data['data']['data'] as $k=>$v){
                $data['data']['data'][$k]['count']['follow'] = 0;
                $data['data']['data'][$k]['count']['float'] = 0;
                $data['data']['data'][$k]['count']['cost'] = 0;
                $data['data']['data'][$k]['count']['rest'] = 0;
                if(isset($v['list']) && !empty($v['list'])){
                    foreach($v['list'] as $kk=>$vv){
                        $data['data']['data'][$k]['count']['follow'] += $vv['follow'];
                        $data['data']['data'][$k]['count']['float'] += $vv['float'];
                        $data['data']['data'][$k]['count']['cost'] += $vv['cost'];
                        $data['data']['data'][$k]['count']['rest'] += $vv['rest'];
                    }
                }
            }
            $list = array();
            if($excel == 1){
                foreach($data['data']['data'] as $k=>$v){
                    if($v['count']['follow'] > 0){
                        $arr[] = array(
                            'nick_name'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['count']['follow'],
                            'float'=>$v['count']['float'],
                            'cost'=>$v['count']['cost'],
                            'real'=>$v['count']['float']-$v['count']['cost'],
                            'rest'=>$v['count']['rest'],
                        );
                        if(isset($v['list']) && !empty($v['list'])){
                            foreach($v['list'] as $kk=>$vv){
                                $arr[] = array(
                                    'nick_name'=>'',
                                    'date_time'=>$vv['date_time'],
                                    'follow'=>$vv['follow'],
                                    'float'=>$vv['float'],
                                    'cost'=>$vv['cost'],
                                    'real'=>$vv['float']-$vv['cost'],
                                    'rest'=>$vv['rest'],
                                );
                            }
                        }
                    }

                }
                $name = '营收统计公众号报表';
                $head['head'] = array('渠道','时间','成功关注','成本',' 流水','实际利润','扣量利润');
                self::export($name,$head,$arr);
            }
            $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
            $userlist = $setpage->toArray()['data'];
            return view('Operate.revenueDetail_wechat',['data'=>$userlist,'paginator'=>$setpage,'list'=>$list,'buss'=>$data['data']['buss'],'user'=>$user,'wid'=>$wid,'wx_name'=>$wx_name,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'bid'=>$bid]);
        }
        return view('Operate.revenueDetail_wechat',['user'=>$user,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'bid'=>$bid,'wid'=>$wid,'wx_name'=>$wx_name]);
     }
    public function revenueDetail_wechatOne(){
        $wid = isset($_REQUEST['wid'])?$_REQUEST['wid']:'';
        $wx_name = isset($_REQUEST['wx_name'])?$_REQUEST['wx_name']:'';
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $bid = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel==1){
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('wid'=>$wid,'page'=>$page,'pagesize'=>$pagesize,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'bid'=>$bid);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueDetail_wechatOne','GET',$parameter);
        if($data && isset($data['data']['data'])){
            foreach($data['data']['data'] as $k=>$v){
                $data['data']['data'][$k]['count']['follow'] = 0;
                $data['data']['data'][$k]['count']['float'] = 0;
                $data['data']['data'][$k]['count']['cost'] = 0;
                $data['data']['data'][$k]['count']['rest'] = 0;
                if(isset($v['list']) && !empty($v['list'])){
                    foreach($v['list'] as $kk=>$vv){
                        $data['data']['data'][$k]['count']['follow'] += $vv['follow'];
                        $data['data']['data'][$k]['count']['float'] += $vv['float'];
                        $data['data']['data'][$k]['count']['cost'] += $vv['cost'];
                        $data['data']['data'][$k]['count']['rest'] += $vv['rest'];
                    }
                }
            }
            if(isset($data['data']['list'])){
                foreach($data['data']['list'] as $k=>$v){
                    $data['data']['list'][$k]['count']['follow'] = 0;
                    $data['data']['list'][$k]['count']['float'] = 0;
                    $data['data']['list'][$k]['count']['cost'] = 0;
                    $data['data']['list'][$k]['count']['rest'] = 0;
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $data['data']['list'][$k]['count']['follow'] += $vv['follow'];
                            $data['data']['list'][$k]['count']['float'] += $vv['float'];
                            $data['data']['list'][$k]['count']['cost'] += $vv['cost'];
                            $data['data']['list'][$k]['count']['rest'] += $vv['rest'];
                        }
                    }
                }
                $list = $data['data']['list'];
            }else{
                $list = array();
            }
            if($excel == 1){
                foreach($data['data']['data'] as $k=>$v){
                    $arr[] = array(
                        'nick_name'=>$v['nick_name'],
                        'date_time'=>'',
                        'follow'=>$v['count']['follow'],
                        'float'=>$v['count']['float'],
                        'cost'=>$v['count']['cost'],
                        'real'=>$v['count']['float']-$v['count']['cost'],
                        'rest'=>$v['count']['rest'],
                    );
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $arr[] = array(
                                'nick_name'=>'',
                                'date_time'=>$vv['date_time'],
                                'follow'=>$vv['follow'],
                                'float'=>$vv['float'],
                                'cost'=>$vv['cost'],
                                'real'=>$vv['float']-$vv['cost'],
                                'rest'=>$vv['rest'],
                            );
                        }
                    }
                }
                if(!empty($list)){
                    foreach($list as $k=>$v){
                        $arr[] = array(
                            'nick_name'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['count']['follow'],
                            'float'=>$v['count']['float'],
                            'cost'=>$v['count']['cost'],
                            'real'=>$v['count']['float']-$v['count']['cost'],
                            'rest'=>$v['count']['rest'],
                        );
                        if(isset($v['list']) && !empty($v['list'])){
                            foreach($v['list'] as $kk=>$vv){
                                $arr[] = array(
                                    'nick_name'=>'',
                                    'date_time'=>$vv['date_time'],
                                    'follow'=>$vv['follow'],
                                    'float'=>$vv['float'],
                                    'cost'=>$vv['cost'],
                                    'real'=>$vv['float']-$vv['cost'],
                                    'rest'=>$vv['rest'],
                                );
                            }
                        }
                    }
                }
                $name = '营收统计公众号报表';
                $head['head'] = array('渠道','时间','成功关注',' 流水','成本','实际利润','扣量利润');
                self::export($name,$head,$arr);
            }
            $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
            $userlist = $setpage->toArray()['data'];
            return view('Operate.revenueDetail_wechatOne',['data'=>$userlist,'paginator'=>$setpage,'list'=>$list,'buss'=>$data['data']['buss'],'user'=>$user,'wid'=>$wid,'wx_name'=>$wx_name,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'bid'=>$bid]);
        }
        return view('Operate.revenueDetail_wechatOne',['user'=>$user,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'bid'=>$bid,'wid'=>$wid,'wx_name'=>$wx_name]);
    }

    public function revenueCount_plat(){
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        if($excel==1){
            $newpage= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $newpagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $newpage= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $newpagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $buss = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'buss'=>$buss,'newpage'=>$newpage,'newpagesize'=>$newpagesize);
        $data = HttpRequest::getApiServices('Count/RevenueSummary','revenueCount','GET',$parameter);
        if($data && isset($data['data']['data'])){
            if(isset($data['data']['date'])){
                foreach($data['data']['date'] as $k=>$v){
                    $arr[$v['date_time']] = array(
                        'follow'=>0,
                        'float'=>0,
                        'cost'=>0,
                        'rest'=>0,
                    );
                }
            }
            foreach($data['data']['data'] as $k=>$v){
                if(isset($v['list']) && !empty($v['list'])){
                    foreach($v['list'] as $kk=>$vv){
                        if(isset($arr[$vv['date_time']])){
                            $arr[$vv['date_time']]['follow'] += $vv['follow'];
                            $arr[$vv['date_time']]['float'] += $vv['float'];
                            $arr[$vv['date_time']]['cost'] += $vv['cost'];
                            $arr[$vv['date_time']]['rest'] += $vv['rest'];
                        }
                    }
                }
            }
            if($excel == 1) {
                foreach($arr as $k=>$v){
                    $excel_arr[] = array(
                        'date_time' => $k,
                        'follow' => $v['follow'],
                        'float' => $v['float'],
                        'cost' => $v['cost'],
                        'real' => $v['float']-$v['cost'],
                        'rest' => $v['rest'],
                    );
                }
                $name = '营收统计平台报表';
                $head['head'] = array('日期','成功关注',' 流水','成本','实际利润','扣量利润');
                self::export($name,$head,$excel_arr);
            }
            $num = $data['data']['num'];
            if(isset($data['data']['plat_num']) && !empty($data['data']['plat_num'])){
                $num = $data['data']['plat_num'];
            }

            $setpage=  self::pagslist($arr, $num, $newpagesize);
            $userlist = $setpage->toArray()['data'];
            return view('Operate.revenue_plat',['data'=>$userlist,'paginator'=>$setpage,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'user'=>$user]);
        }
        return view('Operate.revenue_plat',['post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'user'=>$user]);
    }
}
