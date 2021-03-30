<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/10
 * Time: 13:51
 */
namespace App\Http\Controllers\Count;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class BussController extends Controller{
    /**
     *渠道报表数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bussCount(){
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel == 1){
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $status = isset($_REQUEST['status'])?$_REQUEST['status']:1;
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-1days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $buss = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
        $paramater = array('page'=>$page,'pagesize'=>$pagesize,'status'=>$status,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'buss'=>$buss);
        $data = HttpRequest::getApiServices('Count/BussSummary','bussCount','GET',$paramater);
        if(isset($data['data']['data'])){
            $setpage=  self::pagslist($data['data']['data'], $data['data']['num'], $pagesize);
            $userlist = $setpage->toArray()['data'];
            foreach($userlist as $k=>$v){
                $father[$k] = array(
                    'nick_name'=>$v['nick_name'],
                    'sumgetwx'=>$v['count']['sumgetwx'],
                    'getwx'=>$v['count']['getwx'],
                    'complet'=>$v['count']['complet'],
                    'follow'=>$v['count']['follow'],
                    'end'=>$v['count']['end'],
                    'buss_id'=>$v['id'],
                );
                if(isset($v[$v['username']]) && !empty($v[$v['username']])){
                    foreach($v[$v['username']] as $kk=>$vv){
                        $father[$k]['sumgetwx'] += $vv['count']['sumgetwx'];
                        $father[$k]['getwx'] += $vv['count']['getwx'];
                        $father[$k]['complet'] += $vv['count']['complet'];
                        $father[$k]['follow'] += $vv['count']['follow'];
                        $father[$k]['end'] += $vv['count']['end'];
                    }
                }
            }
            foreach($userlist as $k=>$v){
                $child[] = array(
                    'nick_name'=>$v['nick_name'],
                    'sumgetwx'=>$v['count']['sumgetwx'],
                    'getwx'=>$v['count']['getwx'],
                    'complet'=>$v['count']['complet'],
                    'follow'=>$v['count']['follow'],
                    'end'=>$v['count']['end'],
                    'pbid'=>$v['id'],
                    'buss_id'=>$v['id'],
                );
                if(isset($v[$v['username']]) && !empty($v[$v['username']])){
                    foreach($v[$v['username']] as $kk=>$vv){
                        $child[] = array(
                            'nick_name'=>$vv['nick_name'],
                            'sumgetwx'=>$vv['count']['sumgetwx'],
                            'getwx'=>$vv['count']['getwx'],
                            'complet'=>$vv['count']['complet'],
                            'follow'=>$vv['count']['follow'],
                            'end'=>$vv['count']['end'],
                            'pbid'=>$vv['pbid'],
                            'buss_id'=>$vv['id'],
                        );
                        unset($userlist[$k][$v['username']][$kk]);
                    }
                }
            }
            if(isset($father) && !empty($father)){
                foreach($father as $k=>$v){
                    foreach($child as $kk=>$vv){
                        if($v['buss_id'] == $vv['pbid']){
                            $father[$k]['child'][] = $vv;
                            unset($child[$kk]);
                        }
                    }
                }
            }else{
                $father = array();
            }
            if($excel == 1){
                if(!empty($father)){
                    foreach($father as $k=>$v){
                            $tc_per = '0.00%';
                            $rz_per = '0.00%';
                            $gz_per = '0.00%';
                            if($v['sumgetwx'] != 0)
                                $tc_per = sprintf('%.2f',$v['getwx']/$v['sumgetwx']*100).'%';
                            if($v['getwx'] != 0)
                                $rz_per = sprintf('%.2f',$v['complet']/$v['getwx']*100).'%';
                            if($v['complet'] != 0)
                                $gz_per = sprintf('%.2f',$v['follow']/$v['complet']*100).'%';
                            $arr[] = array(
                                'nick_name'=>$v['nick_name'],
                                'sumgetwx'=>$v['sumgetwx'],
                                'getwx'=>$v['getwx'],
                                'tc_per'=>$tc_per,
                                'complet'=>$v['complet'],
                                'rz_per'=>$rz_per,
                                'follow'=>$v['follow'],
                                'gz_per'=>$gz_per,
                                'end'=>$v['end'],
                            );
                            if(isset($v['child']) && !empty($v['child'])){
                                foreach($v['child'] as $kk=>$vv){
                                    $tc_per = '0.00%';
                                    $rz_per = '0.00%';
                                    $gz_per = '0.00%';
                                if($vv['sumgetwx'] != 0){
                                    if($vv['sumgetwx'] != 0)
                                        $tc_per = sprintf('%.2f',$vv['getwx']/$vv['sumgetwx']*100).'%';
                                    if($vv['getwx'] != 0)
                                        $rz_per = sprintf('%.2f',$vv['complet']/$vv['getwx']*100).'%';
                                    if($vv['complet'] != 0)
                                        $gz_per = sprintf('%.2f',$vv['follow']/$vv['complet']*100).'%';
                                    $arr[] = array(
                                        'nick_name'=>$vv['nick_name'],
                                        'sumgetwx'=>$vv['sumgetwx'],
                                        'getwx'=>$vv['getwx'],
                                        'tc_per'=>$tc_per,
                                        'complet'=>$vv['complet'],
                                        'rz_per'=>$rz_per,
                                        'follow'=>$vv['follow'],
                                        'gz_per'=>$gz_per,
                                        'end'=>$vv['end'],
                                    );
                                }
                            }
                        }
                    }
                }
                $name = '渠道统计报表';
                $head['head'] = array('渠道名称','获取公众号',' 成功获取公众号','填充率','微信认证','认证率','成功关注','关注率','点击完成');
                self::export($name,$head,$arr);
            }
            return view('Operate.channelStatistics',['list'=>$father,'paginator'=>$setpage,'buss'=>$data['data']['buss'],'status'=>$status,'user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
        }
        return view('Operate.channelStatistics',['status'=>$status,'startDate'=>$startDate,'endDate'=>$endDate,'user'=>$user]);
    }

    public function bussCount_detail(){
        $child = isset($_REQUEST['child'])?$_REQUEST['child']:'';
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel==1){
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:9;
        }
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $buss = isset($_REQUEST['bid'])?$_REQUEST['bid']:'';
        $paramater = array('page'=>$page,'pagesize'=>$pagesize,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate,'buss'=>$buss,'child'=>$child);
        $data = HttpRequest::getApiServices('Count/BussSummary','bussCount_detail','GET',$paramater);
        $tc_per = '0.00%';
        $rz_per = '0.00%';
        $gz_per = '0.00%';
        if($data['data']){
            if(isset($data['data']['father'])){
                $count = $data['data']['count'];
                unset($data['data']['count']);
                $father = $data['data']['father'];
                if(!empty($father['data'])){
                    foreach($father['data'] as $k=>$v){
                        if($v['sumgetwx'] != 0)
                            $tc_per = sprintf('%.2f',$v['getwx']/$v['sumgetwx']*100).'%';
                        if($v['getwx'] != 0)
                            $rz_per = sprintf('%.2f',$v['complet']/$v['getwx']*100).'%';
                        if($v['complet'] != 0)
                            $gz_per = sprintf('%.2f',$v['follow']/$v['complet']*100).'%';
                        $father['data'][$k]['tc_per'] = $tc_per;
                        $father['data'][$k]['rz_per'] = $rz_per;
                        $father['data'][$k]['gz_per'] = $gz_per;
                    }
                }
                $list['father'] = $father;
                unset($data['data']['father']);
                foreach($data['data'] as $k=>$v){
                    $list[$v['id']] = array(
                        'id'=>$v['id'],
                        'nick_name'=>$v['nick_name'],
                        'pbid'=>$v['pbid'],
                    );
                    if(isset($v['data']) && !empty($v['data'])){
                        foreach($v['data'] as $kk=>$vv){
                            if($vv['sumgetwx'] != 0)
                                $tc_per = sprintf('%.2f',$vv['getwx']/$vv['sumgetwx']*100).'%';
                            if($vv['getwx'] != 0)
                                $rz_per = sprintf('%.2f',$vv['complet']/$vv['getwx']*100).'%';
                            if($vv['complet'] != 0)
                                $gz_per = sprintf('%.2f',$vv['follow']/$vv['complet']*100).'%';
                            $list[$v['id']]['data'][$kk] = array(
                                'buss_id'=>$vv['bid'],
                                'date_time'=>$vv['date_time'],
                                'sumgetwx'=>$vv['sumgetwx'],
                                'getwx'=>$vv['getwx'],
                                'tc_per'=>$tc_per,
                                'complet'=>$vv['complet'],
                                'rz_per'=>$rz_per,
                                'follow'=>$vv['follow'],
                                'gz_per'=>$gz_per,
                                'end'=>$vv['end'],
                            );
                        }
                    }
                }
                $setpage=  self::pagslist($list, $count, $pagesize);
                $userlist = $setpage->toArray()['data'];
                foreach($userlist as $k=>$v){
                    $userlist[$k]['sumgetwx'] = 0;
                    $userlist[$k]['getwx'] = 0;
                    $userlist[$k]['complet'] = 0;
                    $userlist[$k]['follow'] = 0;
                    $userlist[$k]['end'] = 0;
                    $userlist[$k]['tc_per'] = '0.00%';
                    $userlist[$k]['rz_per'] = '0.00%';
                    $userlist[$k]['gz_per'] = '0.00%';
                    if(isset($v['data']) && !empty($v['data'])){
                        foreach($v['data'] as $kk=>$vv){
                            $userlist[$k]['sumgetwx'] += $vv['sumgetwx'];
                            $userlist[$k]['getwx'] += $vv['getwx'];
                            $userlist[$k]['complet'] += $vv['complet'];
                            $userlist[$k]['follow'] += $vv['follow'];
                            $userlist[$k]['end'] += $vv['end'];
                        }
                        if($userlist[$k]['sumgetwx'] != 0)
                            $tc_per = sprintf('%.2f',$userlist[$k]['getwx']/$userlist[$k]['sumgetwx']*100).'%';
                        if($userlist[$k]['getwx'] != 0)
                            $rz_per = sprintf('%.2f',$userlist[$k]['complet']/$userlist[$k]['getwx']*100).'%';
                        if($userlist[$k]['complet'] != 0)
                            $gz_per = sprintf('%.2f',$userlist[$k]['follow']/$userlist[$k]['complet']*100).'%';

                        $userlist[$k]['tc_per'] = $tc_per;
                        $userlist[$k]['rz_per'] = $rz_per;
                        $userlist[$k]['gz_per'] = $gz_per;
                    }
                }
                if($excel == 1){
                    foreach($userlist as $k=>$v){
                        $arr[] = array(
                            'nick_name'=>$v['nick_name'],
                            'date_time'=>'',
                            'sumgetwx'=>$v['sumgetwx'],
                            'getwx'=>$v['getwx'],
                            'complet'=>$v['complet'],
                            'follow'=>$v['follow'],
                            'end'=>$v['end'],
                            'tc_per'=>$v['tc_per'],
                            'rz_per'=>$v['rz_per'],
                            'gz_per'=>$v['gz_per'],
                        );
                        if(isset($v['data']) && !empty($v['data'])){
                            foreach($v['data'] as $kk=>$vv){
                                $arr[] = array(
                                    'nick_name'=>'',
                                    'date_time'=>$vv['date_time'],
                                    'sumgetwx'=>$vv['sumgetwx'],
                                    'getwx'=>$vv['getwx'],
                                    'complet'=>$vv['complet'],
                                    'follow'=>$vv['follow'],
                                    'end'=>$vv['end'],
                                    'tc_per'=>$vv['tc_per'],
                                    'rz_per'=>$vv['rz_per'],
                                    'gz_per'=>$vv['gz_per'],
                                );
                            }
                        }
                    }
                    $name = '渠道统计报表';
                    $head['head'] = array('渠道名称','日期','获取公众号',' 成功获取公众号','填充率','微信认证','认证率','成功关注','关注率','点击完成');
                    self::export($name,$head,$arr);
                }
                return view('Operate.channelStatistics_detail',['list'=>$userlist,'paginator'=>$setpage,'user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
            }else{
                if(isset($data['data']['count'])){
                    $count = $data['data']['count'];
                    unset($data['data']['count']);
                }else{
                    $count = 0;
                }
                $sumgetwx = 0;
                $getwx = 0;
                $complet = 0;
                $follow = 0;
                $end = 0;
                $data_list[] = array(
                    'id'=>$data['data']['id'],
                    'nick_name'=>$data['data']['nick_name'],
                    'date_time'=>'',
                );
                if(isset($data['data']['data']) && !empty($data['data']['data'])){
                    foreach($data['data']['data'] as $k=>$v){
                        $sumgetwx += $v['sumgetwx'];
                        $getwx += $v['getwx'];
                        $complet += $v['complet'];
                        $follow += $v['follow'];
                        $end += $v['end'];
                        if($v['sumgetwx'] !=0 )
                            $tc_per = sprintf('%.2f',$v['getwx']/$v['sumgetwx']*100).'%';
                        if($v['getwx'] !=0 )
                            $rz_per = sprintf('%.2f',$v['complet']/$v['getwx']*100).'%';
                        if($v['complet'] !=0 )
                            $gz_per = sprintf('%.2f',$v['follow']/$v['complet']*100).'%';
                        $data_list[] = array(
                            'id'=>$v['bid'],
                            'nick_name'=>'',
                            'date_time'=>$v['date_time'],
                            'sumgetwx'=>$v['sumgetwx'],
                            'getwx'=>$v['getwx'],
                            'complet'=>$v['complet'],
                            'follow'=>$v['follow'],
                            'end'=>$v['end'],
                            'tc_per'=>$tc_per,
                            'rz_per'=>$rz_per,
                            'gz_per'=>$gz_per,
                        );
                    }
                }
                $data_list[0]['sumgetwx'] = $sumgetwx;
                $data_list[0]['getwx'] = $getwx;
                $data_list[0]['complet'] = $complet;
                $data_list[0]['follow'] = $follow;
                $data_list[0]['end'] = $end;
                if($sumgetwx !=0 )
                    $tc_per = sprintf('%.2f',$getwx/$sumgetwx*100).'%';
                if($getwx !=0 )
                    $rz_per = sprintf('%.2f',$complet/$getwx*100).'%';
                if($complet !=0 )
                    $gz_per = sprintf('%.2f',$follow/$complet*100).'%';
                $data_list[0]['tc_per'] = $tc_per;
                $data_list[0]['rz_per'] = $rz_per;
                $data_list[0]['gz_per'] = $gz_per;
                $setpage=  self::pagslist($data_list, $count, $pagesize);
                $userlist = $setpage->toArray()['data'];
                if($excel == 1){
                    foreach($userlist as $k=>$v){
                        $arr[] = array(
                            'nick_name'=>$v['nick_name'],
                            'date_time'=>$v['date_time'],
                            'sumgetwx'=>$v['sumgetwx'],
                            'getwx'=>$v['getwx'],
                            'complet'=>$v['complet'],
                            'follow'=>$v['follow'],
                            'end'=>$v['end'],
                            'tc_per'=>$v['tc_per'],
                            'rz_per'=>$v['rz_per'],
                            'gz_per'=>$v['gz_per'],
                        );
                    }
                    $name = '渠道统计报表';
                    $head['head'] = array('渠道名称','日期','获取公众号',' 成功获取公众号','填充率','微信认证','认证率','成功关注','关注率','点击完成');
                    self::export($name,$head,$arr);
                }
                return view('Operate.channelStatistics_detailOne',['list'=>$userlist,'paginator'=>$setpage,'user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
            }
        }
        return view('Operate.channelStatistics_detail',['user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
    }
}