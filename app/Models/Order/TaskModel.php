<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/5
 * Time: 18:10
 */
namespace App\Models\Order;
use App\Models\CommonModel;
use App\Models\Order\OrderModel;
use App\Lib\HttpUtils\HttpRequest;

class TaskModel extends CommonModel{
    protected $table = 'y_order_task';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * 添加渠道任务
     * @param $arr
     * @return bool
     */
    public static function addTask($arr){
        $where = array(
            ['order_id','=',$_GET['order_id']],
            ['task_status','<>',3]
        );
        $list = TaskModel::where($where)->get()->toArray();
        
        $pause= TaskModel::zd($arr['db_insert']);
        if($pause==0){
            $upwhere = array(
                ['order_id','=',$_GET['order_id']]
            );
            OrderModel::where($upwhere)->update(['order_status'=>2]);
        }else{
            $upwhere = array(
                ['order_id','=',$_GET['order_id']]
            );
            OrderModel::where($upwhere)->update(['order_status'=>1]);
        }
        if($list){
            HttpRequest::getApiServices('user','getDelTask','POST',$list);
            $rtn = TaskModel::where($where)->update(['task_status'=>3]);
            if($rtn){
                //存入数据库
                $data = TaskModel::insert($arr['db_insert']);
                return $data;
            }else{
                return false;
            }
        }else{
            $data = TaskModel::insert($arr['db_insert']);
            return $data;
        }
    }

    public static function setTaskStatus($order_id,$sta){
        $where = array(
            ['order_id','=',$order_id],
            ['task_status','<>','2'],
            ['task_status','<>','3']
        );
        return TaskModel::where($where)->update(['task_status'=>$sta]);
    }
    
    public static function zd($param){
        $num=0;
        foreach ($param as $value) {
            if($value['task_status']==1){
                $num=$num+1;
            }
        }
        return $num;
    }
}