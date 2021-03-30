<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/4
 * Time: 13:47
 */
namespace App\Http\Controllers\Store;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Store\BrandModel;
use App\Lib\Handle\Upload;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StoreBrandController extends Controller{
    public function storeBrandList(){
        if(isset($_POST['brand_name'])){
            BrandModel::insert(['brand_name'=>$_POST['brand_name']]);
        }
        $brand = isset($_REQUEST['brand'])?$_REQUEST['brand']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('brand'=>$brand,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Store/Brand','storeBrandList','GET',$parameter);
        if($data['data']){
            if(isset($data['data']['data'])){
                $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
                $list = $paginator->toArray()['data'];
                return view('Operate.Store.deviceManageBrand',['list'=>$list,'paginator'=>$paginator,'post'=>$_REQUEST,'brand'=>$brand,'brand_list'=>$data['data']['brand']]);
            }
        }
        return view('Operate.Store.deviceManageBrand');
    }
    public function brandDel(){
        $bid = $_GET['bid']?$_GET['bid']:'';
        if($bid){
            $data = BrandModel::where('brand_id','=',$bid)->delete();
        }
        return self::StoreBrandList();

    }

    public function brandPortal(Request $request){
        if($_POST){
            //接收文件信息
            $brand_id = isset($_POST['brand_id'])?$_POST['brand_id']:'';
            $path = "\Store\\";
            $rule =['png'];
            //进行上传
            $this->uploadImg = new Upload();
            $img = $this->uploadImg->upload_img($request,'portal',$path,$rule,'store_uploads');
            if($brand_id && $img){
                BrandModel::where('brand_id','=',$brand_id)->update(['brand_portal'=>$img['path'].'\\'.$img['name']]);
                return $this->storeBrandList();
            }
            $this->alert_back('上传失败');
        }
        $brand_id = isset($_GET['bid'])?$_GET['bid']:'';
        return view('Operate.Store.brandListSetPortal',['brand_id'=>$brand_id]);
    }
}