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
namespace Villain\WeChat\OfficialAccount\User;

use Villain\WeChat\Core\Container;

class User {
    protected Container $app;

    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * 用户信息
     * @param $openId
     * @return mixed
     */
    public function info ($openId) {
        return $this->app->client->httpGet('cgi-bin/user/info', ['openid' => $openId, 'lang' => 'zh_CN']);
    }

    /**
     * 批量获取信息
     * @param array $list
     * @return mixed
     */
    public function batch (array $list) {
        $data['user_list'] = $list;
        return $this->app->client->httpPostJson('cgi-bin/user/info/batchget', $data);
    }

    /**
     * 设置用户备注名
     * @param $openid
     * @param $remark
     * @return mixed
     */
    public function remark($openid, $remark) {
        $data['openid'] = $openid;
        $data['remark'] = $remark;

        return $this->app->client->httpPostJson('cgi-bin/user/info/updateremark', $data);
    }

    /**
     * 获取用户列表
     * @param null $next_openid
     * @return mixed
     */
    public function list($next_openid = null) {
        $data = [];
        if (!is_null($next_openid)) {
            $data['next_openid'] = $next_openid;
        }
        return $this->app->client->httpGet('cgi-bin/user/get', $data);
    }

    /**
     * 黑名单
     * @return mixed
     */
    public function back_list($begin_openid = null) {
        $data = [];
        if (!is_null($begin_openid)) {
            $data['next_openid'] = $begin_openid;
        }
        return $this->app->client->httpPostJson('cgi-bin/tags/members/getblacklist', $data);
    }

    /**
     * 拉黑用户
     * @param array $openid
     * @return mixed
     */
    public function pull_back(array $openid) {
        $data['openid_list'] = $openid;
        return $this->app->client->httpPostJson('cgi-bin/tags/members/batchblacklist', $data);
    }

    /**
     * 取消拉黑用户
     * @param array $openid
     * @return mixed
     */
    public function un_back(array $openid) {
        $data['openid_list'] = $openid;
        return $this->app->client->httpPostJson('cgi-bin/tags/members/batchunblacklist', $data);
    }
}