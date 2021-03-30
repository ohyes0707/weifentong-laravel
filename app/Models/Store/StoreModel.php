<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/3
 * Time: 15:12
 */
namespace App\Models\Store;
use App\Models\CommonModel;

class StoreModel extends CommonModel{

    protected $table = 'y_store';

    public $timestamps = false;

    public static function getBrand($area){
        //品牌id
        $brand_id = StoreModel::select('brand_id')->where('bid','=',$area)->get()->toArray();
        //品牌
        $brand = BrandModel::select('brand_id','brand_name')->whereIn('brand_id',$brand_id)->get()->toArray();
        return $brand;
    }
}