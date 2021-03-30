<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/13
 * Time: 19:27
 */
namespace App\Models\Order;
use App\Models\CommonModel;

class BussModel extends CommonModel{
    protected $table = 'buss_info';

    protected $primaryKey = 'bid';

    public $timestamps = false;

    /**
     * 获取渠道所在区域
     * @param $buss_id
     * @return mixed
     */
    static public function getBussArea($buss_id){
        $area = BussModel::select('buss_area')->where('bid','=',$buss_id)->first();
        return $area;
    }

    static public function getBussScene($buss_id){
        $scene = BussModel::select('buss_sence')->where('bid','=',$buss_id)->first();
        return $scene;
    }
}