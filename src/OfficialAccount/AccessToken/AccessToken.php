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


namespace Villain\WeChat\OfficialAccount\AccessToken;


use Psr\Http\Message\RequestInterface;
use Villain\WeChat\Contract\AccessInterface;
use Villain\WeChat\Core\Container;
use Villain\WeChat\Core\Exceptions\RuntimeException;

class AccessToken implements AccessInterface {
    /**
     * @var Container
     */
    protected Container $app;

    protected string $prefix = 'villain.wechat.access_token.';

    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * @param bool $refresh
     * @return array
     * @throws RuntimeException
     */
    public function getToken(bool $refresh = false):array {
        $cache = $this->app->cache;

        $cache_key = $this->getCacheKey();

        if (!$refresh && $cache->has($cache_key) && $result = $cache->get($cache_key)) {
            return json_decode($result, true);
        }

        $token = $this->getAccessTokenForRemote();

        $this->setToken($token, $token['expires_in'] ?? 7000);

        return $token;
    }

    /**
     * 设置Token
     * @param $token
     * @param int $expires
     */
    public function setToken($token, $expires = 7200) {
        $cache_key = $this->getCacheKey();

        $this->app->cache->set($cache_key, json_encode($token,  320), $expires);
    }

    /**
     * @return mixed
     */
    public function getAccessTokenForRemote() {
        $credential = $this->app->config->get('credentials', []);
        $credential = array_merge(['grant_type' => 'client_credential'], $credential);
        $query = ['query' => $credential];
        $response = $this->app->request->request('cgi-bin/token', 'GET', $query);

        $body = (string) $response->getBody();

        return json_decode($body, true);
    }

    /**
     * 获取缓存Key
     * @return string
     */
    protected function getCacheKey(): string {
        return $this->prefix . json_encode($this->app->config->get('credentials'));
    }

    /**
     * @return AccessInterface
     * @throws RuntimeException
     */
    public function refresh(): AccessInterface {
        $this->getToken(true);
        return $this;
    }

    /**
     *
     * @param RequestInterface $request
     * @param array $requestOptions
     * @return RequestInterface
     * @throws RuntimeException
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface {
        // 获取请求参数
        parse_str($request->getUri()->getQuery(), $query);

        // 把Token组装诚
        $token = $this->getToken();
        $query = http_build_query(array_merge(['access_token' => $token['access_token']], $query));

        return $request->withUri($request->getUri()->withQuery($query));
    }
}