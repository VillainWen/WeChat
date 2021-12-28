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
use Villain\WeChat\OfficialAccount\Client;

class ClientProviders implements \Pimple\ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple) {
        !isset($pimple['client']) && $pimple['client'] = function ($app) {
            return new Client($app, $app['config']->get('http', []));
        };
    }
}