<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private static $_arrayErrorMap = array
    (
        '1000'=>'成功',
        '1001'=>'登录失败',
        '1002'=>'该公众号已报备',
        '1003'=>'参数错误',
        '1004'=>'',
        '1005'=>'',
        '1006'=>'',
        '1007'=>'',
        '1008'=>'',
        '1009'=>'',
        '1010'=>'',
        '1011'=>'',
        '1012'=>'',
        '1013'=>'',
        '1014'=>'',
        '1015'=>'',
    );

    /**
     *按json方式输出通信数据
     *@param integer $code 状态码
     *@param array $data 数据
     *@return string 返回值为json
     */
    //静态方法，构造json返回数据
    public function responseJson($code=0,$data=null){
        $message = '';
        if (isset(self::$_arrayErrorMap[$code])) {
            $message = self::$_arrayErrorMap[$code];
        }
        $result=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        echo json_encode($result);
        exit;
    }


    /**
     * 分页方法
     * @param $item                 数据
     * @param $total                数组总数
     * @param $perPage              每页显示个数
     * @param null $currentPage     当前页
     * @return LengthAwarePaginator
     */
    static public function pagslist($item, $total, $perPage, $currentPage=null) {
        $users =new LengthAwarePaginator($item, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'page',
        ]);
        return $users;
    }

    static public function onlyPagslist($item, $total, $perPage, $currentPage=null) {
        $users =new LengthAwarePaginator($item, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'busspage',
        ]);
        return $users;
    }


    static public function getUserId(){
            return session()->get('userid');
    }



    /*提示并后退*/
    public function alert_back($content){
        header("Content-type: text/html; charset=utf-8");
        echo "<script>alert('" . $content . "');history.go(-1);</script>";
        exit();
    }

    /**
     * 导出excel表格
     */
    public function export($name,$head,$arr){
        $cellData = $head+$arr;
        Excel::create($name,function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    /**
     * 导出excel表格
     */
    public function exportexcel($name,$arr){
        Excel::create($name,function($excel) use ($arr){
            $excel->sheet('score', function($sheet) use ($arr){
                $sheet->rows($arr);
            });
        })->export('xls');
    }
}
