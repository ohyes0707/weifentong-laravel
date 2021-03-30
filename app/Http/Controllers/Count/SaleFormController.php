<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/29
 * Time: 9:46
 */
namespace App\Http\Controllers\Count;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class SaleFormController extends Controller{
    public function saleStatistics(){
        $excel = isset($_REQUEST['excels'])?$_REQUEST['excels']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $sales = isset($_REQUEST['sales'])?$_REQUEST['sales']:0;
        $parameter = array('sales'=>$sales,'page'=>$page,'pagesize'=>$pagesize,'start_date'=>$startDate,'end_date'=>$endDate);
        $data = HttpRequest::getApiServices('Count/SaleFormController','saleStatistics','GET',$parameter);
        if($data['data']){
            if($excel == 1){
                foreach($data['data']['data'] as $k=>$v){
                    $percent = '0.00%';
                    if($v['follow'] != 0)
                        $percent = sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%';
                    $arr[] = array(
                        'nick_name'=>$v['nick_name'],
                        'follow'=>$v['follow'],
                        'unfollow'=>$v['unfollow'],
                        'percent'=>$percent,
                        'price'=>sprintf('%.2f',$v['price']),
                        'cost'=>$v['cost'],
                    );
                }
                $name = '销售报表';
                $head['head'] = array('销售代表','成功关注','取关数','取关率','平均单价','销售额');
                self::export($name,$head,$arr);
            }
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $list = $paginator->toArray()['data'];
            return view('Operate/salesStatistics',['list'=>$list,'user'=>$data['data']['user'],'sales'=>$sales,'paginator'=>$paginator,'startDate'=>$startDate,'endDate'=>$endDate,'post'=>$_REQUEST]);
        }else{
            return view('Operate/salesStatistics',['startDate'=>$startDate,'endDate'=>$endDate]);
        }

    }
}