<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:50
 */

//运营用户操作控制器类
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrderList(Request $request){
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:'';
        $end_date = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:'9999-99-99';
        $wx_id = isset($_REQUEST['gzh'])?$_REQUEST['gzh']:'';
        $order_status = isset($_REQUEST['state'])?$_REQUEST['state']:'';
        $uid = session()->get('userid');
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:5;
        if(!$end_date){
            $end_date = '9999-99-99';
        }
        $parameter = array('start_date'=>$start_date,'end_date'=>$end_date,'wx_id'=>$wx_id,'order_status'=>$order_status,'uid'=>$uid,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/Order','getOrderList','GET',$parameter);
        $arr = $data['data'];
        $wx_list = $arr['wx_list'];
        $count = $arr['count'];
        unset($arr['count']);
        unset($arr['wx_list']);
        foreach($arr as $k=>$v){
            $time_value = time()-strtotime($v['create_time']);
            $sum = round($time_value/3600/24);
            $arr[$k]['day_fans'] = floor($v['total_fans']/$sum);
        }
        $setpage=  self::pagslist($arr, $count, $pagesize);
        $userlist = $setpage->toArray()['data'];
        $list['paginator']=$setpage;
        $list['arr']=$userlist;
        $list['post'] = $_REQUEST;
        $list['wx_list'] = $wx_list;
        $list['term']=$parameter;
        return view('Home.order',$list);
    }
}