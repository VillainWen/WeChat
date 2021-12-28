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


namespace Villain\WeChat\OfficialAccount;


use Closure;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Villain\WeChat\Core\Request;
use Villain\WeChat\Contract\AccessInterface;

class Client extends Request {

    /**
     * @var null|AccessInterface
     */
    protected ?AccessInterface $access_token = null;

    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @return array
     * @throws GuzzleException
     */
    public function axios(string $url, string $method = "GET", $options = []): array {
        if (empty($this->middlewares)) {
            $this->registerMiddlewares();
        }

        $response = $this->request($url, $method, $options);
        $body = $response->getBody()->getContents();
        return json_decode($body, true);
    }

    /**
     * @param $url
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function httpGet($url, array $query = []): array {
        return $this->axios($url, 'GET', ['query' => $query]);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function httpPost(string $url, array $data = []):array {
        var_dump($data);
        return $this->axios($url, 'POST', ['form_params' => $data]);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = []):array {
        return $this->axios($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * 有媒体文件时候的请求
     * @param string $url
     * @param array $files
     * @param array $form
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function httpUpload(string $url, array $files = [], array $form = [], array $query = []):array {
        $multipart = [];
        $headers = [];

        if (isset($form['filename'])) {
            $headers = [
                'Content-Disposition' => 'form-data; name="media"; filename="'.$form['filename'].'"'
            ];
        }

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
                'headers' => $headers
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->axios(
            $url,
            'POST',
            ['query' => $query, 'multipart' => $multipart, 'connect_timeout' => 30, 'timeout' => 30, 'read_timeout' => 30]
        );
    }

    /**
     * 注册中间件
     */
    protected function registerMiddlewares() {
        // 重试
        $this->pushMiddleware($this->retryMiddleware(), 'retry');

        // 把access_token加到链接尾部
        $this->pushMiddleware($this->accessTokenMiddleware(), 'access_token');
    }

    /**
     * 重试
     * @return callable
     */
    protected function retryMiddleware(): callable {
        return Middleware::retry(
            function (
                $retries,
                RequestInterface $request,
                ResponseInterface $response = null
            ) {
                if ($retries < $this->app->config->get('http.max_retries', '1') && $response && $body = (string) $response->getBody()) {

                    $response = json_decode($body, true);

                    if (!empty($response['errcode']) && in_array(abs($response['errcode']), [40001, 40014, 42001], true)) {
                        // 刷新token
                        $this->app->access->refresh();
                        return true;
                    }
                }

                return false;
            },
            function () {
                return abs($this->app->config->get('http.retry_delay', 500));
            }
        );
    }

    /**
     * 权限中间件
     * @return Closure
     */
    protected function accessTokenMiddleware(): Closure {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                 if ($this->app->access) {
                     $request = $this->app->access->applyToRequest($request, $options);
                 }
                return $handler($request, $options);
            };
        };
    }
}