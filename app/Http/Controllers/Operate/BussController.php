<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/23
 * Time: 10:23
 */
namespace App\Http\Controllers\Operate;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class BussController extends Controller{
    public function buss_redis(){
        $data = HttpRequest::getApiServices('Operate/BussController','buss_redis','GET',$parameter=array());
        return redirect('/operate/report/reportlist');
    }
}