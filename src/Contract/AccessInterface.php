<?php


namespace Villain\WeChat\Contract;


use Psr\Http\Message\RequestInterface;

interface AccessInterface {
    /**
     * 获取Token
     * @return array
     */
    public function getToken(): array;

    /**
     * 刷新
     * @return $this
     */
    public function refresh(): self;

    /**
     * 将Token加入到其他请求中
     * @param RequestInterface $request
     * @param array $requestOptions
     * @return RequestInterface
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface;

}