<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/4
 * Time: 9:54
 */
namespace App\Http\Controllers\Count;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class PlatController extends Controller{

    /**
     * 平台报表数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function platCount(){
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:0;
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $status = isset($_REQUEST['status'])?$_REQUEST['status']:1;
        $user = isset($_REQUEST['user'])?$_REQUEST['user']:0;
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $paramater = array('page'=>$page,'pagesize'=>$pagesize,'status'=>$status,'user'=>$user,'start_date'=>$startDate,'end_date'=>$endDate);
        $data = HttpRequest::getApiServices('Count/PlatSummary','platCount','GET',$paramater);
        if(isset($data['data']['database'])){
            $count = $data['data']['count_num'];
            $setpage=  self::pagslist($data['data']['database'], $count, $pagesize);
            $count_list = $setpage->toArray()['data'];
            $_REQUEST['status'] = $status;
            if($excel == 1){
                foreach($count_list as $k=>$v){
                    $arr[] = array(
                        'date_time'=>$v['date_time'],
                        'sumgetwx'=>$v['sumgetwx'],
                        'getwx'=>$v['getwx'],
                        'complet'=>$v['complet'],
                        'follow'=>$v['follow'],
                        'tc_per'=>$v['sumgetwx'] == 0?'0.00%':sprintf('%.2f',$v['getwx']/$v['sumgetwx']*100).'%',
                    );
                }
                $name = '平台统计报表';
                $head['head'] = array('日期','获取公众号','成功获取公众号',' 微信认证','成功关注','填充率');
                if(empty($arr)){
                    return self::alert_back('数据为空');
                }else{
                    self::export($name,$head,$arr);
                }
            }
            return view('Operate.flatformStatistics',['list'=>$count_list,'paginator'=>$setpage,'status'=>$status,'user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
        }
        return view('Operate.flatformStatistics',['status'=>$status,'user'=>$user,'startDate'=>$startDate,'endDate'=>$endDate]);
    }
}