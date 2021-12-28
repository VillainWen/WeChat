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


class MpNews extends Base
{

    protected string $type = 'mpnews';

    protected string $mediaId;

    public function __construct(string $mediaId) {
        $this->mediaId = $mediaId;
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData():array {
        return [
            'media_id' => $this->mediaId,
        ];
    }
}