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


namespace Villain\WeChat\OfficialAccount\Customer;

use Villain\WeChat\Core\Exceptions\RuntimeException;
use Villain\WeChat\OfficialAccount\Base;
use Villain\WeChat\OfficialAccount\Message\MessageInterface;

class Customer extends Base {
    /**
     * @var MessageInterface
     */
    protected MessageInterface $message;
    protected string $openid;
    protected string $account;

    /**
     * 获取客服列表
     * @return mixed
     */
    public function list () {
        return $this->app->client->httpGet('cgi-bin/customservice/getkflist');
    }

    /**
     * 获取在线客服
     * @return mixed
     */
    public function online() {
        return $this->app->client->httpGet('cgi-bin/customservice/getonlinekflist');
    }

    /**
     * 创建客服
     * @param string $account
     * @param string $nickname
     * @return mixed
     */
    public function create(string $account, string $nickname) {
        $params = [
            'kf_account' => $account,
            'nickname' => $nickname,
        ];

        return $this->app->client->httpPostJson('customservice/kfaccount/add', $params);
    }

    /**
     * 更新客服信息
     * @param string $account
     * @param string $nickname
     * @return mixed
     */
    public function update(string $account, string $nickname) {
        $params = [
            'kf_account' => $account,
            'nickname' => $nickname,
        ];

        return $this->app->client->httpPostJson('customservice/kfaccount/update', $params);
    }

    /**
     * 删除客服
     * @param string $account
     * @return mixed
     */
    public function delete(string $account) {
        return $this->app->client->httpPostJson('customservice/kfaccount/del', [], ['kf_account' => $account]);
    }

    /**
     * 邀请绑定客服帐号
     * @param string $account
     * @param string $wechatId
     * @return mixed
     */
    public function invite(string $account, string $wechatId) {
        $params = [
            'kf_account' => $account,
            'invite_wx' => $wechatId,
        ];

        return $this->app->client->httpPostJson('customservice/kfaccount/inviteworker', $params);
    }

    /**
     * 设置头像
     * @param string $account
     * @param string $path
     * @return mixed
     */
    public function setAvatar(string $account, string $path) {
        return $this->app->client->httpUpload('customservice/kfaccount/uploadheadimg', ['media' => $path], [], ['kf_account' => $account]);
    }

    /**
     * 设置消息
     * @param MessageInterface $message
     * @return $this
     */
    public function message(MessageInterface $message): Customer {
        $this->message = $message;
        return $this;
    }

    /**
     * 发送
     * @param string $openid
     * @return $this
     */
    public function to(string $openid): Customer {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @throws RuntimeException
     */
    public function send() {
        // 设置消息
        if (!$this->message->validate()) {
            throw new RuntimeException('message params error');
        }

        $messageData = $this->formatMessage();
        return $this->app->client->httpPostJson('cgi-bin/message/custom/send', $messageData);
    }

    /**
     * 获取消息数据
     * @return array
     */
    protected function formatMessage ():array {
        $type = $this->message->getType();
        $data['touser'] = $this->openid;
        $data['msgtype'] = $type;
        $data[$type] = $this->message->getData();

        if ($this->account) {
            $data['customservice'] = ['kf_account' => $this->account];
        }

        return $data;
    }
}