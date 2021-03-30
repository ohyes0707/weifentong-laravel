<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;
use App\Services\Impl\Report\SubMerchantServicesImpl;
use Illuminate\Support\Facades\Redis;

class ChannelManageController extends Controller
{
    public function getChannelList(Request $request) {
        $query = array(
            'keycode' => $request->input('keycode'),
            'page' => $request->input('page'),
            'pagesize' => 10
        );
        $listdata = HttpRequest::getApiServices('data','getChannelList','GET',$query);
        $setpage=  self::pagslist($listdata['data'], $listdata['data']['count'],$query['pagesize']);
        $return['paginator'] = $setpage;
        $return['termarray']=$query;
        return view('Operate.channel.channellist',$return);
    }
    
    public function getChannelAdd() {
        return view('Operate.channel.channeladd');
    }
    
    public function postChannelAdd(Request $request) {
        $str=$request->input('hot_area');
        if($str != '')
        {
            SubMerchantServicesImpl::getAreaId($str);
        }
        $termarray=array(
            //账号
            'username'=>$request->input('account'),
            //密码
            'password'=>md5(123456 . time()),
            //扣量百分百
            'reduce_percent'=>$request->input('percentage'),
            //渠道结算价格
            'cost_price'=>$request->input('price'),
            'create_time'=>time(),
            'ssid'=>$request->input('wifiName'),
            'money'=>0,
            'pbid'=>0,
        );

        $id=SubMerchantServicesImpl::getAddOne($termarray);
        if($id){
            Redis::hset('bidredis',$id,$str==''?'全国':$str);
        }
        $uparray['level_path']="0-$id";
        SubMerchantServicesImpl::getUpOne($id, $uparray);
        $termarray2=array(
            'bid'=>$id,
            'nick_name'=>$request->input('channelName'),
            'buss_area'=>$str,
            'logintime'=>time(),
            //渠道简介
            'description'=>$request->input('intro'),
            //连接完成页
            'complate_page'=>$request->input('connectPage'),
            //完成页
            'shangjia_url'=>$request->input('successPage'),
            //异常URL
            'exception_url'=>$request->input('abnormalPage'),
            'read_percent'=>0
        );
        $id=SubMerchantServicesImpl::getAddBussInfoOne($termarray2);
        return redirect('/operate/user/ManageChannel');
    }
    
    public function getChannelModify(Request $requset) {
        $id = $requset->input('id');
        if($id == ''){
            return redirect('/operate/user/ManageChannel');
        }
        $bussiness = SubMerchantServicesImpl::getFindOne($id);
        $bussinfo = SubMerchantServicesImpl::getFindBussInfoOne($id);
        $result=array(
            'bussiness'=>$bussiness,
            'bussinfo'=>$bussinfo,
        );
        return view('Operate.channel.channelmodify',$result);
    }
    
    public function postChannelModify(Request $request) {
        $str=$request->input('hot_area');
        if($str != '')
        {
            SubMerchantServicesImpl::getAreaId($str);
        }
        $termarray=array(
            //账号
            'username'=>$request->input('account'),
            //扣量百分百
            'reduce_percent'=>$request->input('percentage'),
            //渠道结算价格
            'cost_price'=>$request->input('price'),
            'ssid'=>$request->input('wifiName'),
        );
        if($request->input('resetPwd')==TRUE){
            $termarray['create_time'] = time();
            $termarray['password'] = md5(123456 . $termarray['create_time']);
        }
        $id=$request->input('id');
        if($termarray['cost_price']>0){
            $sendarr = array(
                'bussid' => $id,
                'price' => $termarray['cost_price'],
            );
            $data = HttpRequest::getApiServices('Buss','upRedisBussPrice','GET',$sendarr);
        }
        SubMerchantServicesImpl::getUpOne($id, $termarray);
        $termarray2=array(
            'bid'=>$id,
            'nick_name'=>$request->input('channelName'),
            'buss_area'=>$str,
            //渠道简介
            'description'=>$request->input('intro'),
            //连接完成页
            'complate_page'=>$request->input('connectPage'),
            //异常URL
            'exception_url'=>$request->input('price'),
            //完成页
            'shangjia_url'=>$request->input('successPage'),
            'exception_url'=>$request->input('abnormalPage'),
        );
        SubMerchantServicesImpl::getUpBussInfoOne($id, $termarray2);
        return redirect('/operate/user/ManageChannel');
    }
    
    public function getSonChannelAdd(Request $requset) {
        $pbid = $requset->input('id');
        if($pbid == ''){
            return redirect('/operate/user/ManageChannel');
        }
        $arr = SubMerchantServicesImpl::getFindOne($pbid);
        $bussiness = SubMerchantServicesImpl::getFindOne($pbid);
        $bussinfo = SubMerchantServicesImpl::getFindBussInfoOne($pbid);
        $result=array(
            'bussiness'=>$bussiness,
            'bussinfo'=>$bussinfo,
        );
        return view('Operate.channel.sonchanneladd',$arr,$result);
    }
    
    public function postSonChannelAdd(Request $request) {
        $str=$request->input('hot_area');
        if($str != '')
        {
            SubMerchantServicesImpl::getAreaId($str);
        }
        $termarray=array(
            //账号
            'username'=>$request->input('account'),
            //密码
            'password'=>md5(123456 . time()),
            //扣量百分百
            'reduce_percent'=>$request->input('percentage'),
            //渠道结算价格
            'cost_price'=>$request->input('price'),
            'create_time'=>time(),
            'ssid'=>$request->input('wifiName'),
            'money'=>0,
            'pbid'=>$request->input('pbid'),
            'status'=>$request->input('status'),
        );

        $id=SubMerchantServicesImpl::getAddOne($termarray);
        if($id){
            Redis::hset('bidredis',$id,$str==''?'全国':$str);
        }
        $uparray['level_path']="0-".$termarray['pbid']."-$id";
        SubMerchantServicesImpl::getUpOne($id, $uparray);
        $termarray2=array(
            'bid'=>$id,
            'nick_name'=>$request->input('channelName'),
            'buss_area'=>$str,
            'logintime'=>time(),
            //渠道简介
            'description'=>$request->input('intro'),
            //连接完成页
            'complate_page'=>$request->input('connectPage'),
            //完成页
            'shangjia_url'=>$request->input('successPage'),
            //异常URL
            'exception_url'=>$request->input('abnormalPage'),
            'read_percent'=>0
        );
        $id=SubMerchantServicesImpl::getAddBussInfoOne($termarray2);
        return redirect('/operate/user/ManageChannel');
    }
    
    public function getSonChannelModify(Request $requset) {
        $id = $requset->input('id');
        if($id == ''){
            return redirect('/operate/user/ManageChannel');
        }
        $bussiness = SubMerchantServicesImpl::getFindOne($id);
        $bussinfo = SubMerchantServicesImpl::getFindBussInfoOne($id);
        $arr = SubMerchantServicesImpl::getFindOne($bussiness['pbid']);
        $result=array(
            'bussiness'=>$bussiness,
            'bussinfo'=>$bussinfo,
            'pbname'=>$arr['username']
        );
        return view('Operate.channel.sonchannelmodify',$result);
    }
    
    public function postSonChannelModify(Request $request) {
        $str=$request->input('hot_area');
        if($str != '')
        {
            SubMerchantServicesImpl::getAreaId($str);
        }
        $termarray=array(
            //账号
            'username'=>$request->input('account'),
            //扣量百分百
            'reduce_percent'=>$request->input('percentage'),
            //渠道结算价格
            'cost_price'=>$request->input('price'),
            'ssid'=>$request->input('wifiName'),
        );
        if($request->input('resetPwd')==TRUE){
            $termarray['create_time'] = time();
            $termarray['password'] = md5(123456 . $data['create_time']);
        }
        $id=$request->input('id');
        SubMerchantServicesImpl::getUpOne($id, $termarray);
        $termarray2=array(
            'bid'=>$id,
            'nick_name'=>$request->input('channelName'),
            'buss_area'=>$str,
            //渠道简介
            'description'=>$request->input('intro'),
            //连接完成页
            'complate_page'=>$request->input('connectPage'),
            //异常URL
            'exception_url'=>$request->input('price'),
            //完成页
            'shangjia_url'=>$request->input('successPage'),
            'exception_url'=>$request->input('abnormalPage'),
        );
        SubMerchantServicesImpl::getUpBussInfoOne($id, $termarray2);
        return redirect('/operate/user/ManageChannel');
    }
    
    //调整渠道状态
    public function getChannelUpdate(Request $request) {
        $uparray = array();
        //status商户状态  0 禁止  1 允许
        if($request->input('id')==''||$request->input('id')<=0){
            return FALSE;
        }
        switch ($request->input('type')) {
            case 'prohibit':
                $uparray['status']=0;
                SubMerchantServicesImpl::getUpOne($request->input('id'), $uparray);
                SubMerchantServicesImpl::getUpOne($request->input('id'), $uparray,'pbid');
                break;
            case 'startup':
                $uparray['status']=1;
                SubMerchantServicesImpl::getUpOne($request->input('id'), $uparray);
                $arr = SubMerchantServicesImpl::getFindOne($request->input('id'));
                if($arr['pbid']>0){
                    SubMerchantServicesImpl::getUpOne($arr['pbid'], $uparray);
                }
                break;
                 case 'delete':
                     SubMerchantServicesImpl::getDelOne($request->input('id'), $uparray);
                     SubMerchantServicesImpl::getDelOne($request->input('id'), $uparray,'pbid');
            default:
                break;
        }
        return redirect('/operate/user/ManageChannel');
    }
    
    //调整一群渠道状态
    public function getChannelUpdates(Request $request) {
        $uparray = array();
        //status商户状态  0 禁止  1 允许
        $array = $request->input('checkbox');
        foreach ($array as $key => $value) {
                switch ($request->input('type')) {
                 case 'prohibit':
                     $uparray['status']=0;
                     SubMerchantServicesImpl::getUpOne($value, $uparray);
                     SubMerchantServicesImpl::getUpOne($value, $uparray,'pbid');
                     break;
                 case 'startup':
                     $uparray['status']=1;
                     SubMerchantServicesImpl::getUpOne($value, $uparray);
                     $arr = SubMerchantServicesImpl::getFindOne($value);
                     if($arr['pbid']>0){
                         SubMerchantServicesImpl::getUpOne($arr['pbid'], $uparray);
                     }
                     break;
                 case 'delete':
                     SubMerchantServicesImpl::getDelOne($value, $uparray);
                     SubMerchantServicesImpl::getDelOne($value, $uparray,'pbid');
                 break;
                 default:
                     break;
             } 
        }

        return redirect('/operate/user/ManageChannel');
    }
    
    public function getChannelQueryName(Request $request) {
        $keycode = $request->input('keycode');
        $type = $request->input('type');
        switch ($type) {
            case 'account':
                $arr= SubMerchantServicesImpl::getFindUserName($keycode);
                break;

            default:
                $arr= SubMerchantServicesImpl::getFindChannelName($keycode);
                break;
        }
        
        return $arr;
    }
}