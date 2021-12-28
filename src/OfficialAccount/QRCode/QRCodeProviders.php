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
namespace Villain\WeChat\OfficialAccount\QRCode;

use Pimple\Container;
use Villain\WeChat\OfficialAccount\Menu\Menu;

class QRCodeProviders implements \Pimple\ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple) {
        !isset($pimple['qrcode']) && $pimple['qrcode'] = function ($app) {
            return new QRCode($app);
        };
    }
}