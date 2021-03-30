<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Impl\Order\DataDisplayServicesImpl;

class DataDisplayController extends Controller
{

    public function getFansReport(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize')
        );
        $listdata = HttpRequest::getApiServices('data','getSearchWxTaskData','GET',$termarray);
        $item= isset($listdata['data']['date'])?$listdata['data']['date']:null;//展示的数据
        $total=isset($listdata['data']['count'])?$listdata['data']['count']:null;//总共有几条数据
        $setpage=  self::pagslist($item, $total,10);
        //分页数据
        $return['paginator']=$setpage;
        //筛选条件
        $return['termarray']=$termarray;
        //获取微信公众号名称
        $return['wxid']=isset($listdata['data']['wxname'])?$listdata['data']['wxname']:null;
        return view('Operate.fansstatistics',$return);
    }

    public function getExcel(Request $request){
        $termarray=array(
            'wx_id'=>$request->input('wxid'),
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'page'=>$request->input('page'),
            'pagesize'=>999999,
            'wxname'=>$request->input('wxName'),
        );
        $listdata = HttpRequest::getApiServices('data','getSearchWxTaskData','GET',$termarray);
        $datearray=$listdata['data']['date'];
      //  print_r($datearray);
        $excelarr= DataDisplayServicesImpl::getexcel($datearray,'wx_name','公众号');
        $this->exportexcel('报表导出',$excelarr);
    }

    public function getFanDetail(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'wx_id'=>$request->input('wxid'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize')
        );
        $listdata = HttpRequest::getApiServices('data','getSearchWxBussTaskData','GET',$termarray);
        //print_r($listdata);
        $item=$listdata['data']['date'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total, 10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        $return['bussname']=$listdata['data']['bussname'];
        $return['wxname']=$listdata['data']['wxname'];
        return view('Operate.fandetail',$return);
    }

    public function getFanDetailExcel(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'wx_id'=>$request->input('wxid'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
        );
        $listdata = HttpRequest::getApiServices('data','getSearchWxBussTaskData','GET',$termarray);
        $datearray=$listdata['data']['date'];
      //  print_r($datearray);
        $excelarr= DataDisplayServicesImpl::getexcel2($datearray,'buss_name','父渠道');
        $this->exportexcel('报表导出',$excelarr);
    }
    
    public function getBussReport(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize')
        );
        $listdata = HttpRequest::getApiServices('data','getSearchBussTaskData','GET',$termarray);
        $item= isset($listdata['data']['date'])?$listdata['data']['date']:null;//展示的数据
        $total=isset($listdata['data']['count'])?$listdata['data']['count']:null;//总共有几条数据
        $setpage=  self::pagslist($item, $total, 10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        //获取渠道名称
        $return['bussname']=isset($listdata['data']['bussname'])?$listdata['data']['bussname']:null;
        return view('Operate.bussstatistics',$return);
    }
    
    public function getBussReportExcel(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
        );
        $listdata = HttpRequest::getApiServices('data','getSearchBussTaskData','GET',$termarray);
        $datearray=$listdata['data']['date'];
      //  print_r($datearray);
        $excelarr= DataDisplayServicesImpl::getBussReportExcel($datearray);
        $this->exportexcel('报表导出',$excelarr);
    }
    
    public function getBussDetail(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'parentid'=>$request->input('parentid'),
            'bussid'=>$request->input('bussid'),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize')
        );
        $listdata = HttpRequest::getApiServices('data','getSearchBussWxTaskData','GET',$termarray);
        $item=$listdata['data']['date'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total, 10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        $return['bussname']=$listdata['data']['bussname'];
        return view('Operate.bussdetail',$return);
    }
    
    public function getBussDetailExcel(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'parentid'=>$request->input('parentid'),
            'bussid'=>$request->input('bussid'),
            'wx_id'=>$request->input('wxid'),
            'pagesize'=>999999,
        );
        $listdata = HttpRequest::getApiServices('data','getSearchBussWxTaskData','GET',$termarray);
        $datearray=$listdata['data']['date'];
      //  print_r($datearray);
        $excelarr= DataDisplayServicesImpl::getexcel($datearray,'wx_name','公众号');
        $this->exportexcel('报表导出',$excelarr);
    }
    
    public function getBussOneDetail(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'parentid'=>$request->input('parentid'),
            'bussid'=>$request->input('bussid'),
            'wx_id'=>$request->input('wxid'),
            'wxname'=>$request->input('wxName')
        );
        $listdata = HttpRequest::getApiServices('data','getSearchBussWxTaskData','GET',$termarray);
        $item=$listdata['data']['date'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total, 10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        $return['bussname']=$listdata['data']['bussname'];
        return view('Operate.bussdetailone',$return);
    }
    
    public function getBussOneReport(Request $request){
        $termarray=array(
            'gzh'=>$request->input('gzh'),
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'parent_id'=>$request->input('parentid'),
            'wx_id'=>$request->input('wxid'),
            'parentname'=>$request->input('ParentName'),
            'pagesize'=>999999,
        );
        $listdata = HttpRequest::getApiServices('data','getSearchOneBussTaskData','GET',$termarray);
        $item= isset($listdata['data']['date'])?$listdata['data']['date']:null;//展示的数据
        $total=isset($listdata['data']['count'])?$listdata['data']['count']:null;//总共有几条数据
        $setpage=  self::pagslist($item, $total, 999);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        //获取渠道名称
        //print_r($item);
        $return['bussname']=isset($listdata['data']['bussname'])?$listdata['data']['bussname']:null;
        $return['wxname']=$listdata['data']['wxname'];
        return view('Operate.bussonedetail',$return);
    }
    
    
    public function getFanBussOneReport(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'parent_id'=>$request->input('parentid'),
            'wx_id'=>$request->input('wxid'),
            'parentname'=>$request->input('ParentName'),
            'pagesize'=>999999,
        );
        $listdata = HttpRequest::getApiServices('data','getSearchOneBussTaskData','GET',$termarray);
        $item=$listdata['data']['date'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total, 10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        //获取渠道名称
        //print_r($item);
        $return['bussname']=$listdata['data']['bussname'];
        $return['wxname']=$listdata['data']['wxname'];
        return view('Operate.bussfanonedetail',$return);
    }

    public function getBussOneReportExcel(Request $request){
        $termarray=array(
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'parent_id'=>$request->input('parentid'),
            'wx_id'=>$request->input('wxid'),
            'parentname'=>$request->input('ParentName'),
            'pagesize'=>999999,
        );
        $listdata = HttpRequest::getApiServices('data','getSearchOneBussTaskData','GET',$termarray);
        $datearray=$listdata['data']['date'];
        //  print_r($datearray);
        $excelarr= DataDisplayServicesImpl::getBussexcel2($datearray);
        $this->exportexcel('报表导出',$excelarr);
    }    

    public function getFansOneReport(Request $request){
        $termarray=array(
            'wx_id'=>$request->input('wxid'),
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'page'=>$request->input('page'),
            'pagesize'=>$request->input('pagesize'),
            'wxname'=>$request->input('wxName'),
        );
        $listdata = HttpRequest::getApiServices('data','getSearchWxTaskData','GET',$termarray);
        $item=$listdata['data']['date'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total,10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        //获取微信公众号名称
        $return['wxid']=$listdata['data']['wxname'];
        return view('Operate.fansone',$return);
    }
    
    
    public function getBussSonDetail(Request $request){
        $termarray=array(
            'gzh'=>$request->input('gzh'),
            'usertype'=>$request->input('usertype'),
            'startdate'=> DataDisplayServicesImpl::getInitialValue('startdate', $request->input('startdate')),
            'enddate'=>DataDisplayServicesImpl::getInitialValue('enddate', $request->input('enddate')),
            'bussid'=>$request->input('bussid'),
            'wx_id'=>$request->input('wxid'),
            'parentid'=>$request->input('parentid')
        );
        $listdata = HttpRequest::getApiServices('data','getSearchSonBussWxTaskData','GET',$termarray);
        $item=$listdata['data']['date'];//展示的数据
        $total=$listdata['data']['count'];//总共有几条数据
        $setpage=  self::pagslist($item, $total, 10);
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        //获取微信公众号名称
        $return['wxid']=$listdata['data']['wxname'];
        $return['bussname']=$listdata['data']['bussname'];
        //print_r($return);
        return view('Operate.bussdetail',$return);
    }
}