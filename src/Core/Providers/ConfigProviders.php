<?php declare(strict_types=1);
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


namespace Villain\WeChat\Core\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Villain\WeChat\Core\Config;

class ConfigProviders implements ServiceProviderInterface {

    /**
     * @param Container $pimple
     */
    public function register(Container $pimple) {
        !isset($pimple['config']) && $pimple['config'] = function ($app) {
            $config = $app->getConfig();
            return new Config($config);
        };
    }
}