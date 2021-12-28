<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * RequestProviders.php
 * 	
 * 请求类型
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
use Villain\WeChat\Core\Request;

class RequestProviders implements ServiceProviderInterface {

    /**
     * @inheritDoc
     */
    public function register(Container $pimple) {
        !isset($pimple['request']) && $pimple['request'] = function ($app) {
            return new Request($app, $app['config']->get('http', []));
        };
    }
}