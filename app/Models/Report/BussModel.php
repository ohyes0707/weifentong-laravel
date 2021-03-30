<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/13
 * Time: 19:27
 */
namespace App\Models\Report;
use App\Models\CommonModel;

class BussModel extends CommonModel{
    protected $table = 'bussiness';

    protected $primaryKey = 'id';

    public $timestamps = false;


    static public function getFindOne($buss_id){
        $scene = BussModel::find($buss_id)->toArray();
        return $scene;
    }
    
    //查询账户是否存在
    static public function getFindUserName($keycode) {
        $model = BussModel::where('username','=',$keycode)->get()->first();
        return $model?1:2;
    }
}