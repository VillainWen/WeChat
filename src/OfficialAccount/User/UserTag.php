<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * File.php
 * 	
 * 用户标签
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

class UserTag {

    protected Container $app;

    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * 创建用户标签
     * @param string $name
     * @return mixed
     */
    public function create(string $name) {
        return $this->app->client->httpPostJson('cgi-bin/tags/create', ['name' => $name]);
    }

    /**
     * 获取标签
     * @return mixed
     */
    public function list () {
        return $this->app->client->httpGet('cgi-bin/tags/get');
    }

    /**
     * 修改
     * @param $id
     * @param $name
     * @return mixed
     */
    public function update($id, $name) {
        return $this->app->client->httpPostJson('cgi-bin/tags/create', ['tags' => [
            'id' => $id,
            'name' => $name
        ]]);
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function delete ($id) {
        return $this->app->client->httpPostJson('cgi-bin/tags/create', ['tags' => [
            'id' => $id,
        ]]);
    }

    /**
     * 获取标签下粉丝列表
     * @param int $tagId
     * @param string $nextOpenId
     * @return mixed
     */
    public function tag_user(int $tagId, string $nextOpenId = '') {
        $params = [
            'tagid' => $tagId,
            'next_openid' => $nextOpenId,
        ];

        return $this->app->client->httpPostJson('cgi-bin/user/tag/get', $params);
    }

    /**
     * 批量为用户打标签 一个用户最多20个标签
     * @param array $users
     * @param $tags
     * @return mixed
     */
    public function tagging (array $users, $tags) {
        $data['openid_list'] = $users;
        $data['tagid'] = $tags;

        return $this->app->client->httpPostJson('cgi-bin/tags/members/batchtagging', $data);
    }

    /**
     * 批量为用户取消标签
     * @param array $users
     * @param $tags
     * @return mixed
     */
    public function untagging(array $users, $tags) {
        $data['openid_list'] = $users;
        $data['tagid'] = $tags;

        return $this->app->client->httpPostJson('cgi-bin/tags/members/batchuntagging', $data);
    }

    /**
     * 获取用户身上的标签列表
     * @param $openid
     * @return mixed
     */
    public function get($openid) {
        return $this->app->client->httpPostJson('cgi-bin/tags/getidlist', ['openid' => $openid]);
    }
}