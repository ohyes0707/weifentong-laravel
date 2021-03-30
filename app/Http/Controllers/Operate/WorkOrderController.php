<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use Config;
use DB;
use Illuminate\Http\Request;
use App\Services\Impl\Order\WorkOrderServicesImpl;
use Input;
use App\Lib\HttpUtils\HttpRequest;

class WorkOrderController extends Controller
{
    
    public function getWorkOrderList(Request $request)
    {
        $action="no";
        $data=array('gzh'=>'','startDate'=>'','endDate'=>'','stat'=>'','action'=>'','fanstate'=>'','userid'=>$request->input('user'));
        if(isset($_GET['action'])) 
        { 
        $action=$_GET['action']; 
        }
        //$data['userid']=1;
        if($action=='search'){
            $data['gzh']=isset($_GET['gzh'])?$_GET['gzh']:'';

            $data['startDate']=isset($_GET['startDate'])?$_GET['startDate']:'';

            $data['endDate']=isset($_GET['endDate'])?$_GET['endDate']:'';

            $data['stat']=isset($_GET['stat'])?$_GET['stat']:'';
            
            $data['fanstate']=isset($_GET['fanstate'])?$_GET['fanstate']:'';
            
            $data['userid']=isset($_GET['user'])?$_GET['user']:'';
        }
        if($action=='upda'){
            if(isset($_GET['id'])&&$_GET['id']!='')
            {
                $data['id']=$_GET['id'];
            }
            if(isset($_GET['stat'])&&$_GET['stat']!='')
            {
                $data['stat']=$_GET['stat'];
            }
            if(isset($_GET['new'])&&$_GET['new']!='')
            {
                $data['new']=$_GET['new'];
            }
            $listdata = HttpRequest::getApiServices('user','getUpWOrderStat','GET',$data);
            
            if(isset($listdata['data']['orderid'])&&isset($listdata['data']['orderid'])){
                return redirect("operate/order/detail?work_id=".$listdata['data']['workid']."&order_id=".$listdata['data']['orderid']."");
            }
            $http=$_SERVER['HTTP_REFERER'];
            if(strpos($http, 'getworkorderlist')){
                header("Location: $http"); 
            } else {
                return redirect('operate/workorder/getworkorderlist');
            }
            
        }
        if(isset($_GET['page'])&&$_GET['page']!='')
        {
            $data['page']=$_GET['page'];
            $page=$_GET['page'];
        }
        $data['pagesize']=10;//每页显示几条数据
        //根据筛选条件获取信息
        $listdata = HttpRequest::getApiServices('user','getYWorkOrder','GET',$data);
        //获取微信选项
        $wx_name = HttpRequest::getApiServices('user','getWxNumberName','GET',$data);
        //销售代表
        $user_name = HttpRequest::getApiServices('user','getShopName','GET');
        $data['wx_name'] = $wx_name['data'];
        $data['user_name'] = $user_name['data'];
        $item=$listdata['data']['data'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        
        $setpage=  self::pagslist($item, $total, $data['pagesize']);
        $userlist = $setpage->toArray()['data'];
        $data['paginator']=$setpage;
        $data['userlist']=$userlist;
        return view('Operate.workorderlist',  $data);
    }
    
    public function getWorkOrder()
    {
        $parameter['workid']=$_GET['id'];
        $listdata = HttpRequest::getApiServices('user','getWOrderTwoInfo','GET',$parameter);
        //$listdata['data']['old']['fans_tag']=isset($listdata['data']['old']['fans_tag'])?$listdata['data']['old']['fans_tag']:'';
        //$listdata['data']['old']['hot_area']=isset($listdata['data']['old']['hot_area'])?$listdata['data']['old']['hot_area']:'';
        $listdata['data']['old']['scene']=isset($listdata['data']['old']['scene'])?$listdata['data']['old']['scene']:'';
        //print_r($listdata);
        $listdata['data']['now']['scene']= WorkOrderServicesImpl::getScene($listdata['data']['now']['scene']);
        //$listdata['data']['now']['hot_area']= WorkOrderServicesImpl::getCityName($listdata['data']['now']['hot_area']);
        //$listdata['data']['now']['fans_tag']= WorkOrderServicesImpl::getCityName($listdata['data']['now']['fans_tag']);
        $listdata['data']['now']['hot_area'] = $listdata['data']['now']['hot_area'];
        $listdata['data']['now']['fans_tag'] = $listdata['data']['now']['fans_tag'];
        
//        if($listdata['data']['old']==''){
//            
//        } else {
//            $listdata['data']['old']['fans_tag']=WorkOrderServicesImpl::getCityName($listdata['data']['old']['fans_tag']);
//            $listdata['data']['old']['hot_area']=WorkOrderServicesImpl::getCityName($listdata['data']['old']['hot_area']);
            $listdata['data']['old']['scene']= WorkOrderServicesImpl::getScene($listdata['data']['old']['scene']);
//        }
        return view('Operate.workorder',$listdata);
    }
    
    public function postWorkReject(Request $request){
        $id = $request->input('wid');
        $stat =$request->input('stat');
        $new = $request->input('new');
        $reason = $request->input('reason');
        $data = WorkOrderServicesImpl::getUpWOrderStat($id,$stat,$new,$reason);
        if(isset($listdata['data']['orderid'])&&isset($listdata['data']['orderid'])){
                return redirect("operate/order/detail?work_id=".$listdata['data']['workid']."&order_id=".$listdata['data']['orderid']."");
        }
        return redirect('operate/workorder/getworkorderlist');
    }
    
    public function getSerialize() {
        $hhd=628;
        $stooges = Array ( 
            'oid' => "$hhd",
            'ghname' => '欧司朗光电半导体' ,
            'ghid' => "gh_c061bacbef4f",
            'sname' => "上海滩国际大厦",
            'sid' => "4136822",
            'appid' => "wx663cd16bef7d3fdb",
            'secretkey' => "4f3d00df8de098e31bb61f2ed7012eed",
            'area' => "不限",
            'ssid' => "ssid",
            'qrcode_url' => "http://user.weifentong.com.cn/Uploads/Wxqrcode/2017-02-16/1556576151156.jpg"
            );
        $new = serialize($stooges);
        print_r($new);
    }
}