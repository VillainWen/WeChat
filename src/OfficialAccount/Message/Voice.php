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


namespace Villain\WeChat\OfficialAccount\Message;


class Voice extends Base {

    protected string $type = 'voice';

    /**
     * 内容
     * @var string
     */
    protected string $media_id;

    public function __construct(string $media_id) {
        $this->media_id = $media_id;
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData():array {
        return [
            'media_id' => $this->media_id,
        ];
    }
}