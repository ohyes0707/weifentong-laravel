<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/7/12
 * Time: 15:57
 */
//用户登录页
Route::get('home/user/login','Home\UserController@login');
Route::post('home/user/login','Home\UserController@doLogin');

//登录后的操作
Route::group(['middleware' => ['userLogin']], function () {
    //查看
    Route::any('home/report/reportlist', 'Home\ReportController@reportList');
    Route::get('home/report/getreport', 'Home\ReportController@getReport');
    Route::get('home/report/addreport', 'Home\ReportController@addReport');
    Route::post('home/report/addreport', 'Home\ReportController@saveReport');
    Route::get('home/report/editreport', 'Home\ReportController@editReport');
    Route::post('home/report/editreport', 'Home\ReportController@saveReport');
    Route::get('home/user/loginout', 'Home\UserController@loginOut');
    Route::post('home/report/checkReportName', 'Home\ReportController@checkReportName');
    //销售系统用户信息
    Route::get('home/user/info',[ 'as' => 'user/info', 'uses' => "Home\\UserController@getUserInfo"]);
    //销售系统修改密码
    Route::get('home/user/changepwd',[ 'as' => 'user/changepwd', 'uses' => "Home\\UserController@changePwd"]);
    Route::post('home/user/changepwd',[ 'as' => 'user/changepwd', 'uses' => "Home\\UserController@changePwd"]);
    Route::post('home/user/changeover',[ 'as' => 'home/user/changeover', 'uses' => "Home\\UserController@changeOver"]);
    //用户系统订单列表
    Route::get('home/order/list',[ 'as' => 'home/order/list', 'uses' => "Home\\OrderController@getOrderList"]);
    Route::post('home/order/list','Home\OrderController@getOrderList');
    //销售列表
    Route::get('home/sell/list',[ 'as' => 'home/sell/list', 'uses' => "Home\\SellController@getSellList"]);
    Route::post('home/sell/list','Home\SellController@getSellList');
    //工单开始
    //添加工单
    Route::get('home/workorder/getworkorder','Home\WorkOrderController@getWorkOrder');
    //添加工单提交
    Route::post('home/workorder/getworkorder','Home\WorkOrderController@postWorkOrder');
    //修改工单
    Route::get('home/workorder/geteditworkorder','Home\WorkOrderController@getEditWorkOrder');
    //修改工单post提交
    Route::post('home/workorder/geteditworkorder','Home\WorkOrderController@postEditWorkOrder');
    //工单列表
    Route::get('home/workorder/getworkorderlist','Home\WorkOrderController@getWorkOrderlist');
    Route::get('home/workorder/getRset','Home\WorkOrderController@getRset');
    
    // 产能设置
    Route::get('home/user/CapacitySList', 'Home\CapacityManageController@getDbSCapacityList');
    Route::get('home/user/CapacityCList', 'Home\CapacityManageController@getDbCCapacityList');
    Route::get('home/user/CapacitySExcel', 'Home\CapacityManageController@getCapacitySExcel');
    Route::get('home/user/CapacityCExcel', 'Home\CapacityManageController@getCapacityCExcel');
});

