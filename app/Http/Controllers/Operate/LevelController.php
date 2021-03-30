<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/5
 * Time: 15:19
 */
namespace App\Http\Controllers\Operate;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Order\OrderModel;
use App\Models\Order\TaskModel;

class LevelController extends Controller{
    public function levelList(){
        //获取订单优先级
        $order = OrderModel::select('wx_name','order_level')->where('order_status',1)->where('order_type','=',1)->orderBy('order_level','desc')->paginate(10);
        $buss_f = isset($_REQUEST['channel'])?$_REQUEST['channel']:'';
        $buss_c = isset($_REQUEST['sub-channel'])?$_REQUEST['sub-channel']:'';
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'buss_f'=>$buss_f,'buss_c'=>$buss_c);
        $data = HttpRequest::getApiServices('Operate/Level','levelList','GET',$parameter);
        $buss_arr = array();
        $buss_carr = array();
        if(isset($data['data']['buss']))
            $buss_arr = $data['data']['buss'];
        if(isset($data['data']['buss_c']))
            $buss_carr = $data['data']['buss_c'];
        if(!empty($data['data']['data'])){
            $setpage=  self::pagslist($data['data']['data'], $data['data']['count'], $pagesize);
            $level_list = $setpage->toArray()['data'];
            foreach($level_list as $k=>$v){
                foreach($level_list[$k] as $kk=>$vv){
                    $level[$k][$vv['level']] = $vv;
                }
                krsort($level[$k]);
            }
            return view('Operate.priority',['post'=>$_REQUEST,'data'=>$level,'buss'=>$buss_arr,'paginator'=>$setpage,'buss_list'=>$buss_arr,'buss_c'=>$buss_carr]);
        }else{

            return view('Operate.priority',['post'=>$_REQUEST,'buss'=>$buss_arr,'buss_c'=>$buss_carr,'order'=>$order]);
        }
    }
    public function setLevel(){
        unset($_POST['_token']);
        $parameter = array('list'=>json_encode($_POST));
        $data = HttpRequest::getApiServices('Operate/Level','setLevel','GET',$parameter);
        return $this->levelList();
    }
    public function getSon(){
        $bid = isset($_GET['value'])?$_GET['value']:'';
        if($bid){
            $buss_c = TaskModel::leftJoin('buss_info','y_order_task.buss_id','=','buss_info.bid')->select('buss_id','nick_name')->where('parent_id',$bid)->where('task_status',1)->orderBy('buss_id','asc')->groupBy('buss_id')->get()->toArray();
            $buss = json_encode($buss_c);
            return $buss;
        }
        return false;
    }
//    public function levelList(){
//        $buss_name = isset($_REQUEST['buss'])?$_REQUEST['buss']:'';
//        $wx_name = isset($_REQUEST['wxName'])?$_REQUEST['wxName']:'';
//        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
//        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
//        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'buss_name'=>$buss_name,'wx_name'=>$wx_name);
//        $data = HttpRequest::getApiServices('Operate/Level','levelList','GET',$parameter);
//        $wx_arr = array();
//        $buss_arr = array();
//        if(isset($data['data']['wx_name'])){
//            $wx_arr = $data['data']['wx_name'];
//        }
//        if(isset($data['data']['buss_name'])){
//            $buss_arr = $data['data']['buss_name'];
//        }
//        if(!empty($data['data']['data'])){
//            foreach($data['data']['data'] as $k=>$v){
//                $arr[] = array(
//                    'name'=>$k,
//                    'count'=>$v['count'],
//                    'buss_id'=>$v[0]['buss_id'],
//                );
//                unset($data['data']['data'][$k]['count']);
//                foreach($data['data']['data'][$k] as $kk=>$vv){
//                    $buss[$vv['level'].$vv['order_id'].$vv['wx_name']] = $vv;
//                }
//                krsort($buss);
//                unset($data['data']['data'][$k]);
//                $data['data']['data'][$k] = $buss;
//                $buss = array();
//            }
//            $setpage=  self::pagslist($data['data']['data'], $data['data']['count'], $pagesize);
//            $level_list = $setpage->toArray()['data'];
//            return view('Operate.priority',['post'=>$_REQUEST,'data'=>$level_list,'buss'=>$arr,'paginator'=>$setpage,'wx_name'=>$wx_arr,'buss_list'=>$buss_arr]);
//        }else{
//            return view('Operate.priority',['post'=>$_REQUEST,'wx_name'=>$wx_arr,'buss_list'=>$buss_arr]);
//        }
//    }
//    public function setLevel(){
//        $parameter = array(
//            'level' => $_POST['level'],
//            'order_id' => $_POST['order_id'],
//            'buss_id' => $_POST['buss_id']
//        );
//        $data = HttpRequest::getApiServices('Operate/Level','setLevel','GET',$parameter);
//        return $data['data'];
//    }
}