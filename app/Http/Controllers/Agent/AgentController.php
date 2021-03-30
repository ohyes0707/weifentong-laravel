<?php
namespace App\Http\Controllers\Agent;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;


class AgentController extends Controller{


    public  function  AgentList(){
        $agenid = session()->get('agent_userid');
        $operate_url = $_SERVER['HTTP_HOST'];
        if(isset($_REQUEST['action']) && $_REQUEST['action']=='error'){

            echo "<script>alert('报备公众号与授权公众号名字不一致');window.location.href='http://{$operate_url}/index.php/store/report';</script>";
        }

        if(isset($_REQUEST['action']) && $_REQUEST['action']=='limit'){
            echo "<script>alert('平台缺少必要权限');window.location.href='http://{$operate_url}/index.php/store/report';</script>";
        }

        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
        $pagesize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:5;
        $nick_name = null;
        if(isset($_POST['agency']) && $_POST['agency'] !=null)
        {
            $parameter = array('agenid'=>$agenid,'page'=>$page,'pagesize'=>$pagesize,'nick_name'=>$_POST['agency']);
            $nick_name = $_POST['agency']==""?"":$_POST['agency'];

        }else{
            $parameter = array('agenid'=>$agenid,'page'=>$page,'pagesize'=>$pagesize);
        }

        $data = HttpRequest::getApiServices('managerAgent','List','GET',$parameter);

        $arr = $data['data'];
        $count = $data['count'];

        //实现分页
        $paginator = self::pagslist($arr, $count, $pagesize);
        $reportlist_arr = $paginator->toArray()['data'];

        return view('Agent.AgentList', ['parameter' => $parameter, 'arr' => $arr,'reportlist' => $reportlist_arr, 'paginator' => $paginator,'nick_name'=>$nick_name]);


    }

    /**
     * @return 新增管理员
     */
    public function addAgent(){


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
    public function editAgency(){

        if(empty($_POST['username'])){

            if(isset($_GET['aid']) && $_GET['aid']!=""){
                $parameter = array('aid'=>$_GET['aid']);
                $data = HttpRequest::getApiServices('agent','editAgent','GET',$parameter);  // 名字 备注  角色
                return view('Agent.editAgency',['data'=>$data]);
            }

        }else{

            if($_POST['password'] = 'on'){
                $parameter = array('aid'=>$_GET['aid'],'username'=>$_POST['username'],'password'=>'123456','ti_money'=>$_POST['ti_money'],'nick_name'=>$_POST['nick_name']);
            }else{
                $parameter = array('aid'=>$_GET['aid'],'username'=>$_POST['username'],'ti_money'=>$_POST['ti_money'],'nick_name'=>$_POST['nick_name']);
            }

            $data = HttpRequest::getApiServices('agent','editAgent','GET',$parameter);  // 名字 备注  角色

            if(isset($data) && $data==1){

                return redirect('agent/agentList'); //成功跳到首页
            }else{
                return redirect('agent/editAgency?aid='.$_GET['aid']);  //  报出失败原因;
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

            $data = HttpRequest::getApiServices('agent','setagentList','GET',$parameter);  // 名字 备注  角色



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

            return view('Agent.editagent',['data'=>$data,'id'=>$_GET['id']]);
        }
    }

    /**
     * 新增角色   lookData": lookData, "operateData": operateData
     */
    public function addAgency(){

        $agenid = session()->get('agent_userid');
        if(isset($_GET['username']) && isset($_GET['nick_name']))  //这里如果不填名字,要做处理
        {

            $parameter = array('username'=>$_GET['username'],'nick_name'=>$_GET['nick_name'],'ti_money'=>$_GET['ti_money'],'agenid'=>$agenid);
            $data = HttpRequest::getApiServices('agent', 'addAgent', 'GET', $parameter);  // 名字 备注  角色

            if($data >1)
            {

                if($data ==9999){
                    $this->alert_back('该用户已存在');
                }else{
                    return redirect('agent/agentList'); //成功跳到首页

                }
            }else{
                return view('Agent.addAgent');  //失败要提示失败
            }
        }else{
//            $parameter = array();
//            $data = HttpRequest::getApiServices('operate', 'addRole', 'GET', $parameter);  // 名字 备注  角色
            $data = array();
            return view('Agent.addAgent',$data);
        }



    }



    /**
     * @return  子代理分析
     */
    public function analyseSonAgent()
    {


        $excel = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : 0;
        $start_date = isset($_REQUEST['startDate']) && $_REQUEST['startDate'] != "" ? $_REQUEST['startDate'] : date('Y-m-d', strtotime('-7days'));
        $end_date = isset($_REQUEST['endDate']) && $_REQUEST['endDate'] != "" ? $_REQUEST['endDate'] : date('Y-m-d', strtotime('-1days'));
        if ($excel > 0) {
            $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 9999;
        } else {
            $pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 10;
        }
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $parameter = array('startDate' => $start_date, 'endDate' => $end_date, 'id' => $_GET['id'], 'pagesize' => $pagesize, 'page' => $page);
        $data = HttpRequest::getApiServices('agent', 'analyseSonAgent', 'GET', $parameter);


        if ($excel == 1) {
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
        } else {
            $arr = $data['data'];
            $count = $data['count'];
            $paginator = self::pagslist($arr, $count, $pagesize);
            $reportlist_arr = $paginator->toArray()['data'];
            return view('Agent.analyseSonAgent', ['start_date' => $start_date, 'end_date' => $end_date, 'parameter' => $parameter, 'arr' => $arr, 'paginator' => $paginator, 'id' => $_GET['id'],'isagentmoudle'=>1]);
        }

    }


    /**
     *  授权
     */
    public function authrize(){

        $rid = $_REQUEST['rid'];

        $api_url = config('config.API_URL');
        header('Location: http://'.$api_url.'agent/add_auth?rid='.$rid);
    }




    // 获取门店信息 http://operatetest.youfentong.com/index.php/store/shop

    public function getShopInfo()
    {

        $parameter = array('rid'=>$_GET['rid']);
        $data = HttpRequest::getApiServices('agent','getShopInfo','GET',$parameter);
        if($data['success']&&!empty($data['data'])){
            $this->responseJson(1000,$data['data']);
        }

    }




    public function set_default(){

        $parameter = array('wxid'=>$_GET['wxid'],'shopid'=>$_GET['shopid'],'shopname'=>$_GET['shopname']);
        $data = HttpRequest::getApiServices('agent','set_default','GET',$parameter);
        if($data['success']&&!empty($data['data'])){
            $this->responseJson(1000,$data['data']);
        }
    }






}