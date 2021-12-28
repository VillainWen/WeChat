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


namespace Villain\WeChat\OfficialAccount\Server;


use Closure;
use Symfony\Component\HttpFoundation\Response;
use Villain\WeChat\Contract\EventHandlerInterface;
use Villain\WeChat\Core\Container;
use Villain\WeChat\Core\Exceptions\RuntimeException;
use Villain\WeChat\Utils\Xml;

class Server {
    protected Container $app;

    protected array $handler = [];

    protected array $MsgType = [
        'text', 'voice', 'video', 'image', 'shortvideo', 'location', 'link', 'event'
    ];

    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * @throws RuntimeException
     */
    public function server() {
        // TODO: 增加日志

        // 验证签名是否正确
        $this->validate()->resolve();

    }

    /**
     * @return $this
     * @throws RuntimeException
     */
    public function validate(): Server {
        $sign = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];

        $signature = $this->signature($this->getToken(), $timestamp, $nonce);

        if ($sign !== $signature) {
            throw new RuntimeException('Invalid request signature.');
        }

        return $this;
    }

    /**
     * @param $handler
     * @param string $key
     * @throws RuntimeException
     */
    public function push($handler, string $key) {

        if (!in_array($key, $this->MsgType)) {
            throw new RuntimeException('Invalid key value');
        }

        if (!isset($this->handler[$key])) {
            $this->handler[$key] = [];
        }

        if (!class_exists($handler)) {
            throw new RuntimeException(sprintf('Class "%s" not exists.', $handler));
        }

        array_push($this->handler[$key], $handler);
    }

    /**
     * 解析数据
     */
    public function resolve() {
        // 解析数据
        $data = $this->getData();

        // 如果存在echostr字段则直接返回
        if (isset($_GET['echostr'])) { 
            $response = new Response($_GET['echostr']);
            $response->send();
        } else {
            // 判断消息类型
            $msg_type = $data['MsgType'];

            $this->dispatch($msg_type, $data);
        }

    }

    /**
     * 触发
     * @param string $msg_type
     * @param array $data
     */
    public function dispatch(string $msg_type, Array $data) {
        // 获取处理器
        $handler = $this->handler[$msg_type];

        foreach ($handler as $key => $value) {
            $callable = null;

            $callable = new $value();
            $callable->handle($this->app, $data);

            unset($callable);
        }
    }

    /**
     * 获取微信发送请求
     * @return array
     */
    protected function getData ():array {
        $xml = file_get_contents("php://input");
        return Xml::xml2Array($xml);
    }

    /**
     * 生成签名
     * @param $token
     * @param $timestamp
     * @param $nonce
     * @return string
     */
    protected function signature($token, $timestamp, $nonce): string {
        $data = array($token, $timestamp, $nonce);
        sort($data,SORT_STRING);
        return sha1(implode($data));
    }

    /**
     * 获取token
     * @return mixed
     */
    protected function getToken () {
        return $this->app->config->get('token');
    }
}