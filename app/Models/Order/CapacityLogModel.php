<?php

namespace App\Models\Order;

use App\Models\CommonModel;
use Illuminate\Support\Facades\DB;

class CapacityLogModel extends CommonModel{

    protected $table = 'y_capacity_norm';

    protected $primaryKey = 'id';

    public $timestamps = false;

    
    /**
     * 判断是否存在数据
     */
    static public function getIsExist($arr){
        $model = CapacityLogModel::select()
                ->where($arr)
                ->get()
                ->first();
        return $model?TRUE:FALSE;
    }
    
    static public function setData($arr) {
        CapacityLogModel::insert($arr);
    }
    
    /**
     * 获取省份
     */
    static public function getBidProvince(){
        $field = array(
            'id',
            'pid',
            'province_name',
            'boy_num',
            'girl_num',
            DB::raw('sum(capacity_num) as capacity_num')
        );
        $model = CapacityLogModel::select($field)
                ->where('area_id','<=',35)
                ->groupBy('pid')
                ->get();

        return $model?$model->toArray():null;
    }

    /**
     * 获取城市
     */
    static public function getBidCity(){
        $model = CapacityLogModel::select()
                ->get();
        //print_r($model->toArray());
        return $model?$model->toArray():null;
    }
    
    static public function getCapacityList($bid_province,$bid_city) {
        $newarray = array();
        foreach ($bid_province as $key => $value) {
            $newarray[$key] = $value;
            foreach ($bid_city as $key2 => $value2){
                if($value2['province_name']==$value['province_name']&&$value2['city_name']!=''){
                    $newarray[$key]['list'][] = $value2;
                }
                
            }
        }
        return $newarray;
    }
}