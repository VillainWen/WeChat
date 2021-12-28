<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * Collection.php
 * 	
 * 重写isset，get， set，unset方法
 *
 * Created on 2021-12-01 10:49:30
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\Contract;

use ArrayAccess;
use Villain\WeChat\Utils\Arr;

class Collection implements ArrayAccess {

    /**
     * 初始化
     * Collection constructor.
     * @param array $items
     */
    public function __construct(array $items = []) {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param $key
     * @return bool
     */
    public function exists ($key):bool {
        return !is_null(Arr::get($this->data, $key));
    }

    /**
     * 重写isset方法 可以递归判断
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool {
        return $this->exists($offset);
    }

    /**
     * 获取数组元素
     * @param $key
     * @param null $default
     * @return array|mixed|null
     */
    public function get($key, $default = null) {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * 重写数组获取方法
     * 例如：$a = $data['a']
     * @param mixed $offset
     * @return array|mixed|null
     */
    public function offsetGet($offset): ?array {
        return $this->offsetExists($offset) ? $this->get($offset) : null;
    }

    /**
     * 设置数组， 可以多维
     * @param $key
     * @param $value
     */
    public function set($key, $value)  {
        Arr::set($this->data, $key, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }

    /**
     * 移除数组元素
     * @param $key
     */
    public function remove($key) {
        Arr::remove($this->data, $key);
    }

    /**
     * 重写unset方法 可以深度递归
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        if ($this->offsetExists($offset)) {
            $this->remove($offset);
        }
    }
}