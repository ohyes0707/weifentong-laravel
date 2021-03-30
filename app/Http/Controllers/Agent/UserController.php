<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:52
 */

//运营用户操作控制器类
namespace App\Http\Controllers\Agent;
use App\Services\Impl\Admin\AdminServicesImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Services\Impl\User\UserServicesImpl;

class UserController extends Controller
{
    /**
     * 获取用户信息by用户ID
     */
    public function getUserInfo(){
        $userid = session()->get('agent_userid');
        $parameter = array('userId'=>$userid);
        $data = HttpRequest::getApiServices('user','getUserInfo','GET',$parameter);
        $user_info = $data['data'];
        return view('Agent.personinfo',['user_info'=>$user_info ]);
    }

    /**
     * 代理登出
     */
    public function loginOut(){
        session()->forget('agent_userid');
        session()->forget('agent_username');
        return redirect('agent/user/login');
    }

    /**
     *  运营权限页面具体显示
     */
    public function getSession(){
        $sessionKey =  $_GET['sessionKey'];
        $sessionValue = session()->get($sessionKey);

        echo $sessionValue;
    }

    /**
     * 运营系统登录页
     */
    public function login(Request $request){
        //获取当前的域名的头部  
        $url_head = strstr($_SERVER['SERVER_NAME'], '.', TRUE);
        //获取来源网址,即点击来到本页的上页网址  
        // echo $_SERVER["HTTP_REFERER"];  
        // echo $_SERVER['REQUEST_URI'];//获取当前域名的后缀  
        // echo $_SERVER['HTTP_HOST'];//获取当前域名  
        // die;

        if($url_head != 'agent'){
            $parameter = array('url_head'=>$url_head);
            //根据域名获取代理信息
            $data = HttpRequest::getApiServices('agent','getAgentInfo','GET',$parameter);
            //代理id
            $agent_info = isset($data['data'])?$data['data']:null;
        }

        //登陆的代理id
        $userid = session()->get('agent_userid');
        if(empty($userid)){
            if(!empty($agent_info)){
                $index_banner_imgs = explode(',',$agent_info['index_banner_imgs']);
                return view('Agent.index',['agent_info'=>$agent_info,'json_img'=>json_decode($agent_info['img_list'],true),'index_banner_imgs'=>$index_banner_imgs]);
            }else{
                return view('Agent.index');
            }
            
        }
        return redirect()->intended('agent/report/reportlist');
    }

