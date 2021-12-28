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


namespace Villain\WeChat\OfficialAccount\Menu;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MenuProviders implements ServiceProviderInterface {

    /**
     * @param Container $pimple
     */
    public function register(Container $pimple) {
        !isset($pimple['menu']) && $pimple['menu'] = function ($app) {
            return new Menu($app);
        };
    }
}