<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/21
 * Time: 20:43
 */
namespace App\Models\Report;
use App\Models\CommonModel;
class WxReportModel extends CommonModel{
    protected $table = 'y_wx_report';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * 根据id获取报备详情
     * @param $id
     * @return null
     */
    static public function getReportById($id){
        $model = WxReportModel::where('id', '=', $id)->first();
        return $model?$model->toArray():null;
    }

    /**
     * 根据条件跟新数据
     * @param $id
     * @return null
     */
    public function upDateReport($data,$where){
       return WxReportModel::where($where)->update($data);
    }

    public function saveReport($data){
        $WxReportModel = new WxReportModel();
        $WxReportModel->wx_name = $data['wx_name'];
        $WxReportModel->company = $data['company'];
        $WxReportModel->contacts = $data['contacts'];
        $WxReportModel->telphone = $data['telphone'];
        $WxReportModel->type = $data['type'];
        $WxReportModel->user_id = $data['user_id'];
        $WxReportModel->user_name = $data['user_name'];
        $WxReportModel->agent_id = $data['agent_id'];
        return $WxReportModel->save($data);
    }

    /**
     * 设置报备状态
     */
    public static function setReportStatus($report_id,$num){
        $rtn = WxReportModel::where('id','=',$report_id)->update(['status'=>$num]);
        return $rtn;
    }
}