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


class MiniProgramPage extends Base {
    protected string $type = 'miniprogrampage';

    public function __construct($properties = []) {
        foreach ($properties as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData():array {
        return [
            'thumb_media_id' => $this->get('thumb_media_id'),
            'pagepath' => $this->get('pagepath'),
            'appid' => $this->get('appid'),
            'title' => $this->get('title'),
        ];
    }
}