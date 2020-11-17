<?php

/**
 * 用户异常类
 * @author xianlinli@gmail.com
 */
class UserException extends Exception {

    /**
     * 构造函数
     * @param int $code 错误代码
     * @param string $msg 错误信息(可带格式化字符串)
     * @param mixed ... 可变参数(格式参数)
     */
    public function __construct($code = -1, $msg = 'Undefined exception!') {
        $args = func_get_args();
        array_shift($args);
        array_shift($args);
        $msg = empty($args) ? $msg : vsprintf($msg, $args);
        parent::__construct($msg, $code);
    }

}
