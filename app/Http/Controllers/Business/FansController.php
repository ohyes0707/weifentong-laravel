<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/2
 * Time: 9:36
 */
namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class FansController extends Controller{
    public function fansEarn(){
        $buss = session()->get('buss_id');
        $pbuss = session()->get('parent_id');
        if($pbuss!=0)
            return self::fansEarn_child();
        $bid = isset($buss)?$buss:'1';
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel == 1){
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99;
        }else{
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $parameter = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$startDate,'end_date'=>$endDate);
        $data = HttpRequest::getApiServices('Business/Fans','fansEarn','GET',$parameter);
        if(isset($data['data']['count'])){
            $num = $data['data']['count'];
            $father = $data['data']['father'];
            unset($data['data']['count']);
            unset($data['data']['father']);
        }
        if(isset($data['data']) && !empty($data['data'])){
            $pagesizenew = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99;
            $condition = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesizenew,'start_date'=>$startDate,'end_date'=>$endDate);
            $data_total = HttpRequest::getApiServices('Business/Fans','fansEarn','GET',$condition);
            $list['total'] = array(
                'follow'=>0,
                'unfollow'=>0,
                'num'=>0,
            );
            if(isset($father)){
                $list['id'] = $father['id'];
                $list['nick_name'] = $father['nick_name'];
            }
            if(isset($data_total['data']) && !empty($data_total['data'])){
                foreach($data_total['data'] as $k=>$v){
                    if(isset($v['count']) && !empty($v['count'])){
                        foreach($v['count'] as $kk=>$vv){
                            if(isset($list['count'][$vv['date']])){
                                $list['count'][$vv['date']]['follow'] += $vv['follow'];
                                $list['count'][$vv['date']]['unfollow'] += $vv['unfollow'];
                                $list['count'][$vv['date']]['num'] += $vv['num'];
                            }else{
                                $list['count'][$vv['date']] = $vv;
                            }
                            $list['total']['follow'] += $vv['follow'];
                            $list['total']['unfollow'] += $vv['unfollow'];
                            $list['total']['num'] += $vv['num'];
                        }
                    }
                }
            }
            if(isset($list['count']) && !empty($list['count']))
                krsort($list['count']);
            sort($data['data']);
            foreach($data['data'] as $k=>$v){
                $data['data'][$k]['total'] = array(
                    'follow'=>0,
                    'unfollow'=>0,
                    'num'=>0,
                );
                if(isset($v['count']) && !empty($v['count'])){
                    foreach($v['count'] as $kk=>$vv){
                        $data['data'][$k]['total']['follow'] += $vv['follow'];
                        $data['data'][$k]['total']['unfollow'] += $vv['unfollow'];
                        $data['data'][$k]['total']['num'] += $vv['num'];
                    }
                }
            }
            if($excel == 1){
                $arr[] = array(
                    'nick_name'=>$list['nick_name'],
                    'date_time'=>'',
                    'follow'=>$list['total']['follow'],
                    'num'=>sprintf('%.2f',$list['total']['num']),
                );
                if(isset($list['count']) && !empty($list['count'])){
                    foreach($list['count'] as $k=>$v){
                        if($v['follow'] != 0){
                            $arr[] = array(
                                'nick_name'=>'',
                                'date_time'=>$v['date'],
                                'follow'=>$v['follow'],
                                'num'=>sprintf('%.2f',$v['num'])
                            );
                        }
                    }
                }
                foreach($data['data'] as $k=>$v){
                    if($v['total']['follow'] != 0){
                        $arr[] = array(
                            'nick_name'=>$v['nick_name'],
                            'date_time'=>'',
                            'follow'=>$v['total']['follow'],
                            'num'=>sprintf('%.2f',$v['total']['num']),
                        );
                    }
                    if(isset($v['count']) && !empty($v['count'])){
                        foreach($v['count'] as $kk=>$vv){
                            if($vv['follow'] != 0){
                                $arr[] = array(
                                    'nick_name'=>'',
                                    'date_time'=>$vv['date'],
                                    'follow'=>$vv['follow'],
                                    'num'=>sprintf('%.2f',$vv['num'])
                                );
                            }
                        }
                    }
                }
                $name = '带粉收益';
                $head['head'] = array('商家','时间','带粉数',' 收益');
                self::export($name,$head,$arr);
            }
            $paginator = self::pagslist($data['data'],$num,$pagesize);
            $data_list = $paginator->toArray()['data'];
            $arr['father'][] = $list;
            $arr['child'] = $data_list;
            return view('Business.earnings',['list'=>$arr,'startDate'=>$startDate,'endDate'=>$endDate,'paginator'=>$paginator,'post'=>$_REQUEST]);
        }
        return view('Business.earnings',['startDate'=>$startDate,'endDate'=>$endDate]);
    }

    public function fansCount(){
        $buss = session()->get('buss_id');
        $pbuss = session()->get('parent_id');
        if($pbuss!=0)
            return self::fansCount_child();
        $bid = isset($buss)?$buss:'1';
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        if($excel == 1){
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99;
        }else{
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $parameter = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$startDate,'end_date'=>$endDate);
        $data = HttpRequest::getApiServices('Business/Fans','fansEarn','GET',$parameter);
        if(isset($data['data']['count'])){
            $num = $data['data']['count'];
            $father = $data['data']['father'];
            unset($data['data']['count']);
            unset($data['data']['father']);
        }
        if(isset($data['data']) && !empty($data['data'])){
            $pagesizenew = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99;
            $condition = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesizenew,'start_date'=>$startDate,'end_date'=>$endDate);
            $data_total = HttpRequest::getApiServices('Business/Fans','fansEarn','GET',$condition);
            $list['total'] = array(
                'follow'=>0,
                'unfollow'=>0,
            );
            $list['id'] = $father['id'];
            $list['nick_name'] = $father['nick_name'];
            foreach($data_total['data'] as $k=>$v){
                if(isset($v['count']) && !empty($v['count'])){
                    foreach($v['count'] as $kk=>$vv){
                        $list['total']['follow'] += $vv['follow'];
                        $list['total']['unfollow'] += $vv['unfollow'];
                        if(isset($list['count'][$vv['date']])){
                            $list['count'][$vv['date']]['follow'] += $vv['follow'];
                            $list['count'][$vv['date']]['unfollow'] += $vv['unfollow'];
                        }else{
                            $list['count'][$vv['date']] = array(
                                'follow'=>$vv['follow'],
                                'unfollow'=>$vv['unfollow'],
                                'date'=>$vv['date'],
                                'buss_id'=>$vv['buss_id'],
                            );
                        }
                    }
                }
            }
            if(isset($list['count']))
                krsort($list['count']);
            sort($data['data']);
            foreach($data['data'] as $k=>$v){
                $data['data'][$k]['total'] = array(
                    'follow'=>0,
                    'unfollow'=>0,
                );
                if(isset($v['count']) && !empty($v['count'])){
                    foreach($v['count'] as $kk=>$vv){
                        $data['data'][$k]['total']['follow'] += $vv['follow'];
                        $data['data'][$k]['total']['unfollow'] += $vv['unfollow'];
                    }
                    krsort($data['data'][$k]['count']);
                }
            }
            if($excel == 1){
                $per = '0.00%';
                if($list['total']['follow']){
                    $per = sprintf('%.2f',$list['total']['unfollow']/$list['total']['follow']*100).'%';
                }
                $arr[] = array(
                    'nick_name'=>$list['nick_name'],
                    'date_time'=>'',
                    'follow'=>$list['total']['follow'],
                    'unfollow'=>$list['total']['unfollow'],
                    'percent'=>$per,
                );
                if(isset($list['count']) && !empty($list['count'])){
                    foreach($list['count'] as $k=>$v){
                        if($v['follow'] != 0 && $v['unfollow'] != 0){
                            $per = '0.00%';
                            if($v['follow']){
                                $per = sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%';
                            }
                            $arr[] = array(
                                'nick_name'=>'',
                                'date'=>$v['date'],
                                'follow'=>$v['follow'],
                                'unfollow'=>$v['unfollow'],
                                'percent'=>$per,
                            );
                        }
                    }
                }
                foreach($data['data'] as $k=>$v){
                    $per = '0.00%';
                    if($v['total']['follow']){
                        $per = sprintf('%.2f',$v['total']['unfollow']/$v['total']['follow']*100).'%';
                    }
                    if($v['total']['follow'] != 0 && $v['total']['unfollow'] != 0){
                        $arr[] = array(
                            'nick_name'=>$v['nick_name'],
                            'date'=>'',
                            'follow'=>$v['total']['follow'],
                            'unfollow'=>$v['total']['unfollow'],
                            'percent'=>$per,
                        );
                    }
                    if(isset($v['count']) && !empty($v['count'])){
                        foreach($v['count'] as $kk=>$vv){
                            if($vv['follow'] != 0 && $vv['unfollow'] != 0){
                                $per = '0.00%';
                                if($vv['follow']){
                                    $per = sprintf('%.2f',$vv['unfollow']/$vv['follow']*100).'%';
                                }
                                $arr[] = array(
                                    'nick_name'=>'',
                                    'date'=>$vv['date'],
                                    'follow'=>$vv['follow'],
                                    'unfollow'=>$vv['unfollow'],
                                    'percent'=>$per,
                                );
                            }
                        }
                    }
                }
                $name = '带粉统计';
                $head['head'] = array('商家','时间','带粉数',' 取关数','取关率');
                self::export($name,$head,$arr);
            }
            $paginator = self::pagslist($data['data'],$num,$pagesize);
            $data_list = $paginator->toArray()['data'];
            $arr['father'][] = $list;
            $arr['child'] = $data_list;
            return view('Business.statistics',['list'=>$arr,'startDate'=>$startDate,'endDate'=>$endDate,'paginator'=>$paginator,'post'=>$_REQUEST]);
        }
        return view('Business.statistics',['startDate'=>$startDate,'endDate'=>$endDate]);
    }

    public function fansEarn_child(){
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        $buss = session()->get('buss_id');
        $bid = isset($buss)?$buss:'227';
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        if($excel == 1){
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $parameter = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$startDate,'end_date'=>$endDate);
        $data = HttpRequest::getApiServices('Business/Fans','fansEarn_child','GET',$parameter);
        if(isset($data['data']['data'])){
            $pagesizenew = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:999;
            $condition = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesizenew,'start_date'=>$startDate,'end_date'=>$endDate);
            $data_total = HttpRequest::getApiServices('Business/Fans','fansEarn_child','GET',$condition);
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $fans_list = $paginator->toArray()['data'];
            foreach($data_total['data']['total'] as $k=>$v){
                $list[] = array(
                    'date'=>'总计',
                    'follow'=>$v['follow'],
                    'num'=>sprintf('%.2f',$v['num']),
                );
            }
            foreach($fans_list as $k=>$v){
                $list[] = array(
                    'date'=>$v['date'],
                    'follow'=>$v['follow'],
                    'num'=>sprintf('%.2f',$v['num']),
                );
            }
            if($excel == 1){
                $name = '带粉收益';
                $head['head'] = array('时间','带粉数',' 收益');
                self::export($name,$head,$list);
            }
            return view('Business.sub-earnings',['list'=>$list,'startDate'=>$startDate,'endDate'=>$endDate,'paginator'=>$paginator,'post'=>$_REQUEST]);
        }
        return view('Business.sub-earnings',['startDate'=>$startDate,'endDate'=>$endDate]);
    }

    public function fansCount_child(){
        $excel = isset($_POST['excel'])?$_POST['excel']:'';
        $buss = session()->get('buss_id');
        $bid = isset($buss)?$buss:'227';
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        if($excel == 1){
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $parameter = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$startDate,'end_date'=>$endDate);
        $data = HttpRequest::getApiServices('Business/Fans','fansEarn_child','GET',$parameter);
        if(isset($data['data']['data'])){
            $pagesizenew = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:999;
            $condition = array('buss'=>$bid,'page'=>$page,'pagesize'=>$pagesizenew,'start_date'=>$startDate,'end_date'=>$endDate);
            $data_total = HttpRequest::getApiServices('Business/Fans','fansEarn_child','GET',$condition);
            foreach($data_total['data']['total'] as $k=>$v){
                $num = '0.00%';
                if($v['follow'] != 0)
                    $num = sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%';
                $list[] = array(
                    'date'=>'总计',
                    'follow'=>$v['follow'],
                    'unfollow'=>$v['unfollow'],
                    'percent'=>$num,
                );
            }
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $fans_list = $paginator->toArray()['data'];
            foreach($fans_list as $k=>$v){
                $num = '0.00%';
                if($v['follow'] != 0)
                    $num = sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%';
                $list[] = array(
                    'date'=>$v['date'],
                    'follow'=>$v['follow'],
                    'unfollow'=>$v['unfollow'],
                    'percent'=>$num,
                );
            }
            if($excel == 1){
                $name = '带粉统计';
                $head['head'] = array('时间','带粉数',' 取关数','取关率');
                self::export($name,$head,$list);
            }
            return view('Business.sub-statistics',['list'=>$list,'startDate'=>$startDate,'endDate'=>$endDate,'paginator'=>$paginator,'post'=>$_REQUEST]);
        }
        return view('Business.sub-statistics',['startDate'=>$startDate,'endDate'=>$endDate]);
    }
}