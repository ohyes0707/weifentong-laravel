<?php
//
Route::group(array('domain' => 'operate.youfentong.com'), function()
{

    Route::get('/','Operate\UserController@login');
    require_once( __DIR__.'/operate_route.php');

});
Route::group(array('domain' => 'user.youfentong.com'), function()
{

    Route::get('/','Home\UserController@login');
    require_once( __DIR__.'/home_route.php');

});
Route::group(array('domain' => 'buss.youfentong.com'), function()
{

    Route::get('/','Business\UserController@login');
    require_once( __DIR__.'/buss_route.php');

});
Route::group(array('domain' => 'agent.youfentong.com'), function()
{

    Route::get('/','Agent\UserController@login');
    require_once( __DIR__.'/agent_route.php');

});

Route::group(array('domain' => '{user}.agent.youfentong.com'), function()
{

    Route::get('/','Agent\UserController@login');
    Route::get('agent/user/login','Agent\UserController@login');
    header('Access-Control-Allow-Origin:*'); 
    // header('Access-Control-Allow-Methods:POST');
    // header('Access-Control-Allow-Headers:x-requested-with,content-type');

    Route::post('agent/user/login',[ 'as' => 'agent/login', 'uses' => "Agent\\UserController@doLogin"]);

    Route::any('agent/agentList','Agent\AgentController@AgentList');
    Route::any('agent/addAgent','Agent\AgentController@addAgent');
    Route::any('agent/setmanagerList','Agent\AgentController@setmanagerList');
    Route::any('agent/addAgency','Agent\AgentController@addAgency');
    Route::any('agent/editAgent','Agent\AgentController@editAgency');//编辑代理  

    //代理登录后的操作
    Route::group(['middleware' => ['agentLogin']], function () {
        //查看
        Route::any('agent/report/reportlist', 'Agent\ReportController@reportList');

        Route::get('agent/user/info',[ 'as' => 'agent/info', 'uses' => "Agent\\UserController@getUserInfo"]);

        Route::get('agent/user/loginOut',[ 'as' => 'agent/loginOut', 'uses' => "Agent\\UserController@loginOut"]);

        Route::post('agent/user/changePwd',[ 'as' => 'agent/changepwd', 'uses' => "Agent\\UserController@changePwd"]);

        //工单列表
        Route::get('agent/workorder/getworkorderlist','Agent\WorkOrderController@getWorkOrderlist');
    });

});




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
