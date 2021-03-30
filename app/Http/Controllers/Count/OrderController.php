<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/1
 * Time: 14:01
 */
namespace App\Http\Controllers\Count;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class OrderController extends Controller{
    public function orderForm(){
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $date = isset($_REQUEST['date'])?$_REQUEST['date']:date('Y-m-d',time());
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'date'=>$date);
        $data = HttpRequest::getApiServices('Count/Order','orderForm','GET',$parameter);
        if($data['data']['data']){
            $total = 0;
            foreach($data['data']['data'] as $k=>$v){
                $total += $v['day_fans'];
            }
            if($excel == 1){
                foreach($data['data']['data'] as $k=>$v){
                    $arr[] = array(
                        'wx_name'=>$v['wx_name'],
                        'hot_area'=>$v['hot_area'],
                        'sex'=>$v['sex'],
                        'day_fans'=>$v['day_fans'],
                        'follow'=>$v['follow'],
                    );
                }
                $name = '订单报表';
                $head['head'] = array('订单名称','地区属性','性别','当日涨粉量','当日已涨粉量');
                self::export($name,$head,$arr);
            }
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $list = $paginator->toArray()['data'];
            return view('Operate.orderForm',['list'=>$list,'paginator'=>$paginator,'total'=>$total,'date'=>$date,'post'=>$_REQUEST]);
        }
        return view('Operate.orderForm',['date'=>$date]);
    }
}