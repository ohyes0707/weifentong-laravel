<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:50
 */

//工单&订单操作控制器类
namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Order\CityModel;
use App\Models\Order\OrderModel;
use App\Models\Order\TaskModel;
use App\Models\User\BussModel;
use App\Services\Impl\Order\OrderServicesImpl;
use App\Services\Impl\Order\WorkOrderServicesImpl;
use App\Services\Impl\Report\ReportServicesImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /**
     * 获取订单列表
     */
    public function getOrderList(){
        //查询条件
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:'';
        $end_date = isset($_REQUEST['endDate'])&&$_REQUEST['endDate']!=''?$_REQUEST['endDate']:'9999-12-30';
        $wx_name = isset($_REQUEST['wxName'])?$_REQUEST['wxName']:'';
        $order_status = isset($_REQUEST['state'])?$_REQUEST['state']:'';
        //获取订单列表
        $uid = isset($_SESSION['uid'])?$_SESSION['uid']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('start_date'=>$start_date,'end_date'=>$end_date,'wx_name'=>$wx_name,'order_status'=>$order_status,'uid'=>$uid,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/Order','getOrderList','GET',$parameter);
        $wx_list = isset($data['data']['wx_list'])?$data['data']['wx_list']:array();
        if(isset($data['data'])){
            if(isset($data['data']['data'])){
                $arr = $data['data']['data'];
                $count = isset($data['data']['count'])?$data['data']['count']:0;
                unset($data['data']['count']);
                unset($data['data']['wx_list']);
                $setpage=  self::pagslist($arr, $count, $pagesize);
                $userlist = $setpage->toArray()['data'];
                $list['paginator']=$setpage;
                $list['arr']=$userlist;
            }
            $list['post'] = $_REQUEST;
            $list['wx_list'] = $wx_list;
            $list['term']=$parameter;
            return view('Operate.orderlist',$list);
        }else{
            $list['wx_list'] = $wx_list;
            return view('Operate.orderlist',$list);
        }

    }
    /**
     * 修改订单
     */
    public function orderDetail(){
        $work_id = $_GET['work_id'];
        $order_id = $_GET['order_id'];
        //获取工单信息
        $data = WorkOrderServicesImpl::getWorkOrderInfo($work_id);
        $date = date('Y-m-d',time());
        $time = date('H:i',time());
        $order_time = 1;
        if( $date<$data['w_start_date'] || $date>$data['w_end_date'] ){
            $order_time = 0;
        }
/*        if( $time<$data['w_start_time'] || $time>$data['w_end_time'] ){
            $order_time = 0;
        }*/
        if ($data['w_start_time']>$data['w_end_time']) {
            if($time>$data['w_start_time']||$time<$data['w_end_time']){

            }else{
                $order_time = 0;
            }
        }else{
            if($time>$data['w_start_time']&&$time<$data['w_end_time']){

            }else{
                $order_time = 0;
            }
        }
        if(isset($_GET['luo_test'])){echo $order_time; }
        //判断是否为属性订单
        if($data['sex'] !=0 || $data['fans_tag']!= ''){
            $attr = 1;
        }else{
            $attr = 0;
        }
        //获取该订单已选择的渠道信息
        $condition = array('order_id'=>$order_id);
        $buss_list = HttpRequest::getApiServices('Operate/Buss','setBussList','GET',$condition);
        $order_day_fans = isset($buss_list['data'][0]['order_day_fans'])?$buss_list['data'][0]['order_day_fans']:0;
        if(isset($buss_list['data']['parent_total'])){
            $parent_total = $buss_list['data']['parent_total'];
            unset($buss_list['data']['parent_total']);
        }else{
            $parent_total = array();
        }
        //获取该订单公众号名称
        $wx_name = DB::table('y_order')->select('wx_name')->where('order_id','=',$order_id)->first();
        //获取全部渠道列表
        $buss_total = HttpRequest::getApiServices('Operate/Buss','getBussList','GET');
        //筛选渠道（不允许异地投放）
//        if($data['hot_area'] != ''){
//            $str = substr($data['hot_area'],1,-1);
//            $hot = explode(',',$str);
//            foreach($hot as $k=>$v){
//                $hot_area[] = OrderServicesImpl::getCity($v)->name;
//            }
//            $hot_str = implode(',',$hot_area);
//            foreach($buss_total['data'] as $k=>$v){
//                if(!empty($buss_total['data'][$k][$v['username']])){
//                    foreach($buss_total['data'][$k][$v['username']] as $kk=>$vv){
//                        if($vv['buss_area'] != '' && !strstr($hot_str,$vv['buss_area']))
//                            unset($buss_total['data'][$k][$v['username']][$kk]);
//                    }
//                }else{
//                    if($v['buss_area'] != '' && !strstr($hot_str,$v['buss_area']))
//                        unset($buss_total['data'][$k]);
//                }
//            }
//        }
        //计算已选渠道合计总涨粉、日涨粉、已涨粉总量、当日涨粉量
        $buss_arr['total_fans'] = 0;
        $buss_arr['day_fans'] = 0;
        $buss_arr['total_up_fans'] = 0;
        $buss_arr['day_up_fans'] = 0;
        $buss_arr['day_un_fans'] = 0;
        if(!empty($buss_list['data'])){
            foreach($buss_list['data'] as $k=>$v){
                $buss_arr[$v['buss_id']] = $buss_list['data'][$k];
                $buss_arr['total_fans'] += (int)$v['plan_fans'];
                $buss_arr['day_fans'] += (int)$v['day_fans'];
                $buss_arr['total_up_fans'] += (int)$v['total_fans'];
                $buss_arr['day_up_fans'] += (int)$v['subscribe_today'];
                $buss_arr['day_un_fans'] += (int)$v['un_subscribe_today'];
            }
        }
        //获取场景中文名称
        if($data['scene'] != ''){
            $num = substr_count($data['scene'],',');
            if($num == 1){
                $str = substr($data['scene'],1);
            }else{
                $str = substr($data['scene'],1,-1);
            }
            $arr = explode(',',$str);
            foreach($arr as $kk=>$vv){
                if(!isset($data['scene_ch'])){
                    $data['scene_ch'] = OrderServicesImpl::getSceneName($vv)->scene_name;
                }else{
                    $data['scene_ch'] .= ','.OrderServicesImpl::getSceneName($vv)->scene_name;
                }
            }
        }
        //获取所有订单的优先级
        $level_pagesize = 100;
        $order_list = HttpRequest::getApiServices('Operate/Order','getOrderList','GET',$para = array('order_status'=>1,'pagesize'=>$level_pagesize));
        foreach($order_list['data']['data'] as $k=>$v){
            $order_arr[$v['wx_name']] = array(
                'wx_name'=>$v['wx_name'],
                'order_id'=>$v['order_id'],
                'order_level'=>$v['order_level'],
            );
        }
        foreach($order_arr as $k=>$v){
            if(!isset($order_arr[$wx_name->wx_name])){
                $order_arr[0] = array(
                    'wx_name'=>$wx_name->wx_name,
                    'order_id'=>$order_id,
                    'order_level'=>0,
                );
            }
        }
        $order_list = array();
        foreach($order_arr as $k=>$v){
            $order_list[$v['order_level']] = $v;
        }
        krsort($order_list);
        $user_id = $data['user_id'];
        $user_name = DB::table('user_info')->select('nick_name')->where('uid','=',$user_id)->first()->nick_name;
        foreach($parent_total as $k=>$v){
            foreach($buss_arr as $kk=>$vv){
                if(is_array($buss_arr[$kk])){
                    foreach($buss_arr[$kk] as $key=>$val){
                        if($key == 'parent_id' && $val == $k && $buss_arr[$kk]['subscribe_today'] > 0 && $buss_arr[$kk]['un_subscribe_today']>0){
                            $parent_total[$k]['child_unper'][] = sprintf('%.2f',$buss_arr[$kk]['un_subscribe_today']/$buss_arr[$kk]['subscribe_today']*100);
                        }
                    }
                }
            }
        }
        foreach($parent_total as $k=>$v){
            if(isset($v['child_unper']) && !empty($v['child_unper'])){
                $count = count($parent_total[$k]['child_unper']);
                $unper = 0;
                foreach($parent_total[$k]['child_unper'] as $kk=>$vv){
                    $unper += $vv;
                }
                $parent_total[$k]['child_unper'] = sprintf('%.2f',$unper/$count).'%';
            }else{
                $parent_total[$k]['child_unper'] = '';
            }
        }
        return view('Operate.orderdetail',['order_time'=>$order_time,'order_day_fans'=>$order_day_fans,'parent_total'=>$parent_total,'attr'=>$attr,'user_name'=>$user_name,'buss_total'=>$buss_total['data'],'data'=>$data,'buss_list'=>$buss_arr,'order_id'=>$order_id,'work_id'=>$work_id,'wx_name'=>$wx_name->wx_name,'order_list'=>$order_list]);
    }

    /**
     * 分配渠道
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getBuss(){
        //订单优先级
        if(isset($_POST['priority']) && !empty($_POST['priority'])){
            foreach($_POST['priority'] as $k=>$v){
                $level_list[] = $k;
            }
        }
        $level_list = array_reverse(array_reverse($level_list),true);
        //筛选出已选择渠道相关信息
        foreach($_POST['total_fans'] as $k=>$v){
            if(isset($_POST['check'][$k])){
                $list[$k]['total_fans'] = $v;
                $list[$k]['day_fans'] = $_POST['day_fans'][$k];
                $list[$k]['one_price'] = $_POST['one_price'][$k];
                $list[$k]['status'] = $_POST['status'][$k];
//                $list[$k]['p_buss'] = $_POST['p_buss'][$k];
                $list[$k]['pbid'] = $_POST['pbid'][$k];
                $list[$k]['user_type'] = isset($_POST['user_type'][$k])?$_POST['user_type'][$k]:0;
            }
        }
        $date_total_fans = isset($_POST['date_total_fans'])?$_POST['date_total_fans']:0;
        //获取渠道信息
        foreach($list as $k=>$v){
            $bid[] = $k;
        }
        $buss = BussModel::select('id','cost_price')->whereIn('id',$bid)->get()->toArray();
        //订单单价
        $price = OrderServicesImpl::getOrderInfo($_POST['order_id'])['o_per_price'];
        //获取工单基本信息
        $parameter['workId'] = $_POST['work_id'];
        $workinfo = HttpRequest::getApiServices('user','getWOrderInfo','GET',$parameter);
        //对要插入任务表中的数据进行处理
        $i = 0;
        foreach($list as $k=>$v){
            $arr['db_insert'][$i] = array(
                'plan_fans' => $v['total_fans'],
                'day_fans' => $v['day_fans'],
                'order_id' => $_POST['order_id'],
                'buss_id' => $k,
                'task_status' => $v['status'],
                'o_start_date' => isset($workinfo['data']['w_start_date'])?$workinfo['data']['w_start_date']:'',
                'o_end_date' => isset($workinfo['data']['w_end_date'])?$workinfo['data']['w_end_date']:'',
                'o_start_time' => isset($workinfo['data']['w_start_time'])?$workinfo['data']['w_start_time']:'',
                'o_end_time' => isset($workinfo['data']['w_end_time'])?$workinfo['data']['w_end_time']:'',
                'check_status' => $workinfo['data']['check_status'],
                'sex' => $workinfo['data']['sex'],
                'hot_area' => $workinfo['data']['hot_area'],
                'fans_tag' => $workinfo['data']['fans_tag'],
                'scence' => $workinfo['data']['scene'],
                'task_time' => time(),
                'parent_id' => $v['pbid'],
                'user_type' => $v['user_type'],
                'one_price'=>$v['one_price'],
                'device_type'=>$workinfo['data']['device_type'],
                'order_day_fans'=>$date_total_fans,
            );
            foreach($level_list as $kk=>$vv){
                if($vv == $_POST['order_id']){
                    $arr['db_insert'][$i]['level'] = $kk+1;
                }
            }
            $final_price = 0;
            foreach($buss as $kk=>$vv){
                if($vv['id'] == $k)
                    $final_price = $vv['cost_price'];
            }
            if($v['one_price']){
                $arr['db_insert'][$i]['final_price'] = $v['one_price'];
            }elseif($final_price){
                $arr['db_insert'][$i]['final_price'] = $final_price;
            }else{
                $arr['db_insert'][$i]['final_price'] = $price;
            }
            $i += 1;
        }
        //计算权重值和redis数据
        foreach($arr['db_insert'] as $k=>$v){
//            $arr['db_insert'][$k]['weight_value'] = 0;
            if($v['task_status']==1){
                $arr['redis'][$v['buss_id']][$v['order_id']]['total_fans'] = $v['plan_fans']==''||$v['plan_fans']==0?$workinfo['data']['w_total_fans']:$v['plan_fans'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['date_fans'] = $v['day_fans']==''|| $v['day_fans']==0?$workinfo['data']['w_total_fans']:$v['day_fans'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['start_date'] = $workinfo['data']['w_start_date'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['end_date'] = $workinfo['data']['w_end_date'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['start_time'] = $workinfo['data']['w_start_time'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['end_time'] = $workinfo['data']['w_end_time'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['check_status'] = $workinfo['data']['check_status'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['user_type'] = $v['user_type'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['device_type'] = $v['device_type'];
                $weight_value = 0;
                //优先级分数
//                if(isset($v['abs_priority']))
//                    $weight_value += (10-($v['abs_priority']+1))*5;
                //单价分数
//                if($workinfo['data']['w_per_price']>2.5){
//                    $weight_value += 5;
//                }else{
//                    $weight_value += ceil($workinfo['data']['w_per_price']/0.5);
//                }
                //热点区域分数和redis数据
//                $hot = OrderServicesImpl::getHotWeight($v['buss_id'],$v['hot_area']);
//                $weight_value += $hot['weight_value'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['is_hot_area'] = 1;
                $arr['redis'][$v['buss_id']][$v['order_id']]['hot_area'] = $v['hot_area'];
                //场景分数和redis数据
//                $scene = OrderServicesImpl::getSceneWeight($v['buss_id'],$v['scence']);
//                $weight_value += $scene;
//                $arr['db_insert'][$k]['weight_value'] = $weight_value;
//                $arr['redis'][$v['buss_id']][$v['order_id']]['alreadynum'] = $weight_value;
                //是否为精准投放redis数据
                if(isset($workinfo['data']['isprecision']) && $workinfo['data']['isprecision']!=''){
                    $arr['redis'][$v['buss_id']][$v['order_id']]['isprecision'] = 1;
                }else{
                    $arr['redis'][$v['buss_id']][$v['order_id']]['isprecision'] = 2;
                }
                //粉丝标签汉字版redis数据
                $arr['redis'][$v['buss_id']][$v['order_id']]['fans_tag'] = $v['fans_tag'];
//                $tag = explode(',',substr($v['fans_tag'],1,-1));
//                if(!empty($tag[0])){
//                    foreach($tag as $vv){
//                        if(!isset($arr['redis'][$v['buss_id']][$v['order_id']]['fans_tag'])){
//                            $arr['redis'][$v['buss_id']][$v['order_id']]['fans_tag'] = DB::table('data_iwifi')->select('name')->where('id','=',$vv)->first()->name;
//                        }else{
//                            $arr['redis'][$v['buss_id']][$v['order_id']]['fans_tag'] .= ','.DB::table('data_iwifi')->select('name')->where('id','=',$vv)->first()->name;
//                        }
//                    }
//                }else{
//                    $arr['redis'][$v['buss_id']][$v['order_id']]['fans_tag'] = '';
//                }
                //微信ghid redis数据
                $wx_info = OrderServicesImpl::getWxInfo($workinfo['data']['wx_id']);
                if($wx_info && $wx_info->ghid!=''){
                    $arr['redis'][$v['buss_id']][$v['order_id']]['ghid'] = $wx_info->ghid;
                }else{
                    $arr['redis'][$v['buss_id']][$v['order_id']]['ghid'] = '';
                }
                //是否为属性订单redis数据
                if($workinfo['data']['sex']==0 && $workinfo['data']['hot_area'] != '' && $workinfo['data']['fans_tag'] == '' && $workinfo['data']['scene'] == ''){
                    $arr['redis'][$v['buss_id']][$v['order_id']]['isattribute'] = 2;
                }elseif($workinfo['data']['sex']==0 && $workinfo['data']['hot_area'] == '' && $workinfo['data']['fans_tag'] == '' && $workinfo['data']['scene'] == ''){
                    $arr['redis'][$v['buss_id']][$v['order_id']]['isattribute'] = 2;
                }else{
                    $arr['redis'][$v['buss_id']][$v['order_id']]['isattribute'] = 1;
                }
                //性别redis数据
                $arr['redis'][$v['buss_id']][$v['order_id']]['is_sex'] = $workinfo['data']['sex'];
                //content字段redis数据
                $content = OrderServicesImpl::getOrderInfo($_POST['order_id'])['content'];
                $arr['redis'][$v['buss_id']][$v['order_id']]['content'] = $content;
                //价格redis数据
                if($v['one_price']){
                    $arr['redis'][$v['buss_id']][$v['order_id']]['price'] = $v['one_price'];
                }else{
                    //渠道结算价
                    $buss_price = BussModel::select('cost_price')->where('id',$v['buss_id'])->first();
                    if($buss_price->cost_price){
                        $arr['redis'][$v['buss_id']][$v['order_id']]['price'] = $buss_price->cost_price;
                    }else{
                        $arr['redis'][$v['buss_id']][$v['order_id']]['price'] = $price;
                    }
                }
                //优先级
                $arr['redis'][$v['buss_id']][$v['order_id']]['alreadynum'] = isset($v['level'])?$v['level']:'';
                //新老用户redis数据
//                if($arr['redis'][$v['buss_id']][$v['order_id']]['isattribute']==1){
//                    $arr['redis'][$v['buss_id']][$v['order_id']]['user_type'] = 2;
//                }
                //订单日涨粉限制
                $arr['redis'][$v['buss_id']][$v['order_id']]['date_total_fans'] = $date_total_fans;
            }
        }
        //查询订单当前状态
        $status = OrderServicesImpl::getOrderInfo($_POST['order_id'])['order_status'];
        if($status==3)
            return $this->alert_back('订单已关闭，无法设置渠道');
        //判断是否存在已涨粉订单
        $wx_name = $_POST['wx_name'];
        if($wx_name){
            $order = OrderModel::select('order_id')->where('wx_name',$wx_name)->where('order_status',1)->where('order_type','=',1)->first();
            if($order && isset($arr['redis']) && !empty($arr['redis']) && $order->order_id != $_POST['order_id'])
                return $this->alert_back('存在涨粉中订单，无法开启');
        }
        //修改订单优先级
        $order_level = OrderServicesImpl::setOrderLevel($level_list);
        //添加渠道任务
        $rtn = OrderServicesImpl::addTask($arr,$workinfo['data']);
        if($rtn){
            //添加redis数据
            if(isset($arr['redis'])){
                $condition = array('redis'=>$arr['redis']);
                HttpRequest::getApiServices('Operate/Order','setRedis','POST',$condition);
            }
            //修改工单状态
            $sta = 3;
            WorkOrderServicesImpl::setWorkStatus($_POST['work_id'],$sta);
            //修改报备状态
            $ret = 4;
            ReportServicesImpl::setReportStatus($workinfo['data']['report_id'],$ret);
            return redirect('operate/order/list');
        }else{
            $this->alert_back('提交失败2');
        }
    }

    /**
     * 关闭订单
     * @return mixed
     */
    public function closeOrder(){
        if($_POST['order_id']==153 || $_POST['order_id']==155 || $_POST['order_id']==211){
             $this->alert_back('特殊订单无法关闭');
        }
        $status = OrderServicesImpl::update_status($_POST['order_id'],$_POST['status']);
        if($status){
             $this->alert_back('订单已关闭');
        }
        return $status;
    }

    /**
     * 关闭订单和渠道接口
     * @param $appid  appid
     */
    public function closeTask($appid){
        $parameter = array(
            'appid'=>$appid ,
        );
        $data = HttpRequest::getApiServices('Operate/Order','closeTask','GET',$parameter);
        return $data['data'];
    }

    /**
     * 订单查询
     */
    public function orderSearch(){
        $excel = isset($_REQUEST['excel'])?$_REQUEST['excel']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $date = isset($_REQUEST['date'])?$_REQUEST['date']:date('Y-m-d',time());
        $parameter = array('date'=>$date,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/Order','orderSearch','GET',$parameter);
        if($data['data']){
            $pagesizenew= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
            $parameter = array('date'=>$date,'page'=>$page,'pagesize'=>$pagesizenew);
            $data_total = HttpRequest::getApiServices('Operate/Order','orderSearch','GET',$parameter);
            $total = 0;
            foreach($data_total['data']['data'] as $k=>$v){
                $total += $v['day_fans'];
            }
            if($excel == 1){
                foreach($data['data']['data'] as $k=>$v){
                    $arr[] = array(
                        'wx_name'=>$v['wx_name'],
                        'hot_area'=>$v['hot_area'],
                        'sex'=>$v['sex'],
                        'day_fans'=>$v['day_fans'],
                    );
                }
                $name = '订单查询';
                $head['head'] = array('订单名称','地区属性','性别','当日涨粉量');
                self::export($name,$head,$arr);
            }
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $list = $paginator->toArray()['data'];
            return view('Operate.orderCheck',['list'=>$list,'paginator'=>$paginator,'total'=>$total,'date'=>$date,'post'=>$_REQUEST]);
        }
        return view('Operate.orderCheck',['date'=>$date]);
    }
    //订单粉丝详情
    public function orderFans(){
        $order_id = isset($_POST['order_id'])?$_POST['order_id']:'';
        $start_date = isset($_POST['startDate'])?$_POST['startDate'].' 00:00:01':'';
        $end_date = isset($_POST['endDate'])?$_POST['endDate'].' 23:59:59':'';
        $parameter = array('order_id'=>$order_id,'start_date'=>$start_date,'end_date'=>$end_date);
        $data = HttpRequest::getApiServices('Operate/Order','orderFans','GET',$parameter);
        if($order_id){
            $wx_name = OrderModel::select('wx_name')->where('order_id',$order_id)->first();
            if($wx_name){
                $wx_name = $wx_name->wx_name;
            }else{
                $wx_name = '';
            }
        }
        if($data['data']){
            foreach($data['data'] as $k=>$v){
                if(strpos($v['nickname'],'=') === 0){ $data['data'][$k]['nickname'] = "'".$v['nickname']; }
                if($v['un_date'] == '1970-01-01 00:00:00'){
                    $data['data'][$k]['un_date'] = '';
                }else{
                    $data['data'][$k]['un_date'] = substr($v['un_date'],0,10);
                }

                //$data['data'][$k]['date'] = substr($v['date'],0,10);

                if($v['province'] == '')
                    $data['data'][$k]['province'] = '未知省份';

                if($v['city'] == '')
                    $data['data'][$k]['city'] = '未知城市';

                if($v['sex'] == 1){
                    $data['data'][$k]['sex'] = '男';
                }elseif($v['sex'] == 2){
                    $data['data'][$k]['sex'] = '女';
                }else{
                    $data['data'][$k]['sex'] = '未知';
                }
            }
            $head['head'] = array('openid','关注时间','昵称','取关时间','省份','城市','性别');
            self::export('粉丝详情-'.$wx_name,$head,$data['data']);
        }else{
            $this->alert_back('没有数据，导出失败');
        }
    }
    public function orderLogs(){
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $order_id = isset($_REQUEST['order_id'])?$_REQUEST['order_id']:'';
        $uid = isset($_REQUEST['uid'])?$_REQUEST['uid']:'';
        $start_date = isset($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
        $end_date = isset($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
        $parameter = array('order_id'=>$order_id,'uid'=>$uid,'start_date'=>$start_date,'end_date'=>$end_date,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/Order','orderLogs','GET',$parameter);
        if($data['data']){
            if(isset($data['data']['data']) && !empty($data['data']['data'])){
                $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
                $list = $paginator->toArray()['data'];
                return view('Operate.operationLog',['list'=>$list,'paginator'=>$paginator,'user'=>$data['data']['user'],'post'=>$_REQUEST,'uid'=>$uid,'order_id'=>$order_id,'startDate'=>$start_date,'endDate'=>$end_date]);
            }
        }
        return view('Operate.operationLog',['order_id'=>$order_id,'startDate'=>$start_date,'endDate'=>$end_date]);
    }
}