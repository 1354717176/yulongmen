<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 应用名称
define('DOMAIN', $_SERVER['SERVER_NAME']);
if(DOMAIN == 'yulongmen.yanghuan.com'){
    define('APP_NAME', 'desk');
}else{
    define('APP_NAME', 'console');
}

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
