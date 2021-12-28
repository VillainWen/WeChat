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


namespace Villain\WeChat\Core;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\choose_handler;

class Request {
    protected array $defaults = [];

    /**
     * 处理器
     * @var HandlerStack|null
     */
    protected ?HandlerStack $stack = null;

    /**
     * 中间件
     * @var array
     */
    protected array $middlewares = [];

    protected Container $app;

    public function __construct (Container $app, array $config) {
        $this->app = $app;
        $this->defaults = array_merge($this->defaults, $config);;
    }

    /**
     * 请求
     * @param $url
     * @param string $method
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function request ($url, $method = "GET", $options = []):ResponseInterface {
        $method = strtoupper($method);

        $config = $this->defaults;
        $options = array_merge($config, $options, ['handler' => $this->getStack()]);

        // 格式化数据
        $options = $this->formatOptions($options);

        $client = new Client($options);

        $response = $client->request($method, $url);

        // Guzzle getBody第一次获取时可以获取全部内容，
        // 第二次获取时会是空值，使用rewind方法，流指针倒回开始位置
        $response->getBody()->rewind();

        return $response;
    }

    /**
     * 格式化json数据
     * @param array $options
     * @return array
     */
    protected function formatOptions(array $options):array {
        if (isset($options['json']) && is_array($options['json'])) {
            $options['headers'] = array_merge($options['headers'] ?? [], ['Content-Type' => 'application/json']);
            if (empty($options['json'])) {
                $options['body'] = \GuzzleHttp\json_encode($options['json'], JSON_FORCE_OBJECT);
            } else {
                $options['body'] = \GuzzleHttp\json_encode($options['json'], JSON_UNESCAPED_UNICODE);
            }

            unset($options['json']);
        }
        return $options;
    }

    /**
     * 设置处理器
     * @param HandlerStack $stack
     * @return $this
     */
    public function setStack (HandlerStack $stack): Request {
        $this->stack = $stack;

        return $this;
    }

    /**
     * 添加中间件
     * @param callable $middleware
     * @param string|null $name
     * @return $this
     */
    public function pushMiddleware (callable $middleware, string $name = null): Request {
        if (!is_null($name)) {
            $this->middlewares[$name] = $middleware;
        } else {
            array_push($this->middlewares, $middleware);
        }

        return $this;
    }

    /**
     * 获取中间件
     * @return array
     */
    public function getMiddlewares(): array {
        return $this->middlewares;
    }

    /**
     * 获取处理器
     * @return HandlerStack
     */
    public function getStack(): HandlerStack  {
        if ($this->stack) {
            return $this->stack;
        }

        $this->stack = HandlerStack::create(choose_handler());

        // 向处理器设置中间件
        foreach ($this->middlewares as $key => $value) {
            $this->stack->push($value, $key);
        }

        return $this->stack;
    }
}