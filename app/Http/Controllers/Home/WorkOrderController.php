<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Config;
use DB;
use Illuminate\Http\Request;
use Input;
use App\Lib\HttpUtils\HttpRequest;
use App\Services\Impl\Order\WorkOrderServicesImpl;
use Illuminate\Support\Facades\Redirect;

class WorkOrderController extends Controller
{
    public function getWorkOrder()
    {
        $parameter['userid']= self::getUserId();
        $array = HttpRequest::getApiServices('user','getWorkOrder','GET',$parameter);
        $data['wx_name']=$array['data']['wxname'];
        $data['sceneList']=$array['data']['scene'];
        $data['referenceprice']=$array['data']['referenceprice'];
        $data['olderprice']=$array['data']['olderprice'];
        return view('Home.addworkorder', $data);
    }
    
    public function postWorkOrder(Request $request)
    {
        $model=new WorkOrderServicesImpl();
        
        //$hot_area=$model->getcityid($request->input('hot_area'));
        $hot_area = $request->input('hot_area');
        //$fans_tag=$model->getcityid($request->input('fans_tag'));
        $fans_tag=$request->input('fans_tag');
        
        if($hot_area==','){
            $hot_area = '';
        }
        
        if($fans_tag==','){
            $fans_tag = '';
        }
        
        $wx_array = explode(',', $request->input('gzh'));
        
        $logary=array(
            'user_id'=>self::getUserId(),
            'wx_id'=>$wx_array[2],
            'w_total_fans'=>$request->input('total_fans'),
            'w_least_fans'=>$request->input('least_fans'),
            'w_max_fans'=>$request->input('max_fans'),
            'w_advis_fans'=>$request->input('advis_fans'),
            'w_per_price'=>$request->input('per_price'),
            'w_user_money'=>$request->input('user_money'),
            'w_start_date'=>$request->input('start_date'),
            'w_end_date'=>$request->input('end_date'),
            'w_start_time'=>$request->input('start_time'),
            'w_end_time'=>$request->input('end_time'),
            'sex'=>$request->input('sex'),
            'check_status'=>$request->input('multiple'),
            'w_desc'=>$request->input('remark'),
            'device_type'=>$request->input('device_type'),
            'hot_area'=>$hot_area,
            'fans_tag'=>$fans_tag,
            'wx_name'=>$wx_array[1],
            'report_id'=>$wx_array[0],
        );
        if($request->input('scene')!=''){$logary['scene']=','. implode(",",$request->input('scene')).',';}
        
        $model->convert($logary);
        if($model->isValid()){
            if (!$model->add()) {
                return redirect('home/workorder/getworkorder')->with('msg', '添加失败');
            } else {
                sleep(1);
                return redirect('home/workorder/getworkorderlist');
            }
        }else {
            //print_r($model->messages());
             return back()->withErrors($model->validator());
        }
    }
    
    public function getWorkOrderList()
    {
        
        $action="no";
        $data=array('gzh'=>'','startDate'=>'','endDate'=>'','stat'=>'','fanstate'=>'','action'=>'');
        $action=isset($_GET['action'])?$_GET['action']:"no"; 
        if($action=='search'){
            $data['gzh']=isset($_GET['gzh'])?$_GET['gzh']:'';

            $data['startDate']=isset($_GET['startDate'])?$_GET['startDate']:'';

            $data['endDate']=isset($_GET['endDate'])?$_GET['endDate']:'';

            $data['stat']=isset($_GET['stat'])?$_GET['stat']:'';
            
            $data['fanstate']=isset($_GET['fanstate'])?$_GET['fanstate']:'';
        }
        
        
        $data['page']=isset($_GET['page'])?$_GET['page']:1;
        $data['pagesize']=10;//每页显示几条数据
        $data['userid']=self::getUserId();
        //根据筛选条件获取信息
        $listdata = HttpRequest::getApiServices('user','getYWorkOrder','GET',$data);
        //获取微信选项
        $wx_name = HttpRequest::getApiServices('user','getWxNumberName','GET',$data);
        
        $data['wx_name']=$wx_name['data'];
        
        $item=$listdata['data']['data'];//展示的数据
        
        $total=$listdata['data']['count'];//总共有几条数据
        foreach($item as $k=>$v){
            if($v['total_fans']==='-'){
                $item[$k]['day_fans'] ='-'; 
                $item[$k]['subscribe_today'] ='-'; 
            } else {
                if(date('Y-m-d')<=$v['w_start_date']){
                    $time_value = 2222;
                }elseif(date('Y-m-d')<=$v['w_end_date']){
                    $time_value = time()-strtotime($v['w_start_date']);
                } else {
                    $time_value = strtotime($v['w_end_date'])-strtotime($v['w_start_date']);
                }
                
                $sum = round($time_value/3600/24);
                if($sum==0){
                    $item[$k]['day_fans'] = 0;
                }else{
                  $item[$k]['day_fans'] = floor($v['total_fans']/$sum);  
                }
                
            }
        }
        $setpage=  self::pagslist($item, $total, $data['pagesize']);
        
        $userlist = $setpage->toArray()['data'];
        $data['paginator']=$setpage;
        $data['userlist']=$userlist;
        return view('Home.workorderlist',  $data);
    }
    
