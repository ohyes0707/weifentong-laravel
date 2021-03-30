<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/27
 * Time: 15:25
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class SellController extends Controller{
    public function getSellList(){
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
        $data = HttpRequest::getApiServices('Home/SellController','sellCount','GET',$parameter);
        if($data['data']){
            $pagesizenew= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
            $parameter = array('page'=>$page,'pagesize'=>$pagesizenew,'uid'=>$uid,'start_date'=>$start_date,'end_date'=>$end_date,'wx_name'=>'');
            $data_total = HttpRequest::getApiServices('Home/SellController','sellCount','GET',$parameter);
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
            return view('Home.sales',['list'=>$list,'paginator'=>$paginator,'follow'=>$follow,'unfollow'=>$unfollow,'avg_price'=>$avg_price,'money'=>$money,'start_date'=>$start_date,'end_date'=>$end_date,'wx_list'=>$wx_list,'post'=>$_REQUEST]);
        }
        return view('Home.sales',['follow'=>$follow,'unfollow'=>$unfollow,'money'=>$money,'start_date'=>$start_date,'end_date'=>$end_date,'post'=>$_REQUEST]);
    }
}