<?php


/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/7/12
 * Time: 15:58
 */
//代理登录页
Route::get('agent/user/login','Agent\UserController@login');
Route::post('agent/user/login','Agent\UserController@doLogin');
header('Access-Control-Allow-Origin:*'); 
// header('Access-Control-Allow-Methods:POST');
// header('Access-Control-Allow-Headers:x-requested-with,content-type');



//Route::post('agent/user/login',[ 'as' => 'agent/login', 'uses' => "Agent\\UserController@doLogin"]);
//代理登录后的操作
Route::group(['middleware' => ['agentLogin']], function () {

    Route::any('agent/agentList','Agent\AgentController@AgentList');
    Route::any('agent/addAgent','Agent\AgentController@addAgent');
    Route::any('agent/setmanagerList','Agent\AgentController@setmanagerList');
    Route::any('agent/addAgency','Agent\AgentController@addAgency');
    Route::any('agent/editAgent','Agent\AgentController@editAgency');//编辑代理  
    //代理管理
    Route::any('agent/agentList','Agent\AgentController@AgentList');
//  新增代理
    Route::any('agent/addAgent','Agent\AgentController@addAgent');
//代理的启用,禁用,删除
    Route::any('agent/setmanagerList','Agent\AgentController@setmanagerList');
//新增代理
    Route::any('agent/addAgency','Agent\AgentController@addAgency');
//编辑代理  
    Route::any('agent/editAgent','Agent\AgentController@editAgency');
//子代理分析
    Route::any('agent/report/analyseSonAgent','Agent\AgentController@analyseSonAgent');
// 代理授权
    Route::any('agent/authrize', 'Agent\AgentController@authrize');
//代理店获取
    Route::any('agent/shop', 'Agent\AgentController@getShopInfo'); //
//代理门店设置
    Route::any('agent/set_default', 'Agent\AgentController@set_default');

    //查看
    Route::any('agent/report/reportlist', 'Agent\ReportController@reportList');

    Route::get('agent/user/info',[ 'as' => 'agent/info', 'uses' => "Agent\\UserController@getUserInfo"]);

    Route::get('agent/user/loginOut',[ 'as' => 'agent/loginOut', 'uses' => "Agent\\UserController@loginOut"]);

    Route::any('agent/user/changePwd',[ 'as' => 'agent/changepwd', 'uses' => "Agent\\UserController@changePwd"]);
    Route::any('agent/user/changepwd',[ 'as' => 'agent/changepwd', 'uses' => "Agent\\UserController@changePwd"]);
    Route::post('agent/user/changeover',[ 'as' => 'agent/user/changeover', 'uses' => "Agent\\UserController@changeOver"]);

    /***授权***/
    Route::get('agent/report/addauth', 'Agent\ReportController@addAuth');

//添加工单
    Route::get('agent/workorder/getworkorder','Agent\WorkOrderController@getWorkOrder');
//添加工单提交
    Route::post('agent/workorder/getworkorder','Agent\WorkOrderController@postWorkOrder');
//修改工单
    Route::get('agent/workorder/geteditworkorder','Agent\WorkOrderController@getEditWorkOrder');
//修改工单post提交
    Route::post('agent/workorder/geteditworkorder','Agent\WorkOrderController@postEditWorkOrder');
//工单列表
    Route::get('agent/workorder/getworkorderlist','Agent\WorkOrderController@getWorkOrderlist');

//报备列表
    Route::any('agent/report/reportlist','Agent\ReportController@reportList');
//修改报备
    Route::get('agent/report/editreport', 'Agent\ReportController@editReport');
    Route::post('agent/report/editreport', 'Agent\ReportController@saveReport');
//添加报备
    Route::get('agent/report/addreport', 'Agent\ReportController@addReport');
    Route::post('agent/report/addreport', 'Agent\ReportController@saveReport');

});