    public function getEditWorkOrder()
    {
        $parameter['userid']= self::getUserId();
        $array = HttpRequest::getApiServices('user','getWorkOrder','GET',$parameter);

        $data['wx_name']=$array['data']['wxname'];
        $data['olderprice']=$array['data']['olderprice'];
        $data['sceneList']=$array['data']['scene'];
        $parameter['workId'] = $_GET['workId'];
        $workinfo = HttpRequest::getApiServices('user','getWOrderInfo','GET',$parameter);
        //print_r($workinfo['data']['isorder']);
        $data['worderinfo']=$workinfo['data'];
        //print_r($data['worderinfo']);
        
        foreach ($data['sceneList'] as $key => $value) {
            if(strpos($data['worderinfo']['scene'],','.$value['id'].',') === false){ 
                $data['sceneList'][$key]['es']=1;
            }else{
                $data['sceneList'][$key]['es']=2;
            }
        }
        //$data['hot_area']= WorkOrderServicesImpl::getCityName($data['worderinfo']['hot_area']);
        $data['hot_area']= $data['worderinfo']['hot_area'];

        //$data['fans_tag']=WorkOrderServicesImpl::getCityName($data['worderinfo']['fans_tag']);
        $data['fans_tag']=$data['worderinfo']['fans_tag'];
        
        return view('Home.editworkorder', $data);
    }
    
    public function postEditWorkOrder(Request $request)
    {
        $wx_array= explode(',', $request->input('gzh'));
        $parameter['workId'] = $request->input('id');

        $workinfo = HttpRequest::getApiServices('user','getWOrderInfo','GET',$parameter);
        $isorder=$workinfo['data']['isorder'];
        $model=new WorkOrderServicesImpl();
        
        //$hot_area=$model->getcityid($request->input('hot_area'));
        $hot_area=$request->input('hot_area');
        
        //$fans_tag=$model->getcityid($request->input('fans_tag'));
        $fans_tag=$request->input('fans_tag');
        
        if($hot_area==','){
            $hot_area = '';
        }
        
        if($fans_tag==','){
            $fans_tag = '';
        }
        
        $logary=array(
            'user_id'=>self::getUserId(),
            'w_total_fans'=>$request->input('total_fans'),
            'w_least_fans'=>$request->input('least_fans'),
            'w_max_fans'=>$request->input('max_fans'),
            'w_advis_fans'=>$request->input('advis_fans'),
            'w_per_price'=>$request->input('per_price'),
            'w_user_money'=>$request->input('user_money'),
            'w_start_date'=>$request->input('start_date'),
            'w_end_date'=>$request->input('end_date'),
            'w_start_time'=>$request->input('start_time'),
            'w_end_time'=>$request->input('end_time'),
            'sex'=>$request->input('sex'),
            'check_status'=>$request->input('multiple'),
            'hot_area'=>$hot_area,
            'fans_tag'=>$fans_tag,
            'w_desc'=>$request->input('remark'),
            'device_type'=>$request->input('device_type'),
        );
        if(count($wx_array)>1 && $request->input('gzh')!=''){
            $logary['wx_id']=$wx_array[2];
            $logary['wx_name']=$wx_array[1];
            $logary['report_id']=$wx_array[0];
        }
        if($request->input('scene')!=''){$logary['scene']=','. implode(",",$request->input('scene')).',';}
        
        $model->convert($logary);
        if($model->isValid()){
            if (!$model->update($request->input('id'),$isorder)) {
                redirect('home/workorder/getworkorder')->with('msg', '修改失败');
            } else {
                return redirect('home/workorder/getworkorderlist');
            }
        }else {
            //print_r($model->messages());
             return back()->withErrors($model->validator());
        }
    }
   
}