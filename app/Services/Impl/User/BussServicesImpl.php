<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/16
 * Time: 11:44
 */
namespace App\Services\Impl\User;
use App\Models\User\BussModel;
use App\Services\CommonServices;

class BussServicesImpl extends CommonServices{
    public function changePwd($uid,$new_pwd){
        $data = BussModel::changePwd($uid,$new_pwd);
        return $data;
    }
}