    /**
     * 登录验证
     */
    public function  doLogin(Request $request){
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
            $res = $UserServicesImpl->doAgentLogin($username,$password);
            if($res){
                $this->responseJson(1000);
            }
            $UserServicesImpl->messages()->add('login','用户名或密码错误');
        }
        $data = $UserServicesImpl->messages()->getMessages();
        $this->responseJson(1001,$data);
    }


    /**
     * 修改密码
     * @return \
     */
    public function changePwd(){
        if(isset($_POST['pwd'])){
            $parameter = array('userId'=>session()->get('agent_userid'));
            $data = HttpRequest::getApiServices('agent','getUserInfo','GET',$parameter);
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
        return view('Agent.changepwd');
    }
    public function changeOver(){
        if(isset($_POST['new_pwd']) && $_POST['type']=='none'){
            $new_pwd = $_POST['new_pwd'];
            $uid = session()->get('agent_userid');
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
        return view('Agent.changepwd');
    }

    /**
     *  管理员列表
     */
    public function managerList(){

        $parameter = array();
        $data = HttpRequest::getApiServices('agent','getAdminList','GET',$parameter);
        return view('Agent.managerList',$data);
    }

    /**
     * @return 新增管理员
     */
    public function addUser(){


        if(empty($_POST['username']))
        {

            $data = HttpRequest::getApiServices('agent','addUser','GET');

            return view('Agent.addUser',['data'=>$data]);  //  角色列表

        }else{
            $parameter = array('name'=>$_POST['username'],'remark'=>$_POST['remark'],'role'=>$_POST['role']);
            $data = HttpRequest::getApiServices('agent','addUser','GET',$parameter);

            // 这里修成功了 要往managerlist 跳转

            if($data['data'] >1)
            {

                if($data['data'] ==9999){
                    $this->alert_back('该用户已存在');
                }else{
                    return redirect('agent/managerlist'); //成功跳到首页

                }
            }else{
                return view('Agent.addUser');  //失败要提示失败
            }

        }


    }

    /**
     * @return 编辑管理员
     */
    public function editUser(){

        if(empty($_POST['username'])){

            if(isset($_GET['aid']) && $_GET['aid']!=""){
                $parameter = array('aid'=>$_GET['aid']);
                $data = HttpRequest::getApiServices('agent','editUser','GET',$parameter);  // 名字 备注  角色
                return view('Agent.editUser',$data);
            }

        }else{

            if($_POST['password'] = 'on'){
                $parameter = array('aid'=>$_GET['aid'],'name'=>$_POST['username'],'password'=>'123456','remark'=>$_POST['remark'],'role'=>$_POST['role']);
            }else{
                $parameter = array('aid'=>$_GET['aid'],'name'=>$_POST['username'],'remark'=>$_POST['remark'],'role'=>$_POST['role']);
            }

            $data = HttpRequest::getApiServices('agent','editUser','GET',$parameter);  // 名字 备注  角色

            if(isset($data) && $data['data']==1){

                return redirect('agent/managerlist'); //成功跳到首页
            }else{
                return redirect('agent/editUser?aid='.$_GET['aid']);  //  报出失败原因;
            }

        }

    }

    /**
     *  什么禁用.开启,删除
     */
    public  function setmanagerList(){

          if(isset($_GET['type']) && isset($_GET['id']))
          {
              $parameter = array('type'=>$_GET['type'],'id'=>$_GET['id']);

              $data = HttpRequest::getApiServices('agent','setmanagerList','GET',$parameter);  // 名字 备注  角色

              echo json_encode($data);

          }

    }

    /**
     *   获取角色列表
     */
    public function roleList(Request $request)
    {

        if(isset($_GET['name'])){
            $parameter = array('name','=',$_GET['name']);
            $data = HttpRequest::getApiServices('agent', 'roleList', 'GET', $parameter);  // 名字 备注  角色
            echo json_encode($data);
        }else{
            $parameter = array();
            $data = HttpRequest::getApiServices('agent', 'roleList', 'GET', $parameter);  // 名字 备注  角色
            return view('Agent.roleList', $data);
        }

    }

    /**
     * 编辑角色列表
     */
    public function editRole(){

        if(isset($_GET['lookData']) && isset($_GET['operateData'])){
            $parameter = array('lookData'=>$_GET['lookData'],'operateData'=>$_GET['operateData'],'name'=>$_GET['name'],'id'=>$_GET['id']);
            $data = HttpRequest::getApiServices('agent', 'editRole', 'GET', $parameter);  // 名字 备注  角色
            echo json_encode($data);
        }else{
            $parameter = array('id'=>$_GET['id']);
            $data = HttpRequest::getApiServices('agent', 'editRole', 'GET', $parameter);  // 名字 备注  角色


            return view('Agent.editRole',['data'=>$data,'id'=>$_GET['id']]);
        }
    }

    /**
     * 新增角色   lookData": lookData, "operateData": operateData
     */
    public function addRole(){

        if(isset($_GET['lookData']) && isset($_GET['operateData']))  //这里如果不填名字,要做处理
        {
            $parameter = array('lookData'=>$_GET['lookData'],'operateData'=>$_GET['operateData'],'name'=>$_GET['name']);
            $data = HttpRequest::getApiServices('agent', 'addRole', 'GET', $parameter);  // 名字 备注  角色
            echo json_encode($data);
        }else{
            $parameter = array();
            $data = HttpRequest::getApiServices('agent', 'addRole', 'GET', $parameter);  // 名字 备注  角色
            return view('Agent.addRole',$data);
        }



    }




}