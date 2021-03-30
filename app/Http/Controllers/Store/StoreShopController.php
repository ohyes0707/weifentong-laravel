<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/4
 * Time: 15:54
 */
namespace App\Http\Controllers\Store;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class StoreShopController extends Controller{
    public function storeShopList(){
        $brand = isset($_REQUEST['brand'])?$_REQUEST['brand']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('brand'=>$brand,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Store/Shop','storeShopList','GET',$parameter);
        if($data['data']){
            if(isset($data['data']['data']) && !empty($data['data']['data'])){
                $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
                $list = $paginator->toArray()['data'];
                return view('Operate.Store.shopList',['list'=>$list,'paginator'=>$paginator,'brand_list'=>$data['data']['brand_arr'],'brand'=>$brand,'post'=>$_REQUEST]);
            }
        }
        return view('Operate.Store.shopList');
    }

    public function shopAdd(){
        if($_POST){
            if(!$_POST['mac'])
                $this->alert_back('请添加设备MAC');
            if(!$_POST['area'])
                $this->alert_back('请选择所在区域');
            if(!$_POST['brand'])
                $this->alert_back('请选择所属品牌');
            if(!$_POST['shop'])
                $this->alert_back('请添加门店');
            unset($_POST['_token']);
            $data = HttpRequest::getApiServices('Store/Shop','storeShopAdd','GET',$_POST);
            if($data['data']){
                return redirect('/operate/store/shop');
            }
            $this->alert_back('添加失败');
        }else{
            $data = HttpRequest::getApiServices('Store/Shop','getAreaBrand','GET',$parameter = array());
            $area = array();
            $brand = array();
            if(isset($data['data']['area']))
                $area = $data['data']['area'];
            if(isset($data['data']['brand']))
                $brand = $data['data']['brand'];
            return view('Operate.Store.deviceManageAdd',['area'=>$area,'brand'=>$brand]);
        }
    }
}