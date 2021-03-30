<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class WeChatReportController extends Controller
{

    public function getPlatformReport(Request $request){
        // var_dump($request->toArray());die;
        $termarray=array(
            // 'gzh'=>$request->input('gzh'),
            'excel'=>$request->input('excel'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize')
        );
        // var_dump($termarray);die;
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        if(empty($startdate)){
            $startdate = date('Y-m-d',strtotime("-1 week"));
        }
        if(empty($enddate)){
            $enddate = date('Y-m-d',strtotime("-1 day"));
        }
        $startdate_t = strtotime($startdate);
        $enddate_t = strtotime($enddate);
        $now_t = strtotime(date('Y-m-d',strtotime("-1 day")));
        if($startdate_t > $now_t || $enddate_t > $now_t){

            return self::alert_back('时间不能超过当前时间');
        }
        $listdata = HttpRequest::getApiServices('data','getPlatformReport','GET',$termarray);
        // var_dump($listdata);die;
        $item=$listdata['data']['data'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total,10);//分页
        // print_r($setpage->toArray()['data']);


        $excel = $request->input('excel');
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;

        //导出数据
        if($excel == 1){
            if($excel){
                if(empty($listdata['data']['data'])){
                    return self::alert_back('数据为空');
                }
                foreach($listdata['data']['data'] as $k=>$v){
                    $list[] = array(
                        'date_time'=>$v['date_time'],
                        'follow_repeat'=>$v['follow_repeat'],
                        'flowing_water'=>round($v['flowing_water'],2),
                        'new_fans'=>$v['new_fans'],
                        'new_fans_water'=>round($v['new_fans_water'],2),
                        'fans_Increase'=>$v['follow_repeat']-$v['new_fans'],
                        'Increase'=>round($v['flowing_water'],2)-round($v['new_fans_water'],2),
                    );
                }
                $name = '微信关注平台报表';
                $head['head'] = array('日期','成功关注','流水','微信关注','微信关注流水','关注增幅','流水增幅');
                self::export($name,$head,$list);
            }
        }

        return view('Operate.wxstatistics',['paginator' => $setpage,'termarray' => $termarray,'startdate'=>$startdate,'enddate'=>$enddate]);
    }

    public function getPublicSignalReport(Request $request){

        $termarray=array(
            // 'gzh'=>$request->input('gzh'),
            'excel'=>$request->input('excel'),
            'wx_id'=>$request->input('wx_id'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize'),
            'wxname'=>$request->input('wxName'),
        );
        // var_dump($termarray);die;

        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        if(empty($startdate)){
            $startdate = date('Y-m-d',strtotime("-1 week"));
        }
        if(empty($enddate)){
            $enddate = date('Y-m-d',strtotime("-1 day"));
        }
        $startdate_t = strtotime($startdate);
        $enddate_t = strtotime($enddate);
        $now_t = strtotime(date('Y-m-d',strtotime("-1 day")));
        if($startdate_t > $now_t || $enddate_t > $now_t){

            return self::alert_back('时间不能超过当前时间');
        }

        $listdata = HttpRequest::getApiServices('data','getPublicSignalReport','GET',$termarray);
        $item=$listdata['data']['data'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total,10);
        // // print_r($setpage->toArray()['data']);

        $wx_id = $request->input('wx_id');
        $wx_id = isset($wx_id)?$wx_id:'';
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        $excel = $request->input('excel');

        //导出数据
        if($excel == 1){
            if($excel){
                if(empty($item)){
                    return self::alert_back('数据为空');
                }
                foreach($item as $k=>$v){
                    $list[] = array(
                        'wx_name'=>$v['order']['wx_name'],
                        'date_time'=>'总数',
                        'follow_repeat_sum'=>$v['order']['follow_repeat_sum'],
                        'flowing_water_sum'=>round($v['order']['flowing_water_sum'],2),
                        'wx_sum'=>$v['order']['wx_sum'],
                        'wx_water_sum'=>round($v['order']['wx_water_sum'],2),
                        'fans_Increase'=>$v['order']['follow_repeat_sum']-$v['order']['wx_sum'],
                        'Increase'=>$v['order']['flowing_fans_water'],
                    );
                    if(isset($v['list']) && !empty($v['list'])){
                        foreach($v['list'] as $kk=>$vv){
                            $list[] = array(
                                'wx_name'=>$v['order']['wx_name'],
                                'date_time'=>$vv['date_time'],
                                'follow_repeat'=>$vv['follow_repeat'],
                                'flowing_water'=>round($vv['flowing_water'],2),
                                'new_fans'=>$vv['new_fans'],
                                'new_fans_water'=>round($vv['new_fans_water'],2),
                                'fans_Increase'=>$vv['follow_repeat']-$vv['new_fans'],
                                'Increase'=>$vv['flowing_fans_water'],
                            );
                        }
                    }
                }
                $name = '微信关注平台报表';
                $head['head'] = array('公众号','日期','成功关注','流水','微信关注','微信关注流水','关注增幅','流水增幅');
                self::export($name,$head,$list);
            }
        }
       
        return view('Operate.wxstatistics1',['paginator' => $setpage,'termarray' => $termarray,'startdate'=>$startdate,'enddate'=>$enddate,'wx_id'=>$wx_id,'wx_name'=>$listdata['data']['wx_name']['data']]);
    }

    /**
     * 运营系统公众号列表
     */
    public function wechatList(){
        $ghid = isset($_REQUEST['wx_id'])?$_REQUEST['wx_id']:'';
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('ghid'=>$ghid,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/WechatController','wechatList','GET',$parameter);
        if($data['data']){
            if(isset($data['data']['data'])){
                $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
                $list = $paginator->toArray()['data'];
                $lumen = config('config.API_URL');
                if($excel == 1){
                    foreach($list as $k=>$v){
                        $arr[] = array(
                            'wx_name'=>$v['wx_name'],
                            'default_shopname'=>$v['default_shopname'],
                            'service_type'=>$v['service_type'],
                            'verify_type'=>$v['verify_type'],
                            'nick_name'=>$v['nick_name'],
                            'status'=>$v['status'],
                            'ghid'=>$v['ghid'],
                        );
                    }
                    $head['head'] = array('公众号','门店','类型','是否认证','所属销售','状态','原始ID');
                    self::export('公众号列表',$head,$arr);
                }
                return view('Operate.ghList',['list'=>$list,'paginator'=>$paginator,'lumen'=>$lumen,'wx_name'=>$data['data']['wx_name'],'wx_id'=>$ghid]);
            }

        }
        return view('Operate.ghList');
    }
    /**
     * 运营系统banner设置
     */
    public function setBanner(){
        return view('Operate.ghListSetBanner');
    }
}