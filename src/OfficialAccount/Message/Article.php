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


class Article extends Base {

    protected string $type = 'mpnews';
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
            'author' => $this->get('author'),
            'title' => $this->get('title'),
            'content' => $this->get('content'),
            'digest' => $this->get('digest'),
            'content_source_url' => $this->get('source_url', ''),
            'show_cover_pic' => $this->get('show_cover_pic', "0"),
            'need_open_comment' => $this->get('need_open_comment', '1'),
            'only_fans_can_comment' => $this->get('only_fans_can_comment', '0'),
        ];
    }
}