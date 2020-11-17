<?php

class Loader {

    /**
     * 系统路径
     * @var array
     */
    public static $sysPath = array();

    /**
     * 自动加载
     */
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'loadClass'));
    }

    /**
     * 销毁自动加载
     */
    public function unregister() {
        spl_autoload_unregister(array(__CLASS__, 'loadClass'));
    }

    /**
     * 加载类文件
     * @param $class
     */
    private static function loadClass($class) {
        $file = self::findFile($class);
        if ($file !== NULL) {
            require_once $file;
        }
    }

    /**
     * @param $class
     * @return string|null
     */
    private static function findFile($class) {
        if (empty(self::$sysPath)) {
            return NULL;
        }
        foreach (self::$sysPath as $path) {
            $file = $path . DS . $class . '.php';
            if (is_file($file)) {
                return $file;
            }
        }
        return NULL;
    }

    /**
     * 保存系统文件路径
     * @param array $arr
     */
    public static function saveSysPath(array $arr) {
        foreach ($arr as $info) {
            self::$sysPath[] = $info;
        }
    }

}