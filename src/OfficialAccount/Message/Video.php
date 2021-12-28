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
//
//"media_id":"MEDIA_ID",
//"thumb_media_id":"MEDIA_ID",
//"title":"TITLE",
//"description":"DESCRIPTION"
class Video extends Base {

    protected string $type = 'video';

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
            'hqmusicurl' => $this->get('hqmusicurl'),
            'musicurl' => $this->get('musicurl'),
            'title' => $this->get('title'),
            'description' => $this->get('description'),
        ];
    }
}