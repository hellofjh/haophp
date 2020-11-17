<?php

/**
 * Class 路由类
 */
class Router {

    private $module = 'index';
    private $controller = 'index';
    private $action = 'index';

    public function __construct() {

        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {

            $path = preg_split("/[^A-Za-z0-9\/\-_]/", $_SERVER['REQUEST_URI']); // 过滤非指定参数
            $path = trim($path[0], '/');
            $routePars = explode('/', $path);
//            new Dump($routePars);


            $len = count($routePars);
            $publicMod = array('admin', 'index', 'api');
            if (!in_array($routePars[0], $publicMod) || $len < 2 || $len > 3) {
                $this->controller = 'ErrorController';
                $routePars[0] = 'index';
            }else{
                $this->controller = $routePars[1] . 'Controller';
            }

            $this->module = $routePars[0];
            $this->action = isset($routePars[2]) ? $routePars[2] : "index";

//            new Dump($_SERVER);
        }

    }

    /**
     * @throws ReflectionException
     */
    public function run() {
        // 模块安全检查
        if ($this->module === '' || strpos($this->module, '.') !== FALSE) {
            new Dump("Invalid module");
            return;
        }

        // 控制器名安全检查
        if ($this->controller === '' || strpos($this->controller, '.') !== FALSE) {
            new Dump("Invalid controller");
            return;
        }

        $filename = APP . DS . $this->module . DS . CONTROLLER . DS . $this->controller . '.php';

//        new Dump($filename);
        if (!is_file($filename)) {
            new Dump("Controller file not exists");
            return;
        }

        // 引入控制器类
        require_once $filename;

        // 检查控制器类是否存在(不调用__autoload),不存在时抛出异常
        if (!class_exists($this->controller, FALSE)) {
            new Dump("Controller class not exists");
            return;
        }

        // 创建控制器类的反射
        $refClass = new ReflectionClass($this->controller);
        if (!$refClass->hasMethod($this->action)) {
            new Dump("Action not exists!");
            return;
        }

        // 获取动作方法的反射
        $refMethod = $refClass->getMethod($this->action);
        if (!$refMethod->isPublic()) {
            new Dump("Action not public");
            return;
        }

        // 按需启动SESSION会话
//        if (!defined('DISABLE_SESSION') || !constant('DISABLE_SESSION')) {
//            self::startSession();
//        }

        $ctrl = new $this->controller();
        $action = $this->action;
        $ctrl->$action();
    }

}