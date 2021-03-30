<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/21
 * Time: 20:40
 */
namespace App\Services\Impl\Report;
use App\Models\Report\WxReportModel;
use App\Services\CommonServices;
use App\Lib\HttpUtils\HttpRequest;
class ReportServicesImpl extends CommonServices{
    /**
     * 转换用户输入为对象模型
     * @param Input $input
     */
    public function convert($input) {
        //-----------------------------------------------------
        // 字段验证
        //-----------------------------------------------------
        $rule = array(
            "wx_name" =>'required|max:40',
            "company" => "required|max:50",
            "contacts" => "required|max:25",
            "telphone" => "required|size:11",
        );

        $message = array(
            'wx_name' => '公众号',
            'company' => '公司名称',
            'contacts' => '联系人',
            'telphone' => '联系方式',
        );

        $this->init($input, $rule ,$message);
    }

    /**
     * 根据id获取用户报备详情
     * @param $id
     * @return null
     */
    public function getReportById($id){
        return WxReportModel::getReportById($id);
    }

    /**
     * 保存报备信息
     * @param $id
     * @param $input
     * @return null
     */
    public function saveReport($id,$input){
        $userid = session()->get('userid');
        if(session()->get('agent_userid')!=''){
            $userid = session()->get('agent_userid');
        }
        $data = array(
            'wx_name' => $input['wx_name'],
             'company' => $input['company'],
             'contacts' => $input['contacts'],
            'telphone' => $input['telphone'],
            'type'   => $input['type'],
            'user_id' => $userid,
            'agent_id' => $input['agent_id'],
        );
        $WxReportModel = new WxReportModel();
        if(isset($id)){
            $where = array('id'=>$id,'user_id'=>$userid);
            $res = $WxReportModel->upDateReport($data,$where);
        }else{
            $postData = array('userid'=>$userid);
            $result = HttpRequest::getApiServices('user','getUserInfo','GET',$postData);
            if($result['success']&&$result['data']['nick_name']) {
                $data['user_name'] = $result['data']['nick_name'];
            }else{
                $data['user_name'] = session()->get('username');;
            }
            $res = $WxReportModel->saveReport($data);
        }
        return $res;
    }

    /**
     * 设置报备状态
     */
    public static function setReportStatus($report_id,$num){
        return WxReportModel::setReportStatus($report_id,$num);
    }
}