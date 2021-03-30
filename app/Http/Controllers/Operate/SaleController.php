<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/22
 * Time: 16:07
 */
namespace App\Http\Controllers\Operate;
use App\Http\Controllers\Controller;
use App\Lib\HttpUtils\HttpRequest;

class SaleController extends Controller{
    /**
     * 销售列表
     */
    public function getSaleList(){
        $sale = isset($_REQUEST['sales'])?$_REQUEST['sales']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        $parameter = array('page'=>$page,'pagesize'=>$pagesize,'sale'=>$sale);
        $data = HttpRequest::getApiServices('Operate/SaleController','getSaleList','GET',$parameter);
        if($data['data']){
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $list = $paginator->toArray()['data'];
            return view('Operate.salesList',['list'=>$list,'paginator'=>$paginator,'page'=>$page,'sale'=>$sale]);
        }
        return view('Operate.salesList',['page'=>$page]);
    }

    /**
     * 添加销售
     */
    public function saleAdd(){
        if($_POST){
            $data = HttpRequest::getApiServices('Operate/SaleController','saleAdd','GET',$_POST);
            if($data['data']){
                return self::alert_back('添加成功');
            }else{
                return self::alert_back('添加失败，此账号或已存在');
            }
        }
        return view('Operate.addSales');
    }
    /**
     * 销售编辑
     */
    public function saleEdit(){
        if($_POST){
            $data = HttpRequest::getApiServices('Operate/SaleController','saleEdit','GET',$_POST);
            if($data['data']){
                return self::alert_back('修改成功');
            }else{
                return self::alert_back('修改失败');
            }
        }else{
            $uid = isset($_GET['uid'])?$_GET['uid']:'';
            $parameter = array('uid'=>$uid);
            $data = HttpRequest::getApiServices('Operate/SaleController','saleEdit','GET',$parameter);
            if($data['data']){
                return view('Operate.editSales',['list'=>$data['data']]);
            }
            return view('Operate.editSales');
        }
    }

    /**
     * 销售报表
     */
    public function saleForm(){
        $uid = isset($_GET['uid'])?$_GET['uid']:'';
        $uname = isset($_REQUEST['uname'])?$_REQUEST['uname']:'';
        $startDate = isset($_REQUEST['startDate'])?$_REQUEST['startDate']:date('Y-m-d',strtotime('-7days'));
        $endDate = isset($_REQUEST['endDate'])?$_REQUEST['endDate']:date('Y-m-d',strtotime('-1days'));
        $excel = isset($_REQUEST['excels'])?$_REQUEST['excels']:'';
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        if($excel == 1){
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
        }else{
            $pagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10;
        }
        $parameter = array('uid'=>$uid,'start_date'=>$startDate,'end_date'=>$endDate,'page'=>$page,'pagesize'=>$pagesize);
        $data = HttpRequest::getApiServices('Operate/SaleController','saleForm','GET',$parameter);
        if($data['data']){
            $newpagesize= isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:99999;
            $parameter = array('uid'=>$uid,'start_date'=>$startDate,'end_date'=>$endDate,'page'=>$page,'pagesize'=>$newpagesize);
            $data_all = HttpRequest::getApiServices('Operate/SaleController','saleForm','GET',$parameter);
            $total = array(
                'date_time'=>'汇总',
                'follow'=>0,
                'unfollow'=>0,
                'cost'=>0
            );
            foreach($data_all['data']['data'] as $k=>$v){
                $total['follow'] += $v['follow'];
                $total['unfollow'] += $v['unfollow'];
                $total['cost'] += $v['cost'];
            }
            $paginator = self::pagslist($data['data']['data'],$data['data']['count'],$pagesize);
            $pagelist = $paginator->toArray()['data'];
            $list['total'] = $total;
            $list += $pagelist;
            if($excel == 1){
                foreach($list as $k=>$v){
                    $un_per = '0.00%';
                    if($v['follow'] != 0)
                        $un_per = sprintf('%.2f',$v['unfollow']/$v['follow']*100).'%';
                    $arr[] = array(
                        'date_time'=>$v['date_time'],
                        'follow'=>$v['follow'],
                        'unfollow'=>$v['unfollow'],
                        'un_per'=>$un_per,
                        'cost'=>$v['cost']
                    );
                }
                $name = '销售报表';
                $head['head'] = array('日期','成功关注','取关数','取关率','销售额');
                self::export($name,$head,$arr);
            }
            return view('Operate.salesReport',['list'=>$list,'paginator'=>$paginator,'post'=>$_REQUEST,'startDate'=>$startDate,'endDate'=>$endDate,'uid'=>$uid,'uname'=>$uname]);
        }
        return view('Operate.salesReport',['startDate'=>$startDate,'endDate'=>$endDate,'uid'=>$uid,'uname'=>$uname]);
    }

    /**
     * 销售状态
     */
    public function saleStatus(){
        $uid = isset($_POST['uid'])?$_POST['uid']:'';
        $parameter = array('uid'=>$uid);
        $data = HttpRequest::getApiServices('Operate/SaleController','saleStatus','GET',$parameter);
        return $data['data'];
    }

    /**
     * 销售删除
     */
    public function saleDel(){
        $uid = isset($_POST['uid'])?$_POST['uid']:'';
        $parameter = array('uid'=>$uid);
        $data = HttpRequest::getApiServices('Operate/SaleController','saleDel','GET',$parameter);
        return $data['data'];
    }

    /**
     * 多选开启
     */
    public function startAll(){
        $str = isset($_POST['str'])?$_POST['str']:'';
        $parameter = array('uid'=>$str);
        $data = HttpRequest::getApiServices('Operate/SaleController','startAll','GET',$parameter);
        return $data['data'];
    }
    /**
     * 多选禁用
     */
    public function endAll(){
        $str = isset($_POST['str'])?$_POST['str']:'';
        $parameter = array('uid'=>$str);
        $data = HttpRequest::getApiServices('Operate/SaleController','endAll','GET',$parameter);
        return $data['data'];
    }
    /**
     * 多选删除
     */
    public function delAll(){
        $str = isset($_POST['str'])?$_POST['str']:'';
        $parameter = array('uid'=>$str);
        $data = HttpRequest::getApiServices('Operate/SaleController','delAll','GET',$parameter);
        return $data['data'];
    }
}
