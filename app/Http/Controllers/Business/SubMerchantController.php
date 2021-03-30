<?php

namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Services\Impl\Report\SubMerchantServicesImpl;

class SubMerchantController extends Controller{
    
    public function getChildBusiness(Request $request) {
        $termarray=array(
            'page'=>$request->input('page'),
            //'pagesize'=>$request->input('pagesize'),
            'pagesize'=>10,
            'parent_id'=> $this->getParentId()
        );
        if(session()->get('parent_id')>0){
            $termarray['parent_id']=session()->get('buss_id');
        }
        $listdata = HttpRequest::getApiServices('data','getSearchSubTaskData','GET',$termarray);
        $item= isset($listdata['data']['date'])?$listdata['data']['date']:null;//展示的数据
        $total=isset($listdata['data']['count'])?$listdata['data']['count']:null;//总共有几条数据
        $setpage=  self::pagslist($item, $total,$termarray['pagesize']);
        //分页数据
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        return view('Business.childbusiness',$return);
    }
    
    public function getAddSubShop() {
        if(session()->get('parent_id')>0){
            echo '你没有权限看';
            die();
        }
        return view('Business.addsubshop');
    }
    
    public function postAddSubShop(Request $request) {
        $parentid=$this->getParentId();
        $arr= SubMerchantServicesImpl::getFindOne($parentid);
        $termarray=array(
            'username'=>$request->input('shopName'),
            'password'=>md5(123456 . time()),
            'cost_price'=>$request->input('price'),
            'create_time'=> time(),
            'money'=>0,
            'pbid'=>$parentid,
            'reduce_percent'=>$arr['reduce_percent']
        //    'parent_id'=>1
        );
        $id=SubMerchantServicesImpl::getAddOne($termarray);
        $uparray['level_path']="0-$parentid-$id";
        SubMerchantServicesImpl::getUpOne($id, $uparray);
        $arr = SubMerchantServicesImpl::getFindBussInfoOne($parentid);
        $termarray2=array(
            'bid'=>$id,
            'nick_name'=>$request->input('shopName'),
            //渠道简介
            'description'=>$arr['description'],
            //连接完成页
            'complate_page'=>$arr['complate_page'],
            //异常URL
            'exception_url'=>$arr['exception_url'],
            //完成页
            'shangjia_url'=>$arr['shangjia_url'],
            'exception_url'=>$arr['exception_url'],
        );
        SubMerchantServicesImpl::getAddBussInfoOne($termarray2);
        return redirect('business/user/getChildBusiness');
    }
    
    public function getEditSubShop(Request $request) {
        $data=SubMerchantServicesImpl::getFindOne($request->input('bussid'));
        $return['data']=$data;
        return view('Business.editsubshop',$return);
    }
    
    public function postEditSubShop(Request $request) {
        
        $data=SubMerchantServicesImpl::getFindOne($request->input('bussid'));
        $termarray=array(
            'username'=>$request->input('shopName'),
            'cost_price'=>$request->input('price'),
        );
        if($request->input('resetPwd')==TRUE){
            $termarray['password']=md5(123456 . $data['create_time']);
        }
        SubMerchantServicesImpl::getUpOne($request->input('bussid'), $termarray);
        return redirect('business/user/getChildBusiness');
    }
    
