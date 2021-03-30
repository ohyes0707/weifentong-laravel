<?php

namespace App\Models\Order;

use App\Models\CommonModel;

class DataIwifiModel extends CommonModel{

    protected $table = 'data_iwifi';

    protected $primaryKey = 'id';

    public $timestamps = false;

    static public function getAreaId($keycode) {
        $moedel = DataIwifiModel::where('name','=',"$keycode")->get()->first();
        return $moedel?$moedel->toArray():null;
    }

}