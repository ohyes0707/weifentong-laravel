<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/27
 * Time: 13:41
 */
namespace App\Models\Order;
use App\Models\CommonModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderModel extends CommonModel{
    protected $table = 'y_order';

    protected $primaryKey = 'order_id';

    public $timestamps = false;

    /**
     * 修改订单状态
     * @param $order_id    订单状态
     * @param $num         订单状态码
     * @return mixed
     */
    public static function updateStatus($order_id,$num){
        $data = OrderModel::where('order_id','=',$order_id)->update(['order_status'=>$num]);
        return $data;
    }

    public static function getOrderInfo($order_id){
        $data = OrderModel::where('order_id','=',$order_id)->first();
        if(!empty($data))
            $data = $data->toArray();
        return $data;
    }

    public static function setOrderLevel($level_list){
        foreach($level_list as $k=>$v){
            $data = OrderModel::where('order_id',$v)->update(['order_level'=>$k+1]);
        }
        foreach($level_list as $k=>$v){
            $order_id[] = $v;
        }
        $task_id = TaskModel::select('id','order_id','buss_id','level')->whereIn('order_id',$order_id)->where('task_status',1)->get()->toArray();
        foreach($task_id as $k=>$v){
            foreach($level_list as $kk=>$vv){
                if($v['order_id'] == $vv)
                    $task_id[$k]['new_level'] = $kk+1;
            }
        }
        $str = '';
        foreach($task_id as $k=>$v){
            if($str){
                $str .= ",(".$v['id'].",".$v['new_level'].")";
            }else{
                $str = "(".$v['id'].",".$v['new_level'].")";
            }
        }
        $insert = DB::insert("insert into y_order_task (id,level) values ".$str." on duplicate key update level=values(level)");
        foreach($task_id as $k=>$v){
            $redis = Redis::hget($v['buss_id'],$v['order_id']);
            $redis_arr = json_decode($redis,true);
            $redis_arr['alreadynum'] = $v['new_level'];
            Redis::hset($v['buss_id'],$v['order_id'],json_encode($redis_arr));
        }
        return $insert;
    }
}
