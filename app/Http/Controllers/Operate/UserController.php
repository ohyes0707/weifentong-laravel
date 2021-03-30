<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:52
 */

//运营用户操作控制器类
namespace App\Http\Controllers\Operate;
use App\Services\Impl\Admin\AdminServicesImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use App\Services\Impl\User\UserServicesImpl;

class UserController extends Controller
{
    /**
     * 运营登出
     */
    public function loginOut(){
        session()->forget('operate_userid');
        session()->forget('operate_username');
        return redirect('operate/user/login');
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
        $userid = session()->get('operate_userid');
        if(empty($userid)){
            return view('Operate.index');
        }else{
            $data_session = session()->get('leftdata');
            $data = isset($data_session['data']['data'])?$data_session['data']['data']:'';
            $is_ok = false;
            $url = '';
            if($data){
                foreach($data as $k=>$v){
                    if($v['id']==7){
                        $is_ok = true;
                        $url = $v['url'];
                        break;
                    }
                }
                if(!$is_ok){
                    $url = $data[0]['url'];
                }
            }
            $url = config('config.OPERATE_URL').$url;
            header("location:$url");
        }
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
            $res = $UserServicesImpl->doOperateLogin($username,$password);
            if($res){
                $this->responseJson(1000);
            }
            $UserServicesImpl->messages()->add('login','用户名或密码错误');
        }
        $data = $UserServicesImpl->messages()->getMessages();
        $this->responseJson(1001,$data);
    }

    /**
     * 个人信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function getUserInfo(){
//        $userid = session()->get('operate_userid');
//        $parameter = array('userId'=>$userid);
//        $data = HttpRequest::getApiServices('operate','getAdminInfo','GET',$parameter);
//        $user_info = $data['data'];
//        return view('Operate.personinfo',['user_info'=>$user_info ]);
//    }
    /**
     * 修改密码
     * @return \
     */
    public function changePwd(){
        if(isset($_POST['pwd'])){
            $parameter = array('userId'=>session()->get('operate_userid'));
            $data = HttpRequest::getApiServices('operate','getAdminInfo','GET',$parameter);
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
        return view('Operate.changepwd');
    }
    public function changeOver(){
        if(isset($_POST['new_pwd']) && $_POST['type']=='none'){
            $new_pwd = $_POST['new_pwd'];
            $uid = session()->get('operate_userid');
            $AdminServicesImpl = new AdminServicesImpl();
            $data = $AdminServicesImpl->changePwd($uid,$new_pwd);
            if($data){
                return '修改成功';
            }else{
                return '修改失败';
            }
        }else if($_POST['type'] == 'block'){
            return '请输入正确的旧密码';
        }
        return view('Operate.changepwd');
    }

    /**
     *  管理员列表
     */
    public function managerList(){

        $parameter = array();
        $data = HttpRequest::getApiServices('operate','getAdminList','GET',$parameter);
        return view('Operate.managerList',$data);
    }

    /**
     * @return 新增管理员
     */
    public function addUser(){


        if(empty($_POST['username']))
        {

            $data = HttpRequest::getApiServices('operate','addUser','GET');

            return view('Operate.addUser',['data'=>$data]);  //  角色列表

        }else{
            $parameter = array('name'=>$_POST['username'],'remark'=>$_POST['remark'],'role'=>$_POST['role']);
            $data = HttpRequest::getApiServices('operate','addUser','GET',$parameter);

            // 这里修成功了 要往managerlist 跳转

            if($data['data'] >1)
            {

                if($data['data'] ==9999){
                    $this->alert_back('该用户已存在');
                }else{
                    return redirect('operate/managerlist'); //成功跳到首页

                }
            }else{
                return view('Operate.addUser');  //失败要提示失败
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
                $data = HttpRequest::getApiServices('operate','editUser','GET',$parameter);  // 名字 备注  角色
                return view('Operate.editUser',$data);
            }

        }else{

            if($_POST['password'] = 'on'){
                $parameter = array('aid'=>$_GET['aid'],'name'=>$_POST['username'],'password'=>'123456','remark'=>$_POST['remark'],'role'=>$_POST['role']);
            }else{
                $parameter = array('aid'=>$_GET['aid'],'name'=>$_POST['username'],'remark'=>$_POST['remark'],'role'=>$_POST['role']);
            }

            $data = HttpRequest::getApiServices('operate','editUser','GET',$parameter);  // 名字 备注  角色

            if(isset($data) && $data['data']==1){

                return redirect('operate/managerlist'); //成功跳到首页
            }else{
                return redirect('operate/editUser?aid='.$_GET['aid']);  //  报出失败原因;
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

              $data = HttpRequest::getApiServices('operate','setmanagerList','GET',$parameter);  // 名字 备注  角色

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
            $data = HttpRequest::getApiServices('operate', 'roleList', 'GET', $parameter);  // 名字 备注  角色
            echo json_encode($data);
        }else{
            $parameter = array();
            $data = HttpRequest::getApiServices('operate', 'roleList', 'GET', $parameter);  // 名字 备注  角色
            return view('Operate.roleList', $data);
        }

    }

    /**
     * 编辑角色列表
     */
    public function editRole(){

        if(isset($_GET['lookData']) && isset($_GET['operateData'])){
            $parameter = array('lookData'=>$_GET['lookData'],'operateData'=>$_GET['operateData'],'name'=>$_GET['name'],'id'=>$_GET['id']);
            $data = HttpRequest::getApiServices('operate', 'editRole', 'GET', $parameter);  // 名字 备注  角色
            echo json_encode($data);
        }else{
            $parameter = array('id'=>$_GET['id']);
            $data = HttpRequest::getApiServices('operate', 'editRole', 'GET', $parameter);  // 名字 备注  角色


            return view('Operate.editRole',['data'=>$data,'id'=>$_GET['id']]);
        }
    }

    /**
     * 新增角色   lookData": lookData, "operateData": operateData
     */
    public function addRole(){

        if(isset($_GET['lookData']) && isset($_GET['operateData']))  //这里如果不填名字,要做处理
        {
            $parameter = array('lookData'=>$_GET['lookData'],'operateData'=>$_GET['operateData'],'name'=>$_GET['name']);
            $data = HttpRequest::getApiServices('operate', 'addRole', 'GET', $parameter);  // 名字 备注  角色
            echo json_encode($data);
        }else{
            $parameter = array();
            $data = HttpRequest::getApiServices('operate', 'addRole', 'GET', $parameter);  // 名字 备注  角色
            return view('Operate.addRole',$data);
        }



    }


    /**
     *  子代理列表
     */
    public function sonAgentList()
    {

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 1;
        $sonagency = isset($_REQUEST['sonagency']) ? $_REQUEST['sonagency']:'';
        $agency = isset($_REQUEST['agency']) ? $_REQUEST['agency']:'';
        $agency = $agency=="全部" ? '':$agency;
        $parameter = array('sonagency' => $sonagency, 'agency' => $agency, 'page' => $page, 'pagesize' => $pagesize);
        $data = HttpRequest::getApiServices('agent', 'sonAgentList', 'GET', $parameter);
        $arr = isset($data['data'])?$data['data']:0;
        $count = isset($data['count'])?$data['count']:0;
        $namelist = $data['name'];
        $paginator = self::pagslist($arr, $count, $pagesize);
        $reportlist_arr = $paginator->toArray()['data'];

        return view('Operate.sonAgent',['reportlist' => $reportlist_arr, 'paginator' => $paginator,'agency'=>$agency,'sonagency'=>$sonagency,'parameter'=>$parameter,'namelist'=>$namelist,'agency'=>$agency,'sonagency'=>$sonagency]);

    }

    /**
     * @return  子代理分析
     */
    public function analyseSonAgent(){


        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;
        $start_date = isset($_REQUEST['startDate'])&&$_REQUEST['startDate']!=""?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $end_date = isset($_REQUEST['endDate'])&&$_REQUEST['endDate']!=""?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        if($excel>0){
            $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 9999;
        }else{
            $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 10;
        }
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $parameter = array('startDate' => $start_date, 'endDate' => $end_date, 'id' => $_GET['id'], 'pagesize' => $pagesize,'page'=>$page);
        $data = HttpRequest::getApiServices('agent', 'analyseSonAgent', 'GET', $parameter);


        if($excel==1){
            $arr = $data['data'];
            $name = '子代理分析报表';
            $head['head'] = array('时间', '成功关注', '取关数', '取关率', '销售额');
            $newArray = array();
            foreach ($arr as $kk => $value) {
                $Array['date_time'] = $value['date_time'];
                $Array['total_fans'] = $value['total_fans'];
                $Array['un_subscribe'] = $value['un_subscribe'];
                $Array['percent'] = $value['percent'];
                $Array['money'] = $value['money'];
                $newArray[] = $Array;
            }
            self::export($name, $head, $newArray);
        }else{
            $arr = $data['data'];
            $count = $data['count'];
            $paginator = self::pagslist($arr, $count, $pagesize);
            $reportlist_arr = $paginator->toArray()['data'];
            return view('Operate.analyseSonAgent',['start_date'=>$start_date,'end_date'=>$end_date,'parameter'=>$parameter,'arr'=>$arr,'paginator' => $paginator,'id'=>$_GET['id']]);
        }




    }





}