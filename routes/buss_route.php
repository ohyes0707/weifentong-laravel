<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/7/12
 * Time: 15:57
 */
//用户登录页
Route::get('buss/user/login','Business\UserController@login');
Route::post('buss/user/login','Business\UserController@doLogin');

//登录后的操作
Route::group(['middleware' => ['bussLogin']], function () {
    //---------------------------优粉通商家系统开始-------------------------------//
    //退出
    Route::get('business/user/loginout', 'Business\UserController@loginOut');
    //父商户结算管理
    Route::any('business/Settlement/getParentBuss','Business\SettlementController@getParentBuss');
    //子商户结算管理
    Route::any('business/Settlement/childManage','Business\SettlementController@getSonBuss');
    //提现
    Route::any('business/Settlement/withdrawDeposit','Business\SettlementController@getWithdrawDeposit');
    //提现查看
    Route::any('business/Settlement/withdrawLook','Business\SettlementController@getWithdrawLook');
    //子商户审核通过
    Route::any('business/Settlement/getLook','Business\SettlementController@getLook');
    //子商户审核驳回
    Route::any('business/Settlement/getReject','Business\SettlementController@getReject');
    //商家带粉收益
    Route::any('business/Fans/fansEarn','Business\FansController@fansEarn');
    //商家带粉统计
    Route::any('business/Fans/fansCount','Business\FansController@fansCount');
    //子商家带粉收益
    Route::any('business/Fans/fansEarn_child','Business\FansController@fansEarn_child');
    //子商家带粉统计
    Route::any('business/Fans/fansCount_child','Business\FansController@fansCount_child');
    //所有子商户
    Route::get('business/user/getChildBusiness','Business\SubMerchantController@getChildBusiness');
    //添加
    Route::get('business/user/getAddSubShop','Business\SubMerchantController@getAddSubShop');
    Route::post('business/user/getAddSubShop','Business\SubMerchantController@postAddSubShop');
    //修改子商户信息
    Route::get('business/user/getEditSubShop','Business\SubMerchantController@getEditSubShop');
    Route::post('business/user/getEditSubShop','Business\SubMerchantController@postEditSubShop');
    //子商户报表
    Route::get('business/user/getSubShopReport','Business\SubMerchantController@getSubShopReport');
    Route::get('business/user/getSubShopReportExcel','Business\SubMerchantController@getSubShopReportExcel');
    //子商户历史数据
    Route::get('business/user/getHistoryFans','Business\SubMerchantController@getHistoryFans');
    Route::get('business/user/getHistoryFansExcel','Business\SubMerchantController@getHistoryFansExcel');


    Route::get('business/user/hhd','Business\SubMerchantController@hhd');
    //商家系统修改密码
    Route::get('business/user/changepwd',[ 'as' => 'business/changepwd', 'uses' => "Business\\UserController@changePwd"]);
    Route::post('business/user/changepwd',[ 'as' => 'business/changepwd', 'uses' => "Business\\UserController@changePwd"]);
    Route::post('business/user/changeover',[ 'as' => 'business/user/changeover', 'uses' => "Business\\UserController@changeOver"]);
    //当前任务
    Route::any('buss/getCurrentReport/reportlist', 'Business\SettlementController@getCurrentReport');
    //历史任务
    Route::any('buss/getHistoryReport/reportlist', 'Business\SettlementController@getHistoryReport');
    //子商户统计中心
    Route::any('buss/getSonTradeReport/reportlist', 'Business\SettlementController@getSonTradeReport');
    //拒绝任务
    Route::any('buss/refuseReport/reportlist', 'Business\SettlementController@refuseReport');
    //---------------------------优粉通商家系统结束-------------------------------//
});

