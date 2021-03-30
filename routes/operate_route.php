<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/7/12
 * Time: 15:58
 */
//运营登录页


Route::get('operate/user/login','Operate\UserController@login');
Route::post('operate/user/login','Operate\UserController@doLogin');
//运营登录后的操作
Route::group(['middleware' => ['operateLogin']], function () {

    //美业授权列表
    Route::any('store/report', 'Store\ReportController@reportList');
// 新增报备
    Route::any('store/addreport', 'Store\ReportController@addreport');
// 美业授权
    Route::any('store/authrize', 'Store\ReportController@authrize');
//美业门店获取
    Route::any('store/shop', 'Store\ReportController@getShopInfo'); //
//美业门店设置
    Route::any('store/set_default', 'Store\ReportController@set_default');


    //子代理分析
    Route::any('agent/analyseSonAgent','Operate\UserController@analyseSonAgent');
    // 子代理列表
    Route::any('agent/sonAgentList','Operate\UserController@sonAgentList');


    //查看
    Route::any('operate/report/reportlist', 'Operate\ReportController@reportList');
    Route::get('operate/user/loginout', 'Operate\UserController@loginOut');
    Route::get('operate/report/changestatus','Operate\ReportController@changeStatus');
    Route::get('operate/report/addauthByShop', 'Operate\ReportController@addShopInfo');
    Route::post('operate/report/addauthByShop', 'Operate\ReportController@doAddShopInfo');
    // 发起授权
    Route::get('home/report/addauth', 'Home\ReportController@addAuth');
    // 获取门店信息
    Route::get('home/report/getShopInfo', 'Home\ReportController@getShopInfo');
    // 设置门店
    Route::get('home/report/set_default', 'Home\ReportController@set_default');
    //运营系统用户信息
    Route::get('operate/user/info',[ 'as' => 'operate/info', 'uses' => "Operate\\UserController@getUserInfo"]);
    //运营系统修改密码
    Route::get('operate/user/changepwd',[ 'as' => 'operate/changepwd', 'uses' => "Operate\\UserController@changePwd"]);
    Route::post('operate/user/changepwd',[ 'as' => 'operate/changepwd', 'uses' => "Operate\\UserController@changePwd"]);
    Route::post('operate/user/changeover',[ 'as' => 'operate/user/changeover', 'uses' => "Operate\\UserController@changeOver"]);
    //订单列表
    Route::get('operate/order/list',[ 'as' => 'order/list', 'uses' => "Operate\\OrderController@getOrderList"]);
    Route::post('operate/order/list','Operate\OrderController@getOrderList');
    //订单修改
    Route::get('operate/order/detail',[ 'as' => 'order/detail', 'uses' => "Operate\\OrderController@orderDetail"]);
    Route::post('operate/order/detail',[ 'as' => 'order/detail', 'uses' => "Operate\\OrderController@getBuss"]);
    //关闭订单
    Route::post('operate/order/close',[ 'as' => 'order/close', 'uses' => "Operate\\OrderController@closeOrder"]);
    //渠道列表
    Route::get('operate/buss/list','Operate\BussController@getBussList');
    //修改订单
    Route::get('operate/workorder/getworkorderlist','Operate\WorkOrderController@getWorkOrderlist');
    //工单详情
    Route::get('operate/workorder/getWorkOrder','Operate\WorkOrderController@getWorkOrder');
    //驳回工单
    Route::post('operate/workorder/postWorkReject','Operate\WorkOrderController@postWorkReject');
    //玩玩
    Route::get('operate/workorder/getSerialize','Operate\WorkOrderController@getSerialize');
    //优先级列表
    Route::get('operate/level/getList','Operate\LevelController@levelList');
    Route::post('operate/level/getList','Operate\LevelController@levelList');
    //设置优先级
    Route::get('operate/level/setLevel','Operate\LevelController@setLevel');
    Route::post('operate/level/setLevel','Operate\LevelController@setLevel');
    //获取子渠道
    Route::get('operate/level/getSon','Operate\LevelController@getSon');
    //订单查询
    Route::any('operate/order/search','Operate\OrderController@orderSearch');
    //订单粉丝详情
    Route::any('operate/order/fans','Operate\OrderController@orderFans');
    //运营系统公众号列表
    Route::any('operate/wechat/list','Operate\WeChatReportController@wechatList');
    //运营系统公众号banner设置
    Route::any('operate/wechat/banner','Operate\WeChatReportController@setBanner');
    //订单操作日志
    Route::any('operate/order/log','Operate\OrderController@orderLogs');

    //---------------------------报表开始-------------------------------//
    Route::get('operate/order/close','Operate\OrderController@closeTask');
    //导出excel表格
    Route::get('export','Count\PlatController@export');
    //平台统计报表
    Route::get('platCount','Count\PlatController@platCount');
    Route::post('platCount','Count\PlatController@platCount');
    Route::post('platExcel','Count\PlatController@platExcel');
    //渠道统计报表
    Route::get('bussCount','Count\BussController@bussCount');
    Route::post('bussCount','Count\BussController@bussCount');
    Route::post('bussExcel','Count\BussController@bussExcel');
    //渠道统计报表点击详情
    Route::any('bussCount_detail','Count\BussController@bussCount_detail');
    //营收统计渠道报表
    Route::get('revenueCount_buss','Count\RevenueController@revenueCount_buss');
    Route::post('revenueCount_buss','Count\RevenueController@revenueCount_buss');
    //营收统计渠道报表查看子渠道
    Route::get('revenueCount_bussOne','Count\RevenueController@revenueCount_bussOne');
    Route::post('revenueCount_bussOne','Count\RevenueController@revenueCount_bussOne');
    //营收统计渠道excel数据
    Route::post('revenueCount_bussExcel','Count\RevenueController@revenueCount_bussExcel');
    //营收统计渠道点击详情
    Route::get('revenueDetail_buss','Count\RevenueController@revenueDetail_buss');
    Route::post('revenueDetail_buss','Count\RevenueController@revenueDetail_buss');
    //营收统计公众号报表
    Route::get('revenueCount_wechat','Count\RevenueController@revenueCount_wechat');
    Route::post('revenueCount_wechat','Count\RevenueController@revenueCount_wechat');
    //营收统计公众号点击详情
    Route::get('revenueDetail_wechat','Count\RevenueController@revenueDetail_wechat');
    Route::post('revenueDetail_wechat','Count\RevenueController@revenueDetail_wechat');
    //营收统计公众号查看子渠道
    Route::get('revenueDetail_wechatOne','Count\RevenueController@revenueDetail_wechatOne');
    Route::post('revenueDetail_wechatOne','Count\RevenueController@revenueDetail_wechatOne');
    //营收统计平台报表
    Route::get('revenueCount_plat','Count\RevenueController@revenueCount_plat');
    Route::post('revenueCount_plat','Count\RevenueController@revenueCount_plat');
    //订单报表
    Route::any('count/order/form','Count\OrderController@orderForm');


//增粉统计
    Route::get('operate/DataDisplay/getFansReport','Operate\DataDisplayController@getFansReport');

    Route::get('operate/DataDisplay/getFanDetail','Operate\DataDisplayController@getFanDetail');

    Route::get('operate/DataDisplay/getBussReport','Operate\DataDisplayController@getBussReport');

    Route::get('operate/DataDisplay/getBussDetail','Operate\DataDisplayController@getBussDetail');

//微信关注报表1
    Route::any('operate/WeChatReport/getPlatformReport','Operate\WeChatReportController@getPlatformReport');
//微信关注报表2
    Route::any('operate/WeChatReport/getPublicSignalReport','Operate\WeChatReportController@getPublicSignalReport');

    Route::get('operate/DataDisplay/getBussOneReport','Operate\DataDisplayController@getBussOneReport');

    Route::get('operate/DataDisplay/getFanBussOneReport','Operate\DataDisplayController@getFanBussOneReport');

    Route::get('operate/DataDisplay/getFansOneReport','Operate\DataDisplayController@getFansOneReport');

    Route::get('operate/DataDisplay/getBussSonDetail','Operate\DataDisplayController@getBussSonDetail');

    Route::get('operate/DataDisplay/getBussOneDetail','Operate\DataDisplayController@getBussOneDetail');

    Route::get('operate/DataDisplay/getExcel','Operate\DataDisplayController@getExcel');

    Route::get('operate/DataDisplay/getFanDetailExcel','Operate\DataDisplayController@getFanDetailExcel');

    Route::get('operate/DataDisplay/getBussOneReportExcel','Operate\DataDisplayController@getBussOneReportExcel');

    Route::get('operate/DataDisplay/getBussReportExcel','Operate\DataDisplayController@getBussReportExcel');

    Route::get('operate/DataDisplay/getBussDetailExcel','Operate\DataDisplayController@getBussDetailExcel');
    // 报表分析平台
    Route::get('operate/analyzeplatform','Operate\AnalyzeOrderController@platformdata');
    // 报表分析订单
    Route::get('operate/analyzeorder','Operate\AnalyzeOrderController@orderdata');
    // 报表分析渠道
    Route::get('operate/analyzechannel','Operate\AnalyzeOrderController@channeldata');
    // 分析图表
    Route::get('operate/analyzepicture','Operate\AnalyzeOrderController@analyzepicture');
    //销售报表
    Route::any('operate/sale/statistics','Count\SaleFormController@saleStatistics');
    //---------------------------报表结束-------------------------------//

    //---------------------------数据回填-------------------------------//
    //数据回填列表
    Route::any('operate/backfill/backfilllist','Operate\BackfillController@getBackFill');
    //数据回填编辑查找
    Route::any('operate/backfill/getbackedit','Operate\BackfillController@getBackEdit');
    //数据回填编辑
    Route::any('operate/backfill/backedit','Operate\BackfillController@BackEdit');
    //---------------------------优粉通商家系统结束-------------------------------//

    //---------------------------提现列表-------------------------------//
    //提现列表
    Route::any('operate/Withdrawals/depositlist','Operate\WithdrawalsController@getDepositlist');
    //提现查看
    Route::any('operate/Withdrawals/withdrawLook','Operate\WithdrawalsController@getWithdrawLook');
    //子商户审核通过
    Route::any('operate/Withdrawals/getLook','Operate\WithdrawalsController@getLook');
    //子商户审核驳回
    Route::any('operate/Withdrawals/getReject','Operate\WithdrawalsController@getReject');
    //---------------------------优粉通商家系统结束-------------------------------//

    //---------------------------实时数据start-------------------------------//
    Route::get('operate/user/realtime','Operate\RealTimeController@RealTime');
    Route::get('operate/user/realtimedesc','Operate\RealTimeController@RealTimeDesc');
    Route::get('operate/user/realtimepbdesc','Operate\RealTimeController@RealTimePbDesc');
    Route::get('operate/user/realtimebussdesc','Operate\RealTimeController@RealTimeBussDesc');
    //---------------------------实时数据end-------------------------------//

    //运营系统销售列表
    Route::any('operate/user/saleList','Operate\SaleController@getSaleList');
    //运营系统销售编辑
    Route::any('operate/user/saleEdit','Operate\SaleController@saleEdit');
    //运营系统新增销售
    Route::any('operate/user/saleAdd','Operate\SaleController@saleAdd');
    //运营系统销售报表
    Route::any('operate/user/saleForm','Operate\SaleController@saleForm');
    //运营系统销售状态
    Route::any('operate/user/status','Operate\SaleController@saleStatus');
    //运营系统删除销售
    Route::any('operate/user/del','Operate\SaleController@saleDel');
    //运营系统销售多选开启
    Route::any('operate/user/startAll','Operate\SaleController@startAll');
    //运营系统销售多选禁用
    Route::any('operate/user/endAll','Operate\SaleController@endAll');
    //运营系统销售多选删除
    Route::any('operate/user/delAll','Operate\SaleController@delAll');
    //运营系统代理列表
    Route::any('agent/user/agentList','Agent\AgentListController@agentList');
    //运营系统代理编辑
    Route::any('agent/user/agentEdit','Agent\AgentListController@agentEdit');
    //运营系统代理列表-子代理
    Route::any('agent/user/subAgent','Agent\AgentListController@subAgent');
    //运营系统代理报表
    Route::any('agent/user/agentForm','Agent\AgentListController@agentForm');

    /*****************************渠道管理start******************************************/
    Route::get('operate/user/ManageChannel','Operate\ChannelManageController@getChannelList');
//父商户
    Route::get('operate/user/ManageAddChannel','Operate\ChannelManageController@getChannelAdd');
    Route::post('operate/user/ManageAddChannel','Operate\ChannelManageController@postChannelAdd');
    Route::get('operate/user/ManageEditeChannel','Operate\ChannelManageController@getChannelModify');
    Route::post('operate/user/ManageEditeChannel','Operate\ChannelManageController@postChannelModify');
//子商户
    Route::get('operate/user/ManageAddSonChannel','Operate\ChannelManageController@getSonChannelAdd');
    Route::post('operate/user/ManageAddSonChannel','Operate\ChannelManageController@postSonChannelAdd');
    Route::get('operate/user/ManageEditeSonChannel','Operate\ChannelManageController@getSonChannelModify');
    Route::post('operate/user/ManageEditeSonChannel','Operate\ChannelManageController@postSonChannelModify');

    Route::get('operate/user/ManageUpdateChannels','Operate\ChannelManageController@getChannelUpdates');
    Route::get('operate/user/ManageUpdateChannel','Operate\ChannelManageController@getChannelUpdate');
    Route::get('operate/user/ChannelQueryName','Operate\ChannelManageController@getChannelQueryName');
    /******************************渠道管理end*****************************************/

    //---------------------------管理员管理-------------------------------//
    Route::any('operate/managerlist','Operate\UserController@managerList');
    Route::any('operate/addUser','Operate\UserController@addUser');
    Route::any('operate/editUser','Operate\UserController@editUser');
// 就是增删该查等乱七八糟的
    Route::any('operate/user/setmanagerList','Operate\UserController@setmanagerList');

    /**** 角色列表*****/
    Route::any('operate/roleList','Operate\UserController@roleList');
    /**** 角色编辑列表*****/
    Route::any('operate/editRole','Operate\UserController@editRole');
    /**** 角色新增列表*****/
    Route::any('operate/addRole','Operate\UserController@addRole');
    /*** 用户页面展示权限****/
    Route::any('operate/getSession','Operate\UserController@getSession');

    // 产能设置
    Route::get('operate/user/CapacityList', 'Operate\CapacityManageController@getCapacityList');
    Route::post('operate/user/CapacityList', 'Operate\CapacityManageController@postCapacityList');
    Route::get('operate/user/CapacitySList', 'Operate\CapacityManageController@getDbSCapacityList');
    Route::get('operate/user/CapacityCList', 'Operate\CapacityManageController@getDbCCapacityList');
    Route::get('operate/user/CapacityPList', 'Operate\CapacityManageController@getDbPCapacityList');
    Route::get('operate/user/CapacitySExcel', 'Operate\CapacityManageController@getCapacitySExcel');
    Route::get('operate/user/CapacityCExcel', 'Operate\CapacityManageController@getCapacityCExcel');
    
    /***********************渠道redis数据**************************/
    //初始化渠道redis数据
    Route::get('operate/buss_area/redis','Operate\BussController@buss_redis');


    //代理系统销售统计
    Route::any('agent/sales/count','Agent\AgentListController@agentSale');

    /******************************代理系统数据start***************************************/
    /*** 新增代理****/
    Route::any('operate/agent/addAgency','Operate\addAgencyController@addAgencyOfAgency');
    Route::any('operate/agent/uploads', 'Operate\addAgencyController@uploadImages');
    
    /******************************代理系统数据end*****************************************/


    //美业订单列表
    Route::any('operate/store/order','Store\StoreOrderController@storeOrderList');
    //美业联动获取品牌
    Route::any('operate/store/getBrand','Store\StoreOrderController@getBrand');
    //美业新增订单
    Route::any('operate/store/add','Store\StoreOrderController@storeOrderAdd');
    //美业订单状态修改
    Route::any('operate/store/status','Store\StoreOrderController@changeStatus');
    //美业品牌列表
    Route::any('operate/store/brand','Store\StoreBrandController@storeBrandList');
    //美业品牌删除
    Route::get('operate/store/brandDel','Store\StoreBrandController@brandDel');
    //美业门店列表
    Route::any('operate/store/shop','Store\StoreShopController@storeShopList');
    //美业添加设备
    Route::any('operate/store/macAdd','Store\StoreMacController@macAdd');
    //美业添加门店
    Route::any('operate/store/shopAdd','Store\StoreShopController@shopAdd');
    //美业设备列表
    Route::any('operate/store/macList','Store\StoreMacController@macList');
    //美业设备删除
    Route::post('operate/store/macDel','Store\StoreMacController@macDel');
    //美业设置品牌protal页
    Route::any('operate/store/brandPortal','Store\StoreBrandController@brandPortal');
});