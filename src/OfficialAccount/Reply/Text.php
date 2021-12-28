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


namespace Villain\WeChat\OfficialAccount\Reply;

use Villain\WeChat\Utils\Xml;
class Text implements Contract\MessageInterface {

    /**
     * @inheritDoc
     */
    public function handle($to, $from, $payload) {

    }

    /**
     * @param array $data
     * @return mixed|string
     */
    public function data2xml(array $data) {
        $data['CreateTime'] = time();
        return Xml::data2Xml($data);
    }
}