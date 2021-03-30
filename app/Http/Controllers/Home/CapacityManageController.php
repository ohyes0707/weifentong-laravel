<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;
use Illuminate\Http\Request;
use App\Services\Impl\Report\SubMerchantServicesImpl;

class CapacityManageController extends Controller
{
    public function getCapacityList() {
        //$return['paginator'] = $setpage;
        $retrun['data'] = SubMerchantServicesImpl::getCapacityList();
        return view('Home.capacity.capacityllist',$retrun);
    }
    
    public function postCapacityList(Request $request) {
        $array = $request ->input('capacity');
        SubMerchantServicesImpl::getUpdataCapacityList($array);
        return redirect('Home/user/CapacityList');
    }
    
    //http://www.test.com/data/getCapacityList/v1.0
    public function getDbSCapacityList(Request $request) {
        $query = array(
            'keycode' => $request->input('area'),
            'sex' => $request->input('sex'),
            'time' => $request->input('startDate')?$request->input('startDate'): date('Y-m-d')
        );
        $listdata = HttpRequest::getApiServices('data','getCapacityList','GET',$query);
        if(isset($listdata['data']['type'])){
            //这是城市
            return view('Home.capacity.capacityclist',$listdata,$query);
        } else {
            return view('Home.capacity.capacityslist',$listdata,$query);
        }
        
    }
    

    public function getCapacitySExcel(Request $request) {
        $query = array(
            'keycode' => $request->input('area'),
            'sex' => $request->input('sex'),
            'time' => $request->input('startDate')?$request->input('startDate'): date('Y-m-d')
        );
        $listdata = HttpRequest::getApiServices('data','getCapacityList','GET',$query);
        $datearray = $listdata['data'];
        $excelarr= SubMerchantServicesImpl::getCapacitySExcel($datearray,$query);
        $this->exportexcel('报表导出',$excelarr);
    }

    public function getCapacityCExcel(Request $request) {
        $query = array(
            'keycode' => $request->input('area'),
            'sex' => $request->input('sex'),
            'time' => $request->input('startDate')?$request->input('startDate'): date('Y-m-d')
        );
        $listdata = HttpRequest::getApiServices('data','getCapacityList','GET',$query);
        $excelarr= SubMerchantServicesImpl::getCapacityCExcel($listdata['data'],$query);
        $this->exportexcel('报表导出',$excelarr);
    }
}