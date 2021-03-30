<?php

namespace App\Models\Order;

use App\Models\CommonModel;

class WorkOrderLogModel extends CommonModel{

    protected $table = 'y_work_order_log';

    protected $primaryKey = 'id';

    public $timestamps = false;

    


}