    public function getSubShopReport(Request $request) {
        $termarray=array(
            'page'=>$request->input('page'),
            'startdate'=>isset($_REQUEST['startdate'])?$_REQUEST['startdate']:date('Y-m-d',strtotime('-7days')),
            'enddate'=>isset($_REQUEST['enddate'])?$_REQUEST['enddate']:date('Y-m-d',strtotime('-1days')),
            //'pagesize'=>$request->input('pagesize'),
            'pagesize'=>10,
            'parentid'=> $this->getParentId(),
            'bussid'=>$this->getBussId($request->input('bussid'))
        );
        //echo $this->getBussId($request->input('bussid'));
        $listdata = HttpRequest::getApiServices('data','getSubShopReport','GET',$termarray);
        $item= isset($listdata['data']['data1'])?$listdata['data']['data1']:null;//展示的数据
        $total=isset($listdata['data']['count'])?$listdata['data']['count']:null;//总共有几条数据
        $setpage=  self::pagslist($item, $total,$termarray['pagesize']);
        //分页数据
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        $return['sumdata']=isset($listdata['data']['data2'])?$listdata['data']['data2']:null;
        return view('Business.subshopreport',$return);
    }
    
    
    public function getSubShopReportExcel(Request $request) {
        $termarray=array(
            'page'=>$request->input('page'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            //'pagesize'=>$request->input('pagesize'),
            'pagesize'=>9999,
            'bussid'=> $this->getBussId($request->input('bussid'))
        );
        $listdata = HttpRequest::getApiServices('data','getSubShopReport','GET',$termarray);
        $data1= isset($listdata['data']['data1'])?$listdata['data']['data1']:null;//展示的数据
        $data2=isset($listdata['data']['data2'])?$listdata['data']['data2']:null;
        $excelarr= self::getSubShopReportExcelArray($data1,$data2);
        $this->exportexcel('报表导出',$excelarr);
    }
    
    public function getHistoryFans(Request $request) {
        $termarray=array(
            'page'=>$request->input('page'),
            'startdate'=>isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days')),
            'enddate'=>isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-1days')),
            'bussid'=>$this->getBussId($request->input('bussid')),
            'gzh'=>$request->input('gzh'),
            //'pagesize'=>$request->input('pagesize'),
            'pagesize'=>10,
            'parent_id' => $this->getParentId()
        );
        $listdata = HttpRequest::getApiServices('data','getHistoryFans','GET',$termarray);
        $item= isset($listdata['data']['date'])?$listdata['data']['date']:null;//展示的数据
        $total=isset($listdata['data']['count'])?$listdata['data']['count']:null;//总共有几条数据
        $setpage=  self::pagslist($item, $total,$termarray['pagesize']);
        //分页数据
        $return['wxlist']=$listdata['data']['wxlist'];
        $return['paginator']=$setpage;
        $return['termarray']=$termarray;
        return view('Business.historyfans',$return);
    }
    
    
    public function getHistoryFansExcel(Request $request) {
        $termarray=array(
            'page'=>$request->input('page'),
            'startdate'=>$request->input('startDate'),
            'enddate'=>$request->input('endDate'),
            'bussid'=>$request->input('bussid'),
            'gzh'=>$request->input('gzh'),
            //'pagesize'=>$request->input('pagesize'),
            'pagesize'=>9999,
            'parent_id' => $this->getParentId()
        );
        $listdata = HttpRequest::getApiServices('data','getHistoryFans','GET',$termarray);
        $excelarr= self::getBussReportExcel($listdata['data']['date']);
        $this->exportexcel('报表导出',$excelarr);
    }
    
    static public function getBussReportExcel($datearray) {
        $hhdd[]=array('日期','公众号','带粉数','取关数','取关率');
//        foreach ($datearray as $value){
//            $hhdd[]=array(
//                $value['date'],$value['username'],$value['sumfans'],$value['cancelfans'],$value['cancelrate'].'%'
//            );
//        }
        $new=array();
        foreach ($datearray as $value){
            if(isset($new[$value['username']])){
                $new[$value['username']]['sumfans'] = $new[$value['username']]['sumfans']+$value['sumfans'];
                $new[$value['username']]['cancelfans'] = $new[$value['username']]['cancelfans']+$value['cancelfans'];
                $new[$value['username']]['cancelrate'] = self::division($new[$value['username']]['cancelfans'], $new[$value['username']]['sumfans']);
                $new[$value['username']]['list'][] = $value;
            } else {
                $new[$value['username']]['sumfans'] = $value['sumfans'];
                $new[$value['username']]['cancelfans']= $value['cancelfans'];
                $new[$value['username']]['cancelrate'] = $new[$value['username']]['sumfans'];
                $new[$value['username']]['list'][] = $value;
            }

        }
        foreach ($new as $key => $value) {
            $hhdd[]=array(
                $key,'',$value['sumfans'],$value['cancelfans'],$value['cancelrate'].'%'
            );
            foreach ($value['list'] as $key2 => $value2) {
                $hhdd[]=array(
                    '',$value2['date'],$value2['sumfans'],$value2['cancelfans'],$value2['cancelrate'].'%'
                );
            }
        }

        return $hhdd;
    }
    
    static public function getSubShopReportExcelArray($data1,$data2) {
        $hhdd[]=array('日期','带粉数','取关数','取关率','收益');
        $hhdd[]=array(
            $data2['date'],$data2['sumfans'],$data2['cancelfans'],$data2['cancelrate'].'%',$data2['money']
        );
        foreach ($data1 as $value){
            $hhdd[]=array(
                $value['date'],$value['sumfans'],$value['cancelfans'],$value['cancelrate'].'%',$value['money']
            );
        }
        return $hhdd;
    }
    
    public function hhd() {
        $name='测试';
        
        $arr= array(
            1=>array(
                1,0,2,3
            )
        );
        $arr2= array(
            0=>'A1:B1'
        );
        Excel::create($name,function($excel) use ($arr,$arr2){
            $excel->sheet('score', function($sheet) use ($arr,$arr2){
                $sheet->mergeCells('A1:A2');
                $sheet->rows($arr,$arr2);
                //$sheet->getActiveSheet()->mergeCells('A1:A2');
            });
        })->export('xls');
    }
    
    public function getParentId() {
        if(session()->get('parent_id')==0){
            return session()->get('buss_id');
        } else {
            return session()->get('parent_id');
        }
    }
    
    public function getBussId($bussid) {
        if(session()->get('parent_id')==0){
            return $bussid;
        } else {
            return session()->get('buss_id');
        }
    }
    
    static public function division($param1,$param2) {
        if($param2==0||$param2==''||$param1==0||$param1==''){
            return 0;
        }
        return round($param1/$param2*100,2).'%';
    } 
}