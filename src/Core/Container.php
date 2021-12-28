<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * Container.php
 * 	
 * 应用容器
 *
 * Created on 2021-12-01 09:30:21
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\Core;

use Pimple\Container as PimpleContainer;
use Villain\WeChat\Core\Providers\CacheProviders;
use Villain\WeChat\Core\Providers\ClientProviders;
use Villain\WeChat\Core\Providers\ConfigProviders;
use Villain\WeChat\Core\Providers\RequestProviders;

/**
 * @property mixed client
 * @property mixed config
 */
class Container extends PimpleContainer {
    /**
     * 应用类集合
     * @var array
     */
    public array $providers = [];

    /**
     * 自定义配置
     * @var array
     */
    protected array $customerConfig = [];

    public function __construct(array $config = [], $prepends = []) {
        // 自定义配置
        $this->customerConfig = $config;

        parent::__construct($prepends);

        // 将应用类注册到容器里
        $this->registerProviders($this->getProviders());
    }

    public function __get($id){
        return $this->offsetGet($id);
    }

    public function __set($id, $value) {
        $this->offsetSet($id, $value);
    }


    /**
     * 获取配置
     * @return array
     */
    public function getConfig (): array {
        $base = [
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'https://api.weixin.qq.com/',
            ],
        ];
        return array_replace_recursive($base, [], $this->customerConfig);
    }

    /**
     * @param array $providers
     */
    public function registerProviders (array $providers) {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    /**
     * 合并默认类和应用类
     * @return array
     */
    public function getProviders():array {
        return array_merge([
            ConfigProviders::class,
            CacheProviders::class,
            RequestProviders::class,
            ClientProviders::class
        ], $this->providers);
    }
}