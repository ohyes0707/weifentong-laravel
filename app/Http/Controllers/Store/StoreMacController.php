<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/4
 * Time: 17:27
 */
namespace App\Http\Controllers\Store;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Store\StoreDevmacModel;
use Illuminate\Support\Facades\Redirect;

class StoreMacController extends Controller{
    public function macAdd(){
        $store_id = isset($_POST['shop_id'])?$_POST['shop_id']:'';
        $mac = isset($_POST['mac'])?$_POST['mac']:'';
        if($store_id && $mac){
            $data = StoreDevmacModel::insert(['store_id'=>$store_id,'dev_mac'=>$mac]);
            if($data)
                $this->alert_back('添加设备成功');
        }
        $this->alert_back('添加设备失败');
    }

    public function macList(){
        $mac = isset($_REQUEST['mac'])?$_REQUEST['mac']:'';
        $area = isset($_REQUEST['area'])?$_REQUEST['area']:'';
        $brand = isset($_REQUEST['brand'])?$_REQUEST['brand']:'';
        $store = isset($_REQUEST['store'])?$_REQUEST['store']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('mac'=>$mac,'area'=>$area,'brand'=>$brand,'store'=>$store,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Store/Mac','macList','GET',$parameter);
        if($data['data']){
            $list = array();
            $paginator = false;
            if(isset($data['data']['data']) && !empty($data['data']['data'])){
                $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
                $list = $paginator->toArray()['data'];
            }
            $mac_list = isset($data['data']['mac_total'])?$data['data']['mac_total']:array();
            $area_list = isset($data['data']['area_total'])?$data['data']['area_total']:array();
            $brand_list = isset($data['data']['brand_total'])?$data['data']['brand_total']:array();
            $store_list = isset($data['data']['store_total'])?$data['data']['store_total']:array();
            $transform = array(
                'list'=>$list,
                'paginator'=>$paginator,
                'mac_list'=>$mac_list,
                'area_list'=>$area_list,
                'brand_list'=>$brand_list,
                'store_list'=>$store_list,
                'post'=>$_REQUEST,
                'mac'=>$mac,
                'area'=>$area,
                'brand'=>$brand,
                'store'=>$store,
            );
            return view('Operate.Store.deviceManageLook',$transform);
        }
        return view('Operate.Store.deviceManageLook');
    }

    public function macDel(){
        $mac_id = isset($_POST['mac_id'])?$_POST['mac_id']:'';
        if($mac_id){
            $data = StoreDevmacModel::where('id','=',$mac_id)->delete();
            if($data)
                return $this->macList();
        }
        $this->alert_back('删除失败');
    }
}