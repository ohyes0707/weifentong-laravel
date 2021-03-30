<?php

namespace App\Services\Impl\Order;

use App\Services\CommonServices;
use App\Models\Order\YWorkOrderModel;
use App\Models\Order\WorkOrderLogModel;
use App\Models\Order\SceneModel;
use App\Models\Order\DataIwifiModel;

class WorkOrderServicesImpl extends CommonServices
{

    public $wx_id;
    public $w_total_fans;
    public $w_least_fans;
    public $w_advis_fans;
    public $w_max_fans;
    public $w_per_price;
    public $w_start_time;
    public $w_end_time;
    public $check_status;
    public $sex;
    public $scene;
    public $user_id;
    public $w_user_money;
    public $w_start_date;
    public $w_end_date;
    public $wx_name;
    public $w_status;
    public $w_desc;
    public $hot_area;
    public $fans_tag;
    public $report_id;
    public $device_type;
    /**
     * 转换用户输入为对象模型
     * @param Input $input
     */
    public function convert($input) {
        //-----------------------------------------------------
        // 字段验证
        //-----------------------------------------------------
        $rule = array(
           // "username" => "required|min:4|max:10",
//            "wx_id" => "required",
//            "w_total_fans" => "required",
        );
    
        $message=array(
            "wx_id" => "微信ID",
            "w_total_fans" => "总涨粉数",
        );
        $this->init($input, $rule,$message);
    }
    
    public function add()
    {
        $model = new YWorkOrderModel();
        $model->wx_id = $this->wx_id;
        $model->report_id = $this->report_id;
        $model->w_total_fans = $this->w_total_fans;
        $model->w_least_fans = $this->w_least_fans;
        $model->w_advis_fans = $this->w_advis_fans;
        $model->w_max_fans = $this->w_max_fans;
        $model->w_per_price = $this->w_per_price;
        $model->w_start_time = $this->w_start_time;
        $model->w_end_time = $this->w_end_time;
        $model->check_status = $this->check_status;
        $model->sex = $this->sex;
        $model->w_desc = $this->w_desc;
        $model->hot_area=$this->hot_area;
        $model->fans_tag=$this->fans_tag;
        $model->scene = $this->scene;
        $model->user_id = $this->user_id;
        $model->w_user_money = $this->w_user_money;
        $model->w_start_date = $this->w_start_date;
        $model->w_end_date = $this->w_end_date;
        $model->wx_name = $this->wx_name;
        $model->device_type = $this->device_type;
        $model->w_status=1;
        $model->commit_time = date("Y-m-d H:i:s"); 
        
        if (!$model->save()) {
            return FALSE;
        } else {
            return TRUE;
        }

    }
    
    public function getcityid($param) {
        $wherecode=array();
        if($param!=''&&$param!=','){
            $keyarr=explode(',',$param); 
            foreach ($keyarr as $value) {
                $cityvalue=substr($value,strpos($value,"/")+1);
                if($cityvalue!=''){
                    $wherecode[]=$cityvalue;
                }
            }
        }else{
            return null;
        }
        
        $where[]=['id', '<', '398'];
        $where[]=['id', '>', '35'];
        $city= DataIwifiModel::select('id')->where($where);
        print_r($wherecode);

        if(count($wherecode)>0){
            $city->whereIn('name',$wherecode);
        }
        $cityarr=$city->get()->toArray();
        $cityid=',';
        foreach ($cityarr as $value) {
            $cityid=$cityid.$value['id'].",";
        }
        return $cityid;
    }
    
