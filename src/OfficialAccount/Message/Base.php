<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * Base.php
 * 	
 * Base
 *
 * Created on alt+t
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\OfficialAccount\Message;


class Base implements MessageInterface {


    /**
     * @var array
     */
    protected array $properties = [];

    /**
     * @var string
     */
    protected string $type;

    /**
     * 是否必填
     * @var array
     */
    protected array $required = [];

    public function getData(): array {

        return [];
    }

    public function setAttribute($key, $value) {
        $this->properties[$key] = $value;
    }

    /**
     * 判断key是否存在
     * @param $key
     * @return bool
     */
    public function has($key):bool {
        return array_key_exists($key, $this->properties);
    }

    /**
     * 是否通过
     * @return bool
     */
    public function validate ():bool {
        foreach ($this->required as $value) {
            if (!$this->has($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 获取数据
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null) {
        if ($this->has($key)) {
            return $this->properties[$key];
        }

        return $default;
    }

    /**
     * 获取类型
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }
}