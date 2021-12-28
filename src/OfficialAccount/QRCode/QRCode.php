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

use Villain\WeChat\Core\Container;

class QRCode {

    protected Container $app;
    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * 创建二维码
     * @param string $action
     * @param array $action_info
     * @param null $expire_seconds
     * @return mixed
     */
    public function create(string $action, array $action_info, $expire_seconds = null) {
        $data['action_name'] = $action;
        $data['action_info'] = ['scene' => $action_info];
        if (!is_null($expire_seconds)) {
            $data['expire_seconds'] = $expire_seconds;
        }

        return $this->app->client->httpPostJson('cgi-bin/qrcode/create', $data);
    }

    /**
     * 将Ticket换成图片
     * @param $ticket
     * @return mixed
     */
    public function ticket($ticket) {
        return $this->app->client->httpGet('cgi-bin/showqrcode', ['ticket' => $ticket]);
    }
}