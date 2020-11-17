<?php

# 目录分隔符简写,Linux系统下为"/",Windows系统下"\"
define('DS', DIRECTORY_SEPARATOR);

# 基准路径(以当前文件所在路径为基准,其他路径都参照此基准)
define('BASE_DIR', dirname(__FILE__));

define('APP', BASE_DIR. DS. 'app');
define('MAIN', BASE_DIR. DS. 'main');
define('ADMIN', APP. DS. 'admin');
define('INDEX', APP. DS. 'index');
define('API', APP. DS. 'api');
define('CONTROLLER', 'controller');
define('MODEL', 'model');
define('VIEW', 'view');


require_once MAIN. DS. 'Loader.php';
// 注册类自动加载方法
Loader::register();
// 添加类搜索路径
Loader::saveSysPath(array(BASE_DIR, APP, ADMIN, INDEX, API, MAIN));

//new Dump(Loader::$sysPath);

(new Router)->run();