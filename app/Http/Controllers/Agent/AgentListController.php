<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/10/20
 * Time: 15:07
 */
namespace App\Http\Controllers\Agent;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class AgentListController extends Controller{
    /**
     * 运营系统代理列表
     */
    public function agentList(){
        $agency = isset($_REQUEST['agency'])?$_REQUEST['agency']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'sale'=>$agency);
        $data = HttpRequest::getApiServices('Agent/AgentListController','getAgentList','GET',$parameter);
        if($data['data']){
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $list = $paginator->toArray()['data'];
            return view('Operate.Agent.agencyList',['list'=>$list,'paginator'=>$paginator,'page'=>$page,'agency'=>$agency]);
        }
        return view('Operate.Agent.agencyList',['page'=>$page]);
    }
    /**
     * 运营系统代理编辑
     */
    public function agentEdit(){
        if($_POST){
            $data = HttpRequest::getApiServices('Operate/SaleController','saleEdit','GET',$_POST);
            if($data['data']){
                return self::alert_back('修改成功');
            }else{
                return self::alert_back('修改失败');
            }
        }else{
            $uid = isset($_GET['uid'])?$_GET['uid']:'';
            $parameter = array('uid'=>$uid);
            $data = HttpRequest::getApiServices('Operate/SaleController','saleEdit','GET',$parameter);
            if($data['data']){
                return view('Operate.Agent.editAgency',['list'=>$data['data']]);
            }
            return view('Operate.Agent.editAgency');
        }
    }
    /**
     * 运营系统代理列表-子代理
     */
    public function subAgent(){
        $uname = isset($_GET['uname'])?$_GET['uname']:'';
        $uid = isset($_GET['uid'])?$_GET['uid']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'uid'=>$uid);
        $data = HttpRequest::getApiServices('Agent/AgentListController','subAgent','GET',$parameter);
        if($data['data']){
            return view('Operate.Agent.agencyOfSub',['list'=>$data['data']['data'],'uname'=>$uname]);
        }else{
            return view('Operate.Agent.agencyOfSub');
        }
    }

    /**
     * 运营系统代理报表
     */
    public function agentForm(){
        $uname = isset($_GET['uname'])?$_GET['uname']:'';
        $uid = isset($_GET['uid'])?$_GET['uid']:'';
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $excel = isset($_REQUEST['excels'])?$_REQUEST['excels']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('uid'=>$uid,'start_date'=>$startDate,'end_date'=>$endDate,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/SaleController','saleForm','GET',$parameter);
        if($data['data']){
            $newpagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
            $parameter = array('uid'=>$uid,'start_date'=>$startDate,'end_date'=>$endDate,'page'=>$page,'pagesize'=>$newpagesize);
            $data_all = HttpRequest::getApiServices('Operate/SaleController','saleForm','GET',$parameter);
            $total = array(
                'date_time'=>'汇总',
                'follow'=>0,
                'unfollow'=>0,
                'cost'=>0
            );
            foreach($data_all['data']['data'] as $k=>$v){
                $total['follow'] += $v['follow'];
                $total['unfollow'] += $v['unfollow'];
                $total['cost'] += $v['cost'];
            }
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $pagelist = $paginator->toArray()['data'];
            $list['total'] = $total;
            $list += $pagelist;
            if($excel == 1){
                foreach($list as $k=>$v){
                    $un_per = '0.00%';
                    if($v['follow'] != 0)
                        $un_per = sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%';
                    $arr[] = array(
                        'date_time'=>$v['date_time'],
                        'follow'=>$v['follow'],
                        'unfollow'=>$v['unfollow'],
                        'un_per'=>$un_per,
                        'cost'=>$v['cost']
                    );
                }
                $name = '销售报表';
                $head['head'] = array('日期','成功关注','取关数','取关率','销售额');
                self::export($name,$head,$arr);
            }
            return view('Operate.Agent.agencyReport',['list'=>$list,'paginator'=>$paginator,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'uid'=>$uid,'uname'=>$uname]);
        }
        return view('Operate.Agent.agencyReport',['startDate'=>$startDate,'endDate'=>$endDate,'uid'=>$uid,'uname'=>$uname]);
    }
    /**
     * 代理系统销售统计
     */
    public function agentSale(){
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $end_date = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $wx_name = isset($_REQUEST['gzh'])?$_REQUEST['gzh']:'';
        $uid = session()->get('userid');
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $follow = 0;$unfollow = 0;$money = 0;$price = 0;
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'uid'=>$uid,'start_date'=>$start_date,'end_date'=>$end_date,'wx_name'=>$wx_name);
        $data = HttpRequest::getApiServices('Agent/AgentListController','agentSale','GET',$parameter);
        if($data['data']){
            $pagesizenew= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
            $parameter = array('page'=>$page,'pagesize'=>$pagesizenew,'uid'=>$uid,'start_date'=>$start_date,'end_date'=>$end_date,'wx_name'=>'');
            $data_total = HttpRequest::getApiServices('Agent/AgentListController','agentSale','GET',$parameter);
            $i = 1;
            $wx_list = array();
            foreach($data_total['data']['data'] as $k=>$v){
                if(isset($v['data']) && !empty($v['data'])){
                    $i += 1;
                    $wx_list[] = $v['wx_name'];
                    $price += $v['price'];
                }
                if(isset($v['data']) && !empty($v['data'])){
                    foreach($v['data'] as $kk=>$vv){
                        $follow += $vv['follow'];
                        $unfollow += $vv['unfollow'];
                        $money += $vv['money'];
                    }
                }
            }
            $avg_price = sprintf('%.2f',$price/$i);
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $list = $paginator->toArray()['data'];
            foreach($list as $k=>$v){
                $list[$k]['follow'] = 0;
                $list[$k]['unfollow'] = 0;
                $list[$k]['money'] = 0;
                if(isset($v['data']) && !empty($v['data'])){
                    foreach($v['data'] as $kk=>$vv){
                        $list[$k]['follow'] += $vv['follow'];
                        $list[$k]['unfollow'] += $vv['unfollow'];
                        $list[$k]['money'] += $vv['money'];
                    }
                }
            }
            if($excel == 1){
                $follow = 0;$unfollow = 0;$money = 0;$price = 0;
                $i = 0;
                foreach($list as $k=>$v){
                    if(isset($v['data']) && !empty($v['data'])){
                        $i += 1;
                        $wx_list[] = $v['wx_name'];
                        $price += $v['price'];
                    }
                    if(isset($v['data']) && !empty($v['data'])){
                        foreach($v['data'] as $kk=>$vv){
                            $follow += $vv['follow'];
                            $unfollow += $vv['unfollow'];
                            $money += $vv['money'];
                        }
                    }
                }
                $avg_price = sprintf('%.2f',$price/$i);
                $arr[] = array(
                    'wx_name'=>'总计',
                    'date_time'=>'',
                    'follow'=>$follow,
                    'unfollow'=>$unfollow,
                    'qg_per'=>$follow==0?'0.00%':sprintf('%.2f',$unfollow/$follow*100).'%',
                    'price'=>$avg_price,
                    'money'=>$money
                );
                foreach($list as $k=>$v){
                    if(isset($v['data']) && !empty($v['data'])){
                        $arr[] = array(
                            'wx_name'=>$v['wx_name'],
                            'date_time'=>'',
                            'follow'=>$v['follow'],
                            'unfollow'=>$v['unfollow'],
                            'qg_per'=>$v['follow']==0?'0.00%':sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%',
                            'price'=>sprintf('%.2f',$v['price']),
                            'money'=>$v['money']
                        );
                        foreach($v['data'] as $kk=>$vv){
                            $arr[] = array(
                                'wx_name'=>'',
                                'date_time'=>$vv['date_time'],
                                'follow'=>$vv['follow'],
                                'unfollow'=>$vv['unfollow'],
                                'qg_per'=>$vv['follow']==0?'0.00%':sprintf('%.2f',$vv['unfollow']/$vv['follow']*100).'%',
                                'price'=>sprintf('%.2f',$vv['price']),
                                'money'=>$vv['money']
                            );
                        }
                    }
                }
                $name = '销售统计';
                $head['head'] = array('公众号','日期','成功关注','取关数','取关率','平均单价','销售额');
                self::export($name,$head,$arr);
            }
            return view('Agent.sales',['list'=>$list,'paginator'=>$paginator,'follow'=>$follow,'unfollow'=>$unfollow,'avg_price'=>$avg_price,'money'=>$money,'start_date'=>$start_date,'end_date'=>$end_date,'wx_list'=>$wx_list,'post'=>$_REQUEST]);
        }
        return view('Agent.sales',['follow'=>$follow,'unfollow'=>$unfollow,'money'=>$money,'start_date'=>$start_date,'end_date'=>$end_date,'post'=>$_REQUEST]);
    }
}