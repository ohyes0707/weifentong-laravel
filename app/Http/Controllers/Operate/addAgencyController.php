<?php

namespace App\Http\Controllers\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lib\HttpUtils\HttpRequest;
use App\Lib\Handle\Upload;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Validator;

class addAgencyController extends Controller
{
    public function addAgencyOfAgency(Request $request)
    {

        if($_POST){
            $OEM = $request->input('OEM');
            if($OEM == '2'){
                //不支持oem
                $termarray=array(
                    // 'gzh'=>$request->input('gzh'),
                    'account'=>$request->input('account'),
                    'agencyName'=>$request->input('agencyName'),
                    'minprice'=>$request->input('minPrice'),
                    'oem_ok'=>'0',
                );
            }else{
                //接收上传图片 
                $url = '/agent/uploads/';
                $img = ['jpg','png','gif','jpeg'];
                //接收文件信息  
                $filenames = ['logo','company_banner'];

                $this->uploadImg = new \App\Lib\Handle\Upload;
                // $data = Input::all();//后期考虑加一个公共方法进行表单数据的全部过滤  

                $filename = array();
                foreach ($filenames as $key => $value) {
                    //进行上传
                    $uploads = $this->uploadImg->upload_img($request,$value,$url,$img,'uploads');
                    if(isset($uploads['name'])){
                        if($value == 'logo'){
                            $date = 'l';
                        }elseif($value == 'company_banner'){
                            $date = 'c';
                        }elseif($value == 'index_banner'){
                            $date = 'i';
                        }
                        $filename[$date] = $uploads['path'].'/'.$uploads['name'];
                    }else{
                        return $uploads;
                    }
                }

                //支持oem
                $termarray=array(
                    // 'gzh'=>$request->input('gzh'),
                    'account'=>$request->input('account'),
                    'agencyname'=>$request->input('agencyName'),
                    'minprice'=>$request->input('minPrice'),
                    'company'=>$request->input('company'),
                    'phone'=>$request->input('phone'),
                    'qq_bumber'=>$request->input('qq_bumber'),
                    'address'=>$request->input('address'),
                    'production'=>$request->input('production'),
                    'website'=>$request->input('website'),
                    'description'=>$request->input('description'),
                    'index_banner_imgs'=>$request->input('index_banner_imgs'),
                    'img_list'=>json_encode($filename),
                    'oem_ok'=>'0',
                );
            }

            $data = HttpRequest::getApiServices('agent', 'addAgency', 'GET', $termarray);
            if($data['success']){
                return redirect()->intended('operate/agent/addAgency');
            }else{
                die($data['message']);
            }

        }
        
        return view('Operate.addAgencyOfAgency');
    }

    //新增代理首页banner图
    public function uploadImages(Request $request)
    {
        if($_FILES){
            $data = array();
            
            
            //接收上传图片 
            $url = '/agent/uploads/';
            $img = ['jpg','png','gif','jpeg'];
            //接收文件信息  
            $filename = array();
            //进行上传
            
            //创建以当前日期命名的文件夹
            $today = date('Y-m-d');
            $dir = public_path().$url.$today;

            if(!is_dir($dir)){
                mkdir($dir);
            }

            $realPath = $_FILES['index_banner']['tmp_name'];
            $info = pathinfo($_FILES['index_banner']['name']);

            //上传文件
            $filename = uniqid().'.'.$info['extension'];//新文件名
            if(Storage::disk('uploads')->put($today.'/'.$filename,file_get_contents($realPath))){
                $fileimg = $url.$today.'/'.$filename;
                // $termarray=array(
                //     // 'gzh'=>$request->input('gzh'),
                //     'fileimg'=>$fileimg,
                // );
                
                // $data = HttpRequest::getApiServices('agent', 'addAgencyImg', 'GET', $termarray);

                // $img = '\agent\uploads\2017-11-14\5a0a53dc88d71.jpg';
                // $img2 = '\agent\uploads\2017-11-14\5a0a511c77af3.jpg';
                $data = $fileimg;
                // $data[] = $img2;
echo $data;
                // echo implode('|',$data);die;
                // dd('上传成功');
            }else{
                return '上传失败';
                // dd('上传失败');
            }
            // $data = HttpRequest::getApiServices('agent', 'addAgency', 'GET', $termarray);
            // if($data['success']){
            //     return redirect()->intended('operate/agent/addAgency');
            // }else{
            //     die($data['message']);
            // }

        }
        
    }
   
}