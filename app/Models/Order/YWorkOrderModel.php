<?php

namespace App\Models\Order;

use App\Models\CommonModel;

class YWorkOrderModel extends CommonModel{

    protected $table = 'y_work_order';

    protected $primaryKey = 'id';

    public $timestamps = false;


    /**
     * 工单
     * @param $id          工单ID
     * @param $stat        工单现在状态
     * @param $new         工单需要修改成的状态
     * @return array
     */
    static public function getUpWOrderStat($id,$stat,$new,$reason)
    {
        $map=array(
            'id'=>$id,
            'w_status'=>$stat,
        );
        $model = YWorkOrderModel::where($map)->update(array('w_status' => $new,'w_reject'=>$reason));
        
        return $model;
    }

    /**
     * 获取工单详情
     * @param $work_id
     * @return array
     */
    public static function getWorkOrderInfo($work_id){
        $data = YWorkOrderModel::select('w_total_fans','w_least_fans','w_advis_fans','w_max_fans','w_per_price','w_start_date','w_end_date','w_start_time','w_end_time','sex','hot_area','fans_tag','scene','check_status','user_id','device_type')
                                    ->where('id','=',$work_id)
                                    ->first();
        if(!empty($data)){
            $data = $data->toArray();
        }else{
            $data = array();
        }
        return $data;
    }

    public static function setWorkStatus($work_id,$num){
        $data = YWorkOrderModel::where('id','=',$work_id)->update(['w_status'=>$num]);
        return $data;
    }


}