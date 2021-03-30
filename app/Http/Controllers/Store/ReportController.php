<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/20
 * Time: 14:45
 */

//报备操作控制器类
namespace App\Http\Controllers\Store;

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
        $operate_url = $_SERVER['HTTP_HOST'];
        if(isset($_REQUEST['action']) && $_REQUEST['action']=='error'){

            echo "<script>alert('报备公众号与授权公众号名字不一致');window.location.href='http://{$operate_url}/index.php/store/report';</script>";
        }

        if(isset($_REQUEST['action']) && $_REQUEST['action']=='limit'){
            echo "<script>alert('平台缺少必要权限');window.location.href='http://{$operate_url}/index.php/store/report';</script>";
        }

        $wx_name = isset($_REQUEST['wxName'])?$_REQUEST['wxName']:'';
        $wx_name = $wx_name=="全部"?"":$wx_name;
        $report_status = isset($_REQUEST['state'])?$_REQUEST['state']:'';
        $report_status = $report_status=="全部"?"":$report_status;
        $page = isset($_GET['page'])?$_GET['page']:1;
        $pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'wx_name'=>$wx_name,'report_status'=>$report_status);

        $data = HttpRequest::getApiServices('store','getReportList','GET',$parameter);

        $count= $data['count'];
        $reportlist_arr = $data['data'];
        $wxlist = $data['nameList'];

        $statuArray = array('全部','申请中','授权成功','授权失败');

        $paginator =self::pagslist($reportlist_arr, $count, $pagesize);
        $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        return view('Store.report',['paginator'=>$paginator,'parameter'=>$parameter,'reportlist'=>$reportlist_arr,'url'=>$url,'namelist'=>$wxlist,'wxname'=>$wx_name,'state'=>$report_status,'statuArray'=>$statuArray]);

    }


    /**
     * 添加报备信息页
     */
    public function addReport(){

       if(isset($_REQUEST['wxname'])){

           $parameter = array('wxname'=>$_POST['wxname'],'shopname'=>$_POST['shopname'],'contact'=>$_POST['contact'],'contactWay'=>$_POST['contactWay']);


           $data = HttpRequest::getApiServices('store','addreport','GET',$parameter);
           // 这里修成功了 要往managerlist 跳转


           if($data >1)
           {

               if($data==9999){
                   $this->alert_back('该公众号已存在');
               }else{
                   return redirect('store/report'); //成功跳到首页

               }
           }else{
               $this->alert_back("添加失败");  //失败要提示失败
           }


       }else{
           return view('Store.addreport');
       }





    }

    /**
     *  授权
     */
    public function authrize(){

        $rid = $_REQUEST['rid'];
        $api_url = config('config.API_URL');
        header('Location: http://'.$api_url.'store/auth_redirect?rid='.$rid);
    }




    // 获取门店信息 http://operatetest.youfentong.com/index.php/store/shop

    public function getShopInfo()
    {

        $parameter = array('rid'=>$_GET['rid']);
        $data = HttpRequest::getApiServices('store','getShopInfo','GET',$parameter);
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