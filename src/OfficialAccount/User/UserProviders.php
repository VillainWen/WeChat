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


namespace Villain\WeChat\OfficialAccount\User;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class UserProviders implements ServiceProviderInterface {

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)  {
        !isset($pimple['user']) && $pimple['user'] = function ($app) {
            return new User($app);
        };
    }
}