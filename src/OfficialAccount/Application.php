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


namespace Villain\WeChat\OfficialAccount;


use Villain\WeChat\Core\Container;
use Villain\WeChat\OfficialAccount\AccessToken\AccessTokenProviders;
use Villain\WeChat\OfficialAccount\Customer\CustomerProviders;
use Villain\WeChat\OfficialAccount\Material\MaterialProviders;
use Villain\WeChat\OfficialAccount\Menu\MenuProviders;
use Villain\WeChat\OfficialAccount\QRCode\QRCodeProviders;
use Villain\WeChat\OfficialAccount\User\UserProviders;

class Application extends Container {
    public array $providers = [
        AccessTokenProviders::class,
        MenuProviders::class,
        CustomerProviders::class,
        MaterialProviders::class,
        QRCodeProviders::class,
        UserProviders::class
    ];

}