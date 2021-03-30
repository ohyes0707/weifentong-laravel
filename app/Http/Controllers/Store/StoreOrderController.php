<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/3
 * Time: 9:53
 */
namespace App\Http\Controllers\Store;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Order\OrderModel;
use App\Services\Impl\Store\StoreOrderServicesImpl;
use Illuminate\Support\Facades\Redis;

class StoreOrderController extends Controller{
    /**
     * 美业订单列表
     */
    public function storeOrderList(){
        $wx_id = isset($_REQUEST['wx_id'])?$_REQUEST['wx_id']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('wx_id'=>$wx_id,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Store/StoreOrder','storeOrderList','GET',$parameter);
        if($data['data']){
            if(isset($data['data']['data'])){
                $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
                $list = $paginator->toArray()['data'];
                return view('Operate.Store.ghOrder',['list'=>$list,'paginator'=>$paginator,'wx_id'=>$wx_id,'wx_list'=>$data['data']['wx_list'],'post'=>$_REQUEST]);
            }
        }
        return view('Operate.Store.ghOrder');
    }
    /**
     * 美业新增订单
     */
    public function storeOrderAdd(){
        if($_POST){
            unset($_POST['_token']);
            if(isset($_POST['select_brand']))
                $_POST['select_brand'] = json_encode($_POST['select_brand']);
            $data = HttpRequest::getApiServices('Store/StoreOrder','storeOrderAdd','POST',$_POST);
            if($data['data']){
                Redis::hset('brandoid',$data['data'],1);
                return $this->storeOrderList();
            }
            return self::alert_back('添加订单失败');
        }else{
            $data = HttpRequest::getApiServices('Store/StoreOrder','storeOrderAddWx','GET',$parameter=array());
            $wx_list = array();
            $area = array();
            $brand = array();
            if(isset($data['data']['wx_list']))
                $wx_list = $data['data']['wx_list'];
            if(isset($data['data']['area']))
                $area = $data['data']['area'];
            return view('Operate.Store.ghOrderAdd',['wx_list'=>$wx_list,'area'=>$area,'brand'=>$brand]);
        }
    }
    /**
     * 美业联动获取品牌
     */
    public function getBrand(){
        $area = $_REQUEST['area']?$_REQUEST['area']:'';
        if($area){
            $data = StoreOrderServicesImpl::getBrand($area);
            return json_encode($data);
        }
        return false;
    }
    /**
     * 美业订单状态修改
     */
    public function changeStatus(){
        $oid = isset($_REQUEST['oid'])?$_REQUEST['oid']:'';
        HttpRequest::getApiServices('Store/Order','changeStatus','GET',$paramater = array('oid'=>$oid));
        return self::storeOrderList();
    }
}