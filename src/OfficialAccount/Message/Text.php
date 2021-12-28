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


class Text extends Base {

    protected string $type = 'text';

    /**
     * 内容
     * @var string
     */
    protected string $content;

    public function __construct(string $content) {
        $this->content = $content;
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData():array {
        return [
            'content' => $this->content,
        ];
    }
}