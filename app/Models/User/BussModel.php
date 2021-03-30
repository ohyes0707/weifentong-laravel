<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/16
 * Time: 11:40
 */
namespace App\Models\User;
use App\Models\CommonModel;

class BussModel extends CommonModel{
    protected $table = 'bussiness';

    protected $primaryKey = 'id';

    public $timestamps = false;

    static public function changePwd($uid,$new_pwd){
        $create_time = BussModel::select('create_time')
                                    ->where('id','=',$uid)
                                    ->first()
                                    ->toArray();
        $model = BussModel::where('id','=',$uid)
                                ->update(['password'=>md5($new_pwd.$create_time['create_time'])]);
        return $model;
    }
}