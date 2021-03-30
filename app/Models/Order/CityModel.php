<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/13
 * Time: 19:30
 */
namespace App\Models\Order;
use App\Models\CommonModel;

class CityModel extends CommonModel{

    protected $table = 'data_iwifi';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     *
     * @param $area_name
     * @return mixed
     */
    static public function getCityByName($area_name){
        $area_id = CityModel::select('id')->where('name','=',$area_name)->orderBy('id','desc')->limit(1)->first();
        return $area_id;
    }
    static public function getCityById($id){
        $area_name = CityModel::select('name')->where('id','=',$id)->first();
        return $area_name;
    }
}