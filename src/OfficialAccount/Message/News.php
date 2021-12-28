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


class News extends Base {
    protected string $type = 'news';

    protected array $items = [];

    public function __construct($items) {
        $this->items= $items;
    }

    /**
     * 获取数据
     * @return array[]|\array[][]
     */
    public function getData(): array {
        if (isset($this->items['title'])) {
            $news = [$this->items];
        } else {
            $news = $this->items;
        }

        return ['articles' => $news];
    }

}