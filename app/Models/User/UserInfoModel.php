<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/21
 * Time: 20:18
 */

namespace App\Models\User;
use App\Models\CommonModel;

class UserInfoModel extends CommonModel {

    protected $table = 'user_info';

    protected $primaryKey = 'uid';

    public $timestamps = false;

    static public function getUserInfo($uid){
        $model = UserInfoModel::where('uid', '=', $uid)->first();
        return $model?$model->toArray():null;
    }
}