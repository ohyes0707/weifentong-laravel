<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/15
 * Time: 17:48
 */
namespace App\Models\Order;
use App\Models\CommonModel;

class WxInfoModel extends CommonModel{
    protected $table = 'wx_info';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public static function getWxInfo($wx_id){
        $info = WxInfoModel::where('id','=',$wx_id)->first();
        return $info;
    }
}