<?php
/**
 * Created by PhpStorm.
 * User: luojia
 * Date: 2017/5/22
 * Time: 20:23
 */

namespace App\Services;
use Validator;

class CommonServices {
    /**
     * 验证类
     * @var Validator
     */
    private $_validator;

    /**
     * 错误验证信息
     * @var Array
     */
    protected $messages = [
        "integer" => ":attribute应为整型值",
        "required" => ":attribute必填字段",
        "confirmed" => ":attribute密码两次输入不一致",
        "email" => ":attribute邮件地址格式不正确",
        "date" => ":attribute日期格式不正确",
        "between" => ":attribute值区间为:min 到 :max",
        "min" => ":attribute最小值为:min",
        "max" => ":attribute最大值为:max",
        "in" => ":attribute值应为:values",
        "size" => ":attribute长度为:size位",
        "captcha" => ":attribute错误",
    ];

    /**
     * 加载函数
     * @param Input $input
     * @param Rule $rule
     * @param message $message
     */
    protected function init($input, $rule = array(),$message)
    {  
        $this->_validator = Validator::make($input, $rule, $this->messages,$message);

        $formKey = array_keys(get_class_vars(get_class($this)));
        // 遍历表单键值 并赋予类成员
        foreach ($formKey as $value)
        {
            if(isset($input[$value]))
            {
                $this->$value = $input[$value];
            }
        }
    }

    /**
     * 取得验证器
     */
    public function validator()
    {
        return $this->_validator;
    }

    /**
     * 判断是否验证成功
     * @return boolean
     */
    public function isValid()
    {
        return !$this->_validator->fails();
    }

    /**
     * 取得验证错误信息
     */
    public function messages() {
        return $this->_validator->messages();
    }
}