<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/3
 * Time: 15:10
 */
namespace App\Services\Impl\Store;
use App\Models\Store\StoreModel;
use App\Services\CommonServices;

class StoreOrderServicesImpl extends CommonServices{
    public static function getBrand($area){
        $data = StoreModel::getBrand($area);
        return $data;
    }
}