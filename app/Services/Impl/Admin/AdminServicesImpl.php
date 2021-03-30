<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/16
 * Time: 11:44
 */
namespace App\Services\Impl\Admin;
use App\Models\User\AdminModel;
use App\Services\CommonServices;

class AdminServicesImpl extends CommonServices{
    public function changePwd($uid,$new_pwd){
        $data = AdminModel::changePwd($uid,$new_pwd);
        return $data;
    }
}