    public function update($id,$isorder)
    {
        
        $model = YWorkOrderModel::find($id);


        $logmodel =new WorkOrderLogModel();
        $logmodel->work_id = $id;
        $logmodel->wx_id = $model->wx_id;
        $logmodel->report_id = $model->report_id;
        $logmodel->w_total_fans = $model->w_total_fans;
        $logmodel->w_least_fans = $model->w_least_fans;
        $logmodel->w_advis_fans = $model->w_advis_fans;
        $logmodel->w_max_fans = $model->w_max_fans;
        $logmodel->w_per_price = $model->w_per_price;
        $logmodel->w_start_time = $model->w_start_time;
        $logmodel->w_end_time = $model->w_end_time;
        $logmodel->check_status = $model->check_status;
        $logmodel->sex = $model->sex;
        $logmodel->hot_area=$model->hot_area;
        $logmodel->fans_tag=$model->fans_tag;
        $logmodel->scene = $model->scene;
        $logmodel->w_user_money = $model->w_user_money;
        $logmodel->w_start_date = $model->w_start_date;
        $logmodel->w_end_date = $model->w_end_date;
        $logmodel->wx_name = $model->wx_name;
        $logmodel->w_desc = $model->w_desc;
        $logmodel->w_reason = $_POST['reason'];
        $logmodel->w_status=1;
        $logmodel->addtime = date("Y-m-d H:i:s");
        $logmodel->device_type = $model->device_type;
        $logmodel->save();
        
        if($isorder==0){
            $model->w_per_price = $this->w_per_price;
            $model->w_total_fans = $this->w_total_fans;
            $model->w_user_money = $this->w_user_money;
            $model->wx_id = $this->wx_id;
            $model->wx_name = $this->wx_name;
            $model->report_id = $this->report_id;
        }
        $model->w_least_fans = $this->w_least_fans;
        $model->w_advis_fans = $this->w_advis_fans;
        $model->w_max_fans = $this->w_max_fans;
        $model->w_start_time = $this->w_start_time;
        $model->w_end_time = $this->w_end_time;
        $model->check_status = $this->check_status;
        $model->w_desc = $this->w_desc;
        $model->sex = $this->sex;
        $model->hot_area=$this->hot_area;
        $model->fans_tag=$this->fans_tag;
        $model->scene = $this->scene;
        $model->w_start_date = $this->w_start_date;
        $model->w_end_date = $this->w_end_date;
        $model->w_status=1;
        $model->device_type = $this->device_type;
        
//        $model->commit_time = date("Y-m-d H:i:s"); 
        
        if ($model->save()) {
            return redirect('home/workorder/getworkorderlist');
        }

    }    
    
    static public function Difference($str1,$str2){
        $arr1=explode(',',$str1);
        $arr2=explode(',',$str2);
        $data=array(
            'addedit'=>',',
            'deledit'=>','
        );
        foreach ($arr1 as $value1) {
             if($value1==''){
                
            }elseif(strpos($str2, ",$value1,")!== false)
            {
                
            } else {
                $data['addedit']=$data['addedit'].$value1.',';
            }
        }
        
        foreach ($arr2 as $value2) {
            if($value2==''){
                
            }elseif(strpos($str1,  ",$value2,")!== false)
            {
                
            } else {
                $data['deledit']=$data['deledit'].$value2.',';
            }
        }
        return $data;
    }
    
    static public function getCityName($str)
    {
        $model=DataIwifiModel::select();
        if($str==''){
            $where[]=['id', '<', '398'];
            $where[]=['id', '>', '35'];
            return null;
            //$array= $model->Where($where)->get()->toArray();
        } else {
            $citycode=substr($str,1,strlen($str)-2);
            $codearray= explode(',', $citycode);
            $array= $model->whereIn('id',$codearray)->get()->toArray();
        }

        $are='';
        foreach ($array as $key => $value) {
            $province= DataIwifiModel::select('name')->where('id','=',$value['pid'])->Where('id', '<=', '35')->first()->name;
            $are=$are.$province.'/'.$value['name'].',';
        }
        return $are;
    }
    
   static public function getScene($str)
    {
        $Scenecode=substr($str,1,strlen($str)-2);
        $codearray= explode(',', $Scenecode);
        $array= SceneModel::select()->whereIn('id',$codearray)->get()->toArray();
        $are='';
        foreach ($array as $value) {
            $are=$are.$value['scene_name'].',';
        }
        return rtrim($are, ','); ;
    }
    
   static public function getUpWOrderStat($id,$stat,$new,$reason)
    {
        //驳回
        $upnum=YWorkOrderModel::getUpWOrderStat($id,$stat,$new,$reason);
    }


    /**
     * 获取工单详情
     * @param $work_id 工单id
     * @return mixed
     */
    public static function getWorkOrderInfo($work_id){
        return YWorkOrderModel::getWorkOrderInfo($work_id);
    }


    public static function setWorkStatus($work_id,$num){
        return YWorkOrderModel::setWorkStatus($work_id,$num);
    }

}