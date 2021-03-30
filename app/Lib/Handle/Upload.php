<?php
/**
 * Created by PhpStorm.
 * Demo
 *     
 */
namespace App\Lib\Handle;

use Illuminate\Http\Request;
use Storage;
use App\Http\Requests;
use Validator;


class Upload 
{

    // 文件上传方法
    static public function upload_img($request,$filename,$url,$img,$config_name)
    {
        // $all = $request->all();
        // $rules = [
        //         $filename=>'required',
        // ];
        // $messages = [
        //     "$filename.required"=>'请选择要上传的文件'
        // ];
        // $validator = Validator::make($all,$rules,$messages);
        // if($validator->fails()){
        //     return $validator;
        // }
        //获取上传文件的大小
        $size = $request->file($filename)->getSize();

        // $size = $request->file('index_banner')->getSize();

        //这里可根据配置文件的设置，做得更灵活一点
        
        if($size > 2*1024*1024){
            return '上传文件不能超过2M';
        }

        //文件类型
        $mimeType = $request->file($filename)-> getClientOriginalExtension();
        // $mimeType = $request->file('index_banner')->getMimeType();

        //这里根据自己的需求进行修改
        if(!in_array($mimeType,$img)){  
  
            return '图片格式为jpg,png,gif';  
        }
        // if($mimeType != 'image/png'){
        //     return back()->with('errors','只能上传png格式的图片');
        // }

        //扩展文件名
        $ext = $request->file($filename)->getClientOriginalExtension();
        // $ext = $request->file('index_banner')->getClientOriginalExtension();

        //判断文件是否是通过HTTP POST上传的
        $realPath = $request->file($filename)->getRealPath();
        // $realPath = $request->file('index_banner')->getRealPath();

        if(!$realPath){
            return '非法操作';
        }

        //创建以当前日期命名的文件夹
        $today = date('Y-m-d');
        //storage_path().'/app/uploads/' 这里根据 /config/filesystems.php 文件里面的配置而定
        //$dir = str_replace('\\','/',storage_path().'/app/uploads/'.$today);
        
        $dir = public_path().$url.$today;
        // $dir = storage_path().'/app/uploads/'.$today;
        if(!is_dir($dir)){
            mkdir($dir);
        }

        //上传文件
        $filename = uniqid().'.'.$ext;//新文件名
        if(Storage::disk($config_name)->put($today.'/'.$filename,file_get_contents($realPath))){
            return ['name' => $filename,'path' => $url.$today];
            // dd('上传成功');
        }else{
            return '上传失败';
            // dd('上传失败');
        }

    }
}