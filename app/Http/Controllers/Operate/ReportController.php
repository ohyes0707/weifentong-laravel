<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:45
 */

//报备操作控制器类
namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{
    /**
     * 报备列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportlist(){

        $wxid = isset($_REQUEST['wxid'])?$_REQUEST['wxid']:'';
        $isopen = isset($_REQUEST['action'])?$_REQUEST['action']:'';
        $start_date = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:'';
        $end_date = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:'';
        $wx_name = isset($_REQUEST['wxName'])?$_REQUEST['wxName']:'';
        $user_name = isset($_REQUEST['username'])?$_REQUEST['username']:'';
        $report_status = isset($_REQUEST['state'])?$_REQUEST['state']:'';
        $page = isset($_GET['page'])?$_GET['page']:1;
        $pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'start_date'=>$start_date,'end_date'=>$end_date,'wx_name'=>$wx_name,'user_name'=>$user_name,'report_status'=>$report_status);
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
        $url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        return view('Operate.report_list',['reportlist'=>$reportlist_arr,'paginator'=>$paginator,'wxlist'=>$wxlist_arr,'post'=>$_REQUEST,'url'=>$url,'isopen'=>$isopen,'wxid'=>$wxid]);
    }

    /**
     * 改变报备状态
     */
    public function changeStatus(){
        $status = isset($_GET['status'])? $_GET['status']:'';
        $id = isset($_GET['lid'])?$_GET['lid']:'';
        if($status&&$id){
            $parameter = array('id'=>$id,'status'=>$status);
            $data = HttpRequest::getApiServices('report','updateReport','GET',$parameter);
            if($data['success']){
                $ref_url = $_SERVER['HTTP_REFERER'];
                header('Location:'.$ref_url);
            }
            die('update error');
        }else{
            die('param error');
        }
    }

    /***
     * 添加门店信息页
     */
    public function addShopInfo(){
        $rid = isset($_GET['rid'])?$_GET['rid']:'';
        $wxname = isset($_GET['wxname'])?$_GET['wxname']:'';
        if($rid&&$wxname){

            return view('Operate.addshop',['wxname'=>$wxname,'rid'=>$rid]);
        }else{
            $this->alert_back('缺少参数');
        }
    }

    /***
     * 添加公众号门店信息
     */
    public function doAddShopInfo(){
        $rid = Input::get('rid');
        $ghname = Input::get('ghname');
        $shopName = Input::get('shopName');
        $shopId = Input::get('shopId');
        $ssid = Input::get('ssid');
        $appId = Input::get('appId');
        $secretKey = Input::get('secretKey');
        $ghid = Input::get('ghid');
        if( strlen($appId) != 18 ){
            $this->alert_back('appid长度必须18位');
        }
        if( $rid && $ghname && $shopName && $ssid && $secretKey && $ghid ){
            $parameter = array('rid'=>$rid,'ghname'=>$ghname,'shopname'=>$shopName,'shopid'=>$shopId,'ssid'=>$ssid,'appid'=>$appId,'secretkey'=>$secretKey,'ghid'=>$ghid);
            $data = HttpRequest::getApiServices('Wechat','addShopInfo','GET',$parameter);
            if($data['success']&&$data['data']!==false){
                $server_name = $_SERVER['SERVER_NAME'];
                header("Content-type: text/html; charset=utf-8");
                echo "<script>alert('添加成功');window.location.href='http://".$server_name."/index.php/operate/report/reportlist'</script>";
            }else{
                $this->alert_back('添加失败!');
            }
        }else{
            $this->alert_back('缺少必要数据');
        }
    }


}