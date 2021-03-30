<?php

namespace App\Models\Report;
use App\Models\CommonModel;

class BussInfoModel extends CommonModel{
    protected $table = 'buss_info';

    protected $primaryKey = 'bid';

    public $timestamps = false;

    //查询渠道名称是否存在
    static public function getFindChannelName($keycode) {
        $model = BussInfoModel::where('nick_name','=',$keycode)->get()->first();
        return $model?1:2;
    }

    static public function getFindBussInfoOne($buss_id){
        $scene = BussInfoModel::find($buss_id)->toArray();
        return $scene;
    }
}