<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:40
 */

//用户操作控制器类
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Services\Impl\User\UserServicesImpl;
class UserController extends Controller
{
    /**
     * 获取用户信息by用户ID
     */
    public function getUserInfo(){
        $userid = session()->get('userid');
        $parameter = array('userId'=>$userid);
        $data = HttpRequest::getApiServices('user','getUserInfo','GET',$parameter);
        $user_info = $data['data'];
        return view('Home.personinfo',['user_info'=>$user_info ]);
    }

    /**
     * 登录页
     */
    public function login(){
        $userid = session()->get('userid');
        if(empty($userid)){
            return view('Home.index');
        }
        return redirect()->intended('home/report/reportlist');
    }

    /**
     * 登录验证
     */
    public function  doLogin(){

        $username  = $_POST['username'];
        $password  = $_POST['password'];
        $captcha  = $_POST['captcha'];
        $input = array(
            'captcha'=> $captcha,
            'username'=>$username,
            'password'=>$password,
        );
        $UserServicesImpl = new UserServicesImpl();
        $UserServicesImpl->convert($input);
        if($UserServicesImpl->isValid()){
            $res = $UserServicesImpl->doUserLogin($username,$password);
            if($res){
                $this->responseJson(1000);
            }
            $UserServicesImpl->messages()->add('login','用户名或密码错误');
        }
        $data = $UserServicesImpl->messages()->getMessages();
        $this->responseJson(1001,$data);
    }

    /**
     * 用户登出
     */
    public function loginOut(){
        session()->forget('userid');
        session()->forget('username');
        return redirect('home/user/login');
    }

    /**
     * 修改密码
     * @return \
     */
    public function changePwd(){
        if(isset($_POST['pwd'])){
            $parameter = array('userId'=>session()->get('userid'));
            $data = HttpRequest::getApiServices('user','getUserInfo','GET',$parameter);
            $pwd = isset($data['data']['password'])?$data['data']['password']:null;
            $create_time = isset($data['data']['create_time'])?$data['data']['create_time']:null;
            $old_pwd = $_POST['pwd'];
            if($pwd != md5($old_pwd.$create_time)){
                $res['message'] = '原始密码错误';
                echo  json_encode($res);
                exit();
            }else{
                $res['message'] = '原始密码正确';
                echo  json_encode($res);
                exit();
            }
        }
        return view('Home.changepwd');
    }
    public function changeOver(){
        if(isset($_POST['new_pwd']) && $_POST['type']=='none'){
            $new_pwd = $_POST['new_pwd'];
            $uid = session()->get('userid');
            $UserServicesImpl = new UserServicesImpl();
            $data = $UserServicesImpl->changePwd($uid,$new_pwd);
            if($data){
                return '修改成功';
            }else{
                return '修改失败';
            }
        }else if($_POST['type'] == 'block'){
            return '请输入正确的旧密码';
        }
        return view('Home.changepwd');
    }
}