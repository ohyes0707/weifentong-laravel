<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;

class WithdrawalsController extends Controller
{
    /*提现列表*/
    public function getDepositlist(Request $request) {
        $termarray=array(
            'buss_id' =>$request->input('buss_id'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize'),
            'status'=>$request->input('state'),
            'buss_one'=>$request->input('subShop'),
        );
        // var_dump($termarray);die;

        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        if(empty($startDate)){
            $startDate = date('Y-m-d',strtotime("-1 week"));
        }
        if(empty($endDate)){
            $endDate = date('Y-m-d');
        }

        // var_dump($termarray);die;
        $listdata = HttpRequest::getApiServices('data','getDepositlist','GET',$termarray);
        // var_dump($listdata);die;
        if(!empty($listdata['data']['data'])){
            $item=$listdata['data']['data'];//展示的数据
        }else{
            $item= '';
        }
        if(!empty($listdata['data']['count'])){
            $total=$listdata['data']['count'];//总共有几条数据
        }else{
            $total= 0;
        }
        if (!empty($item)) {
            $setpage =  self::pagslist($item, $total,10);
        }else{
            $setpage = 0;
        }
        
        // print_r($setpage->toArray()['data']);
        
        $state = $request->input('state');
        if(empty($state)){
            $state = 0;
        }

        $subShop = $request->input('buss_id');
        if(empty($subShop)){
            $subShop = 0;
        }
        
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;

        if(!empty($listdata['data']['name_list'])){
            $name_list = $listdata['data']['name_list'];
        }else{
            $name_list = 0;
        }

        if(empty($item)){
            return view('Operate.depositlist',['paginator' => '','termarray' => $termarray,'startDate'=>$startDate,'endDate'=>$endDate,'name_list' => $name_list,'state' => $state,'subShop' => $subShop]);
        }

        return view('Operate.depositlist',['paginator' => $setpage,'termarray' => $termarray,'startDate'=>$startDate,'endDate'=>$endDate,'name_list' => $name_list,'state' => $state,'subShop' => $subShop]);
    }

    public function getWithdrawLook(Request $request) {
        $termarray=array(
            'lid' =>$request->input('lid'),
        );
        
        $listdata = HttpRequest::getApiServices('data','getWithdrawLook','GET',$termarray);
        // var_dump($listdata);die;
        return view('Operate.depositDetail',['paginator' => $listdata['data']]);
    }

    public function getLook(Request $request) {
        $termarray=array(
            'lid' =>$request->input('lid'),
            'op_money' =>$request->input('op_money'),
            'sbid' =>$request->input('sbid'),
        );
        $listdata_id = HttpRequest::getApiServices('data','getLook','GET',$termarray);
        if($listdata_id['data']){
            echo 'true';
        }else{
            echo false;
        }
        
    }

    public function getReject(Request $request) {
        $termarray=array(
            'lid' =>$request->input('lid'),
            'reject' =>$request->input('reject'),
        );
        $listdata_id = HttpRequest::getApiServices('data','getReject','GET',$termarray);
        if($listdata_id['data']){
            echo 'true';
        }else{
            echo false;
        }
        
    }

}