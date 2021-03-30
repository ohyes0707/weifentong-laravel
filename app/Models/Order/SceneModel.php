<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/13
 * Time: 19:57
 */
namespace App\Models\Order;
use App\Models\CommonModel;

class SceneModel extends CommonModel{

    protected $table = 'scene';

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * 获取场景id
     * @param $scene_name
     * @return mixed
     */
    static public function getSceneId($scene_name){
        $scene_id = SceneModel::select('id')->where('scene _name','=',$scene_name);
        return $scene_id;
    }

    static public function getSceneName($id){
        $scene_name = SceneModel::select('scene_name')->where('id','=',$id)->first();
        return $scene_name;
    }

}