<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:45
 */

//报备操作控制器类
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Support\Facades\Input;
use App\Services\Impl\Report\ReportServicesImpl;

class ReportController extends Controller
{
    /**
     * 报备信列表
     */
    public function reportList(){
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:'';
        $end_date = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:'';
        $wx_name = isset($_REQUEST['wxName'])?$_REQUEST['wxName']:'';
        $report_status = isset($_REQUEST['state'])?$_REQUEST['state']:'';
        $userid = session()->get('agent_userid');
        $page = isset($_GET['page'])?$_GET['page']:1;
        $pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'start_date'=>$start_date,'end_date'=>$end_date,'wx_name'=>$wx_name,'report_status'=>$report_status,'userid'=>$userid);
        $data = HttpRequest::getApiServices('home','getReportList','GET',$parameter);
        $reportlist_arr = array();
        $wxlist_arr = array();
        if($data['success']){
            $reportlist_arr = $data['data']['report_list']['data']?$data['data']['report_list']['data']:array();
            $wxlist_arr = $data['data']['wx_list']?$data['data']['wx_list']:array();
        }
        $count= $data['data']['report_list']['count'];

        //实现分页
        $paginator =self::pagslist($reportlist_arr, $count, $pagesize);
        $reportlist_arr = $paginator->toArray()['data'];
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];

        return view('Agent.report_list',['reportlist'=>$reportlist_arr,'paginator'=>$paginator,'wxlist'=>$wxlist_arr,'post'=>$_REQUEST,'url'=>$url]);
    }

    /**
     * 添加报备信息页
     */
    public function addReport(){
        //$userid = session()->get('userid');
        $parameter = array(
            'userid' => session()->get('agent_userid')
        );
        $data = HttpRequest::getApiServices('agent','getagentlist','GET',$parameter);
        print_r($data);
        return view('Agent.add_report',$data);
    }

    /**
     * 编辑报备信息
     */
    public function editReport(){
        $id = Input::get('id');
        $parameter = array(
            'userid' => session()->get('agent_userid')
        );
        $data = HttpRequest::getApiServices('agent','getagentlist','GET',$parameter);
        $userid = session()->get('agent_userid');
        if($id&&$userid){
            $ReportServicesImpl = new ReportServicesImpl();
            $report = $ReportServicesImpl->getReportById($id);
            if($report['user_id']!=$userid) die('id error');
print_r($report);
            return view('Agent.edit_report', ['report'=>$report], $data);
        }
        die("缺少参数");
    }

    /**
     * 新增&&修改报备信息
     */
    public function SaveReport(){
        $id = Input::get('id');
        $input = array(
            'wx_name' => Input::get('wx_name'),
            'company' => Input::get('company'),
            'contacts' => Input::get('contacts'),
            'telphone' => Input::get('telphone'),
            'type'     => Input::get('type'),
            'agent_id'     => Input::get('agent'),
        );
        $ReportServicesImpl = new ReportServicesImpl();
        $ReportServicesImpl->convert($input);//验证输入参数
        if($ReportServicesImpl->isValid()){
            $parameter = array('wx_name'=>$input['wx_name']);
            $data = HttpRequest::getApiServices('home','getReportByWxname','GET',$parameter);
            $res = true;
/*            if($data['success']&&!empty($data['data'])&&isset($id)){
                $report = $ReportServicesImpl->getReportById($id);
                if($report['wx_name']!=$data['data']['wx_name']){
                    $ReportServicesImpl->messages()->add('wxExist','该公众号已报备');
                    $res = false;
                }
            }*/
            if($data['success']&&!empty($data['data'])){
                $ReportServicesImpl->messages()->add('wxExist','该公众号已报备');
                $res = false;
            }
            if($res){
                $result = $ReportServicesImpl->saveReport($id,$input);
                if($result!==false){
                    if(isset($id)&&$result>0){//编辑成功改变订单状态
                        $parameter = array('id'=>$id,'status'=>1);
                        HttpRequest::getApiServices('report','updateReport','GET',$parameter);
                    }
                    return redirect()->intended('agent/report/reportlist');
                }
                $ReportServicesImpl->messages()->add('saveError','保存失败');
            }
        }
        return back()->withErrors($ReportServicesImpl->validator());
    }

   //preauthcode@@@fYq69xHpcJeR3_n5Us3kqS-Fr6gup6-lfL-S3bmt6NyVf5lkAXuRoUVMLBS32WwW
    /***
     * 检测报备公众号是否已成功报备
     */
    public function checkReportName(){
        $wx_name = isset($_POST['wx_name'])?$_POST['wx_name']:'';
        if($wx_name){
            $parameter = array('wx_name'=>$wx_name);
            $data = HttpRequest::getApiServices('home','getReportByWxname','GET',$parameter);
            if($data['success']&&!empty($data['data'])){
                $this->responseJson(1002);
            }
            $this->responseJson(1000);
        }
        $this->responseJson(1003);
    }

 // 发起授权
    public function addAuth(){
        $url = $_GET['url'];
        $rid = $_GET['rid'];
        $api_url = config('config.API_URL');
//        print_r('Location: http://'.$api_url.'agent/auth_redirect?rid='.$rid.'&url='.$url);
//        exit();

        header('Location: http://'.$api_url.'agent/auth_redirect?rid='.$rid.'&url='.$url);
    }

    // 获取门店信息

    public function getShopInfo()
    {

        $parameter = array('wxid'=>$_GET['wxid']);
        $data = HttpRequest::getApiServices('Wechat','getShopInfo','GET',$parameter);
        if($data['success']&&!empty($data['data'])){
            $this->responseJson(1000,$data['data']);
        }


    }




    public function set_default(){

        $parameter = array('wxid'=>$_GET['wxid'],'shopid'=>$_GET['shopid'],'shopname'=>$_GET['shopname']);
        $data = HttpRequest::getApiServices('Wechat','set_default','GET',$parameter);
        if($data['success']&&!empty($data['data'])){
            $this->responseJson(1000,$data['data']);
        }
    }





}