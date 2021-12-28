<?php
declare(strict_types=1);
/*------------------------------------------------------------------------
 * File.php
 * 	
 * Description
 *
 * Created on alt+t
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat;


class WeChat {
    /**
     * 构建应用
     * @param $class
     * @param array $config
     * @return mixed
     */
    public static function make($class, array $config) {
        $namespace = $class;
        $application = "\\Villain\\WeChat\\{$namespace}\\Application";
        return new $application($config);
    }

    /**
     * 动态的构建应用，如果微信公众号-OfficialAccount
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments) {
        return self::make($name, ...$arguments);
    }
}