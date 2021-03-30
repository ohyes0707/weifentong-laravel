<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/21
 * Time: 14:22
 */
namespace App\Services\Impl\User;

use App\Services\CommonServices;
use App\Models\User\UserModel;
use App\Models\User\UserInfoModel;
use App\Lib\HttpUtils\HttpRequest;

class UserServicesImpl extends CommonServices{
    /**
     * 转换用户输入为对象模型
     * @param Input $input
     */
    public function convert($input) {
        //-----------------------------------------------------
        // 字段验证
        //-----------------------------------------------------
        $rule = array(
            "captcha" =>'required|captcha',
            "username" => "required|max:15",
            "password" => "required|between:3,16",
        );

        $message = array(
            'captcha' => '验证码',
            'username' => '用户名',
            'password' => '密码',
        );

        $this->init($input, $rule ,$message);
    }


    /**
     * 获取用户信息
     * @param $userId
     * @return null
     */
    public function getUser($userId)
    {
        return UserModel::getUser($userId);
    }

    /**
     * 获取用户相关信息
     * @param $uid
     * @return null
     */
    public function getUserInfo($uid)
    {
        return UserInfoModel::getUserInfo($uid);
    }

    /**
     * 用户登录
     * @param $username
     * @param $password
     * @return null
     */
    public function doUserLogin($username,$password){
        $postData = array('username'=>$username,'password'=>$password);
        $res = HttpRequest::getApiServices('home','doUserLogin','POST',$postData);
        if($res['success']&&$res['data']['is_login']){
            session()->put('userid',$res['data']['id']);
            session()->put('username',$res['data']['username']);
            session()->save();
            return true;
        }
        return false;
    }

    /**
     * 运营登录
     * @param $username
     * @param $password
     * @return null
     */
    public function doOperateLogin($username,$password){
        $postData = array('username'=>$username,'password'=>$password);
        $res = HttpRequest::getApiServices('operate','doOperateLogin','POST',$postData);
        if($res['success']&&$res['data']['is_login']){
            session()->put('operate_userid',$res['data']['id']);
            session()->put('operate_username',$res['data']['username']);
            $this->getLeftViewShow();
            session()->save();
            return true;
        }
        return false;
    }

    /**
     * 代理登录
     * @param $username
     * @param $password
     * @return null
     */
    public function doAgentLogin($username,$password){
        $postData = array('username'=>$username,'password'=>$password);
        $res = HttpRequest::getApiServices('agent','doAgentLogin','POST',$postData);
        if($res['success']&&$res['data']['is_login']){
            session()->put('agent_userid',$res['data']['id']);
            session()->put('agent_username',$res['data']['username']);
            // $this->getLeftViewShow();
            session()->save();
            return true;
        }
        return false;
    }

    /**
     * 获取左视图的具体样式
     */
    public function getLeftViewShow(){

        $id  = session()->get('operate_userid');
        $postData = array('adminid'=>$id);
        $res = HttpRequest::getApiServices('operate','getleftView','GET',$postData);
        session()->put('leftdata',$res);
        foreach($res['data']['data'] as $key=>$value){
            $urlArray =explode('/',$value['url']);
            $sessionkey = $urlArray[count($urlArray)-1];
            session()->put($sessionkey,$value['operate']);
        }

    }


 //
    /**
     * 商家登录
     * @param $username
     * @param $password
     * @return null
     */
    public function doBussLogin($username,$password){
        $postData = array('username'=>$username,'password'=>$password);
        $res = HttpRequest::getApiServices('buss','doBussLogin','POST',$postData);
        if($res['success']&&$res['data']['is_login']){
            session()->put('buss_id',$res['data']['id']);
            session()->put('buss_name',$res['data']['username']);
            session()->put('parent_id',$res['data']['pbid']);
            session()->save();
            return true;
        }
        return false;
    }

    public function changePwd($uid,$new_pwd){
        $data = UserModel::changePwd($uid,$new_pwd);
        return $data;
    }
}