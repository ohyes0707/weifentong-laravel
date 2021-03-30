<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/27
 * Time: 13:37
 */
namespace App\Services\Impl\Order;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Order\BussModel;
use App\Models\Order\CityModel;
use App\Models\Order\OrderModel;
use App\Models\Order\SceneModel;
use App\Models\Order\TaskModel;
use App\Models\Order\WxInfoModel;
use App\Models\Report\BussInfoModel;
use App\Models\User\AdminModel;
use App\Models\User\UserInfoModel;
use App\Services\CommonServices;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Config;

class OrderServicesImpl extends CommonServices{

    /**
     * 获取订单详情
     * @param $order_id
     * @return mixed
     */
    public static function  getOrderInfo($order_id){
        return OrderModel::getOrderInfo($order_id);
    }

    /**
     * 添加渠道任务
     * @param $arr
     * @return bool
     */
    public static function addTask($arr,$workinfo){
        $where = array(
            ['order_id','=',$_GET['order_id']],
            ['task_status','<>',3]
        );
        $old = TaskModel::where($where)->get()->toArray();
        if($old){
            $new_add = array();
            $new_status = array();
            $new_close = array();
            $new_day_fans = array();
            $new_total_fans = array();
            foreach($old as $k=>$v){
                $old_arr[$v['buss_id']] = $v;
            }
            foreach($arr['db_insert'] as $k=>$v){
                $new_arr[$v['buss_id']] = $v;
            }
            foreach($old_arr as $k=>$v){
                foreach($new_arr as $kk=>$vv){
                    if(!isset($old_arr[$vv['buss_id']]))
                        $new_add[$vv['buss_id']] = $vv['buss_id'];

                    if(isset($old_arr[$vv['buss_id']])  && $v['buss_id'] == $vv['buss_id'] && $v['task_status'] == 2 && $vv['task_status'] == 1)
                        $new_add[$vv['buss_id']] = $vv['buss_id'];

                    if(!isset($new_arr[$v['buss_id']]))
                        $new_close[$v['buss_id']] = $v['buss_id'];

                    if(isset($old_arr[$vv['buss_id']]) && $v['buss_id'] == $vv['buss_id'] && $v['task_status'] == 1 && $vv['task_status'] == 2)
                        $new_status[$vv['buss_id']] = $vv['buss_id'];

                    if($vv['plan_fans'] || $v['plan_fans']){
                        if(isset($old_arr[$vv['buss_id']]) && $old_arr[$vv['buss_id']]['plan_fans'] != $vv['plan_fans'])
                            $new_total_fans[$vv['buss_id']] = $vv['buss_id'];
                    }

                    if($vv['day_fans'] || $v['day_fans']){
                        if(isset($old_arr[$vv['buss_id']]) && $old_arr[$vv['buss_id']]['day_fans'] != $vv['day_fans']){
                            $new_day_fans[$vv['buss_id']] = $vv['buss_id'];
                        }
                    }
                }
            }
            $text = '';
            if(!empty($new_add)){
                $buss = BussInfoModel::select('nick_name')->whereIn('bid',$new_add)->get()->toArray();
                foreach($buss as $k=>$v){
                    if(isset($str)){
                        $str .= ','.$v['nick_name'];
                    }else{
                        $str = $v['nick_name'];
                    }
                }
                $text .= '开启渠道('.$str.')';
            }
            if(!empty($new_close)){
                $str = '';
                $buss = BussInfoModel::select('nick_name')->whereIn('bid',$new_close)->get()->toArray();
                foreach($buss as $k=>$v){
                    if(isset($str) && $str){
                        $str .= ','.$v['nick_name'];
                    }else{
                        $str = $v['nick_name'];
                    }
                }
                if($text){
                    $text .= ',关闭渠道('.$str.')';
                }else{
                    $text .= '关闭渠道('.$str.')';
                }
            }
            if(!empty($new_status)){
                $str = '';
                $buss = BussInfoModel::select('nick_name')->whereIn('bid',$new_status)->get()->toArray();
                foreach($buss as $k=>$v){
                    if(isset($str) && $str){
                        $str .= ','.$v['nick_name'];
                    }else{
                        $str = $v['nick_name'];
                    }
                }
                if($text){
                    $text .= ',暂停渠道('.$str.')';
                }else{
                    $text .= '暂停渠道('.$str.')';
                }
            }
            if(!empty($new_total_fans)){
                $str = '';
                $buss = BussInfoModel::select('nick_name')->whereIn('bid',$new_total_fans)->get()->toArray();
                foreach($buss as $k=>$v){
                    if(isset($str) && $str){
                        $str .= ','.$v['nick_name'];
                    }else{
                        $str = $v['nick_name'];
                    }
                }
                if($text){
                    $text .= ',修改渠道总涨粉('.$str.')';
                }else{
                    $text .= '修改渠道总涨粉('.$str.')';
                }
            }
            if(!empty($new_day_fans)){
                $str = '';
                $buss = BussInfoModel::select('nick_name')->whereIn('bid',$new_day_fans)->get()->toArray();
                foreach($buss as $k=>$v){
                    if(isset($str) && $str){
                        $str .= ','.$v['nick_name'];
                    }else{
                        $str = $v['nick_name'];
                    }
                }
                if($text){
                    $text .= ',修改渠道日涨粉('.$str.')';
                }else{
                    $text .= '修改渠道日涨粉('.$str.')';
                }
            }
            $order_id = isset($_GET['order_id'])?$_GET['order_id']:'';
            $uid = session()->get('operate_userid');
            $nick_name = AdminModel::select('username')->where('id','=',$uid)->first()->username;
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $ip = self::user_ip();
            $parameter = array('username'=>$nick_name,'userid'=>$uid,'useragent'=>$user_agent,'message'=>$text,'ip'=>$ip,'order_id'=>$order_id);
            HttpRequest::getApiServices('Operate/Order','orderLogAdd','POST',$parameter);
        }
        //云袋订单通知
        if($workinfo){
            //获取场景中文名称
            if($workinfo['scene'] != ''){
                $num = substr_count($workinfo['scene'],',');
                if($num == 1){
                    $str = substr($workinfo['scene'],1);
                }else{
                    $str = substr($workinfo['scene'],1,-1);
                }
                $scene_arr = explode(',',$str);
                foreach($scene_arr as $kk=>$vv){
                    if(!isset($workinfo['scene_ch'])){
                        $workinfo['scene'] = OrderServicesImpl::getSceneName($vv)->scene_name;
                    }else{
                        $workinfo['scene'] .= ','.OrderServicesImpl::getSceneName($vv)->scene_name;
                    }
                }
            }
            //云袋订单通知
            $YD_id = config('config.YUNDAI_ID');
            $YD_status = 0;
            if(empty($old)){
                foreach ($arr['db_insert'] as $k=>$v){
                    if($v['buss_id'] == $YD_id)
                        $YD_status = $v['task_status'];
                }
            }else{
                if(isset($new_close) && !empty($new_close) && isset($new_close[$YD_id])){
                    //关闭云袋渠道
                    $YD_status = 3;
                }elseif(isset($new_arr[$YD_id])){
                    //修改云袋订单渠道
                    $YD_status = $new_arr[$YD_id]['task_status'];
                }
            }
            $content = OrderModel::select('content')->where('order_id','=',$_GET['order_id'])->first();
            if($content){
                $content = $content->content;
            }else{
                $content = '';
            }
            if($YD_status != 0){
                $parameter = array('YD_status'=>$YD_status,'workinfo'=>json_encode($workinfo),'content'=>$content,'order_id'=>$_GET['order_id']);
                $data = HttpRequest::getApiServices('user/yundai','notice','POST',$parameter);
                Log::info(json_encode($data));
            }
        }
        return TaskModel::addTask($arr);
    }
    //获取用户真实IP
    public static function user_ip() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } elseif (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "";
        };
        return $ip;
    }
    /**
     * 修改订单状态
     * @param $order_id     订单id
     * @param $num          订单状态码
     * @return mixed
     */
    public static function update_status($order_id,$num){
        $bid = TaskModel::select('buss_id')->where('order_id','=',$order_id)->where('task_status','!=',3)->where('task_status','!=',4)->get()->toArray();
        if(!empty($bid)){
            foreach($bid as $k=>$v){
                $list[] = array(
                    'buss_id' => $v['buss_id'],
                    'order_id' => $_POST['order_id'],
                );
            }
            HttpRequest::getApiServices('user','getDelTask','POST',$list);
        }
        $ret = OrderModel::updateStatus($order_id,$num);
        if($num==3){
            $sta = 2;
            return TaskModel::setTaskStatus($order_id,$sta);
        }
        return $ret;
    }
    /**
     * 获得该订单该渠道热点区域权重值
     * @param $buss_id      渠道id
     * @param $hot_area     订单热点区域
     * @return mixed
     */
    public static function getHotWeight($buss_id,$hot_area){
        $area = BussModel::getBussArea($buss_id);
        if($area->buss_area){
            $city_id = CityModel::getCityByName($area->buss_area);
            $hot_id = ','.$city_id->id;
            if(strstr($hot_area,$hot_id)){
                $arr['weight_value'] = 5;
                $arr['is_hot_area'] = 1;
                return $arr;
            }
            $arr['weight_value'] = 0;
            $arr['is_hot_area'] = 2;
            return $arr;
        }
        $arr['weight_value'] = 0;
        $arr['is_hot_area'] = 2;
        return $arr;
    }

    /**
     * 获得该订单该渠道场景权重值
     * @param $buss_id      渠道id
     * @param $scene_list   订单场景
     * @return int
     */
    public static function getSceneWeight($buss_id,$scene_list){
        $scene_name = BussModel::getBussScene($buss_id);
        if($scene_name->buss_sence){
            $scene = SceneModel::getSceneId($scene_name->buss_sence);
            $scene_id = ','.$scene->id;
            if(strstr($scene_list,$scene_id)){
                $weight_value = 5;
                return $weight_value;
            }
            return $weight_value = 0;
        }
        return $weight_value = 0;
    }

    /**
     * 获取微信信息
     * @param $wx_id  微信id
     * @return mixed
     */
    public static function getWxInfo($wx_id){
        return WxInfoModel::getWxInfo($wx_id);
    }

    /**
     * 获取区域名
     * @param $id
     * @return mixed
     */
    public static function getCity($id){
        return CityModel::getCityById($id);
    }

    public static function getSceneName($id){
        return SceneModel::getSceneName($id);
    }

    /**
     * 设置订单优先级
     * @param $level_list  优先级数组
     */
    public static function setOrderLevel($level_list){
        return OrderModel::setOrderLevel($level_list);
    }
}