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


class Music extends Base
{
    protected string $type = 'music';

    protected array $required = [
        'media_id'
    ];

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
            'media_id' => $this->get('media_id'),
            'thumb_media_id' => $this->get('thumb_media_id'),
            'title' => $this->get('title'),
            'description' => $this->get('description'),
        ];
    }
}