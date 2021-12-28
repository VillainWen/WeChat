<?php
/*------------------------------------------------------------------------
 * MessageInterface.php
 *
 * 微信公众号回复接口
 *
 * Created on 2021-12-27
 *
 * Author: 蚊子 <1423782121@qq.com>
 *
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\OfficialAccount\Reply\Contract;


interface MessageInterface {

    /**
     * @param $to
     * @param $from
     * @param $payload
     * @return mixed
     */
    public function handle($to, $from, $payload);

    /**
     * 数据转xml
     * @param array $data
     * @return mixed
     */
    public function data2xml(array $data);
}