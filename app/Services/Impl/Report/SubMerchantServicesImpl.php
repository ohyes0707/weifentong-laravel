<?php

namespace App\Services\Impl\Report;
use App\Models\Report\BussModel;
use App\Models\Report\BussInfoModel;
use App\Services\CommonServices;
use App\Lib\HttpUtils\HttpRequest;
use App\Models\Order\DataIwifiModel;
use App\Models\Order\CapacityLogModel;
use Illuminate\Support\Facades\Redis;


class SubMerchantServicesImpl extends CommonServices{
    
    static public function getFindOne($id) {
        $rest = BussModel::getFindOne($id);
        return $rest;
    }
    
    static public function getUpOne($id,$uparray,$where='id') {
        BussModel::where($where, $id) ->update($uparray);
    }
    
    static public function getDelOne($id,$uparray,$where='id') {
        BussModel::where($where, $id)->delete();
    }
    
    static public function getAddOne($uparray) {
        return BussModel::insertGetId($uparray);
    }
    
    static public function getFindBussInfoOne($id) {
        $rest = BussInfoModel::getFindBussInfoOne($id);
        return $rest;
    }
    
    static public function getAddBussInfoOne($uparray) {
        return BussInfoModel::insertGetId($uparray);
    }
    
    static public function getFindUserName($keycode) {
        $rest = BussModel::getFindUserName($keycode);
        return $rest;
    }
    
    static public function getFindChannelName($keycode) {
        $rest = BussInfoModel::getFindChannelName($keycode);
        return $rest;
    }
    
    static public function getUpBussInfoOne($id,$uparray,$where='bid') {
        BussInfoModel::where($where, $id) ->update($uparray);
        if($uparray['buss_area'] == ''){
            $uparray['buss_area'] = '全国';
        }
        Redis::hset('bidredis',$id,$uparray['buss_area']);
    }
    
    static public function getAreaId($str) 
    {
        $array = explode(',', $str);
        foreach ($array as $key => $value) 
        {
            $value2 = $value;
            if(strpos($value , '/') === false)
            {
                //省份
                $area = DataIwifiModel::getAreaId($value);
                $capacity=array(
                    'pid'=>$area['id'],
                    'area_id'=>$area['id'],
                );
                $city=null;
                $province=$value;
            }
            else {
                    //城市
                    $area = DataIwifiModel::getAreaId(explode('/', $value)[1]);
                    $value2 = explode('/', $value)[0];
            }    
            
            if($area['pid']==1){
                $capacity=array(
                    'pid'=>$area['id'],
                    'area_id'=>$area['id'],
                );
                $city=null;
                $province = $value2;
            }else{
                $capacity=array(
                    'pid'=>$area['pid'],
                    'area_id'=>$area['id'],
                );
                $city = explode('/', $value)[1];
                $province = explode('/', $value)[0];
                    //查询产能省份表是否存在数据不存在插入
                    $where['area_id'] = $area['pid'];
                    if(!CapacityLogModel::getIsExist($where)){
                        $where['city_name'] = null;
                        $where['province_name'] = $province;
                        $where['pid'] = $where['area_id'];
                        CapacityLogModel::setData($where);
                    } 
            }
            //查询产能表是否存在数据不存在插入
            if(!CapacityLogModel::getIsExist($capacity)){
                $capacity['city_name'] = $city;
                $capacity['province_name'] = $province;
                CapacityLogModel::setData($capacity);
            } 
        }
        
    }
    
        static public function getCapacityList(){
            $bid_province = CapacityLogModel::getBidProvince();
            $bid_city = CapacityLogModel::getBidCity();
            $capacity = CapacityLogModel::getCapacityList($bid_province,$bid_city);
            return  $capacity;
        }
        
        static public function getUpdataCapacityList($array){
            foreach ($array as $key => $value) {
                $updata = array(
                    'capacity_num' => $value[0],
                    'boy_num' => $value[1],
                    'girl_num' => $value[2]
                );
                CapacityLogModel::where('id','=',$key)->update($updata);
            }
        }
        
        static public function getCapacitySExcel($datearray,$query) {
            $excel[]=array('省份','城市','总量','剩余产能');
            foreach ($datearray as $value){
                if($query['sex'] == 1){
                    $num = $value['boy_num'];
                } elseif ($query['sex'] == 2) {
                    $num = $value['girl_num'];
                } else {
                    $num = $value['capacity_num'];
                }
                $excel[]=array(
                    $value['province_name'],'',$num,$num - $value['db_capacity_num']
                );
                if(isset($value['list'])&&$value['list']!=''){
                    foreach ($value['list'] as $value2) {
                            if($query['sex'] == 1){
                                $num2 = $value2['boy_num'];
                            } elseif ($query['sex'] == 2) {
                                $num2 = $value2['girl_num'];
                            } else {
                                $num2 = $value2['capacity_num'];
                            }
                        $excel[]=array(
                            '',$value2['city_name'],$num2,$num2 - $value2['db_capacity_num']
                        );       
                    }
                }
            }
            return $excel;
        }
        
        static public function getCapacityCExcel($datearray) {
            $excel[]=array('城市','总量','剩余产能');
            $excel[]=array(
                            $datearray['city_name'],$datearray['capacity_num'],$datearray['dbcapacity_num']
                        );   
            return $excel;
        }
}