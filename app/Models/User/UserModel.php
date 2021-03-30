<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/21
 * Time: 14:13
 */
namespace App\Models\User;
use App\Models\CommonModel;

class UserModel extends CommonModel{

    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = false;


    static public function getUser($userId)
    {
        $model = UserModel::where('id', '=', $userId)->first();
        return $model?$model->toArray():null;
    }

    static public function changePwd($uid,$new_pwd){
        $create_time = UserModel::select('create_time')
                                    ->where('id','=',$uid)
                                    ->first()
                                    ->toArray();
        $model = UserModel::where('id','=',$uid)
                                ->update(['password'=>md5($new_pwd.$create_time['create_time'])]);
        return $model;
    }
}