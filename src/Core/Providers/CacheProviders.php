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
use Villain\Cache\Cache;

class CacheProviders implements ServiceProviderInterface {

    /**
     * @inheritDoc
     */
    public function register(Container $pimple) {
        !isset($pimple['cache']) && $pimple['cache'] = function ($app) {
            return new Cache($app['config']->get('cache', []));
        };
    }
}