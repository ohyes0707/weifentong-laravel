<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;

class BackfillController extends Controller
{
    /*数据回填*/
    public function getBackFill(Request $request){

        $termarray=array(
            // 'gzh'=>$request->input('gzh'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize'),
            'status'=>$request->input('state'),
        );

        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        if(empty($startdate)){
            $startdate = date('Y-m-d',strtotime("-1 week"));
        }
        if(empty($enddate)){
            $enddate = date('Y-m-d',strtotime("-1 day"));
        }

        $listdata = HttpRequest::getApiServices('data','getBackFill','GET',$termarray);
        $item=$listdata['data']['data'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total,10);
        // // print_r($setpage->toArray()['data']);

        $return['paginator']=$setpage;
        $return['termarray']=$termarray;

        return view('Operate.fillData',['paginator' => $setpage,'termarray' => $termarray,'startdate'=>$startdate,'enddate'=>$enddate]);
    }

    //回填的渠道数据
    public function getBackEdit(Request $request){
        $termarray=array(
            'datetime' =>$request->input('date'),
        );
        $listdata_id = HttpRequest::getApiServices('data','getBackEdit','GET',$termarray);
        if($listdata_id['data']){
            return $listdata_id['data'];
        }else{
            return error;
        }
    }

    //先获取之前的数据再根据wx_id 和 bid 去post获取数据
    public function BackEdit(Request $request){
        $termarray=array(
            'datetime' =>$request->input('datetime_buss'),
        );
        $listdata_id = HttpRequest::getApiServices('data','getBackEdit','GET',$termarray);//根据提交的日期获取渠道数据

        if($listdata_id['data']){
            foreach ($listdata_id['data'] as $key => $value) {
                $wx_id = $request->input('wx_name_'.$value['wx_id']);//获取wx_id
                if($wx_id){
                    $sum_number = $request->input('amount_'.$value['wx_id']);//获取wx_id公众号总数
                
                    foreach ($value['buss'] as $kb => $vb) {
                        $id = $request->input('bid_'.$vb['id']);//获取id
                        $bid = $request->input('bid_'.$vb['bid']);//获取bid
                        if($id){
                            $bid_val = $request->input('bid_val_'.$id);//获取bid所占比例
                            if($bid_val){
                                $termarray=array(
                                    // 'gzh'=>$request->input('gzh'),
                                    'wx_id'=>$wx_id,
                                    'number'=>$sum_number*($bid_val/100),
                                    'datetime' =>$request->input('datetime_buss'),
                                    'bid'=>$bid,
                                    'hold'=>$bid_val,
                                );
                                $BackEdit = HttpRequest::getApiServices('data','BackEdit','GET',$termarray);//插入数据
                                unset($termarray);
                            }
                        }
                    }
                    
                }
            }
            if($BackEdit['success']){
                return redirect()->intended('operate/backfill/backfilllist');
            }else{
                die("编辑失败");
            }
        }else{
            return error;
        }
    }

}