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


namespace Villain\WeChat\OfficialAccount\AccessToken;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccessTokenProviders implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple) {
        !isset($pimple['access']) && $pimple['access'] = function ($app) {
            return new AccessToken($app);
        };
    }
}