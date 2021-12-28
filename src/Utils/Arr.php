<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * Villain\WeChat\Utils\Arr.php
 * 	
 * 数组的助手函数 get, set, has, exist, delete, add
 *
 * Created on alt+t
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\Utils;

class Arr {

    /**
     * 向数组添加元素
     * @param array $array
     * @param $key
     * @param $value
     * @return array
     */
    public static function add(array $array, $key, $value):array {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * 重写设置数组
     * 例如：key => a.b.c.d value => 1 则会在基础数组array递归生成对应子集 ['a' => ['b' => ['c' => ['d' => 1]]]];
     * @param array $array
     * @param $key
     * @param $value
     * @return array|mixed 例如key => a.b.c.d value => 1 则回返回 ['d' => 1]
     */
    public static function set(array &$array, $key, $value): array {
        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * 多维数组判断元素是否存在数组
     * @param array $array
     * @param $keys
     * @return bool
     */
    public static function has(array $array, $keys): bool {
        if (is_null($keys)) {
            return false;
        }

        $keys = (array) $keys;

        if (empty($array)) {
            return false;
        }

        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subArray = $array;

            if (static::exist($array, $key)) {
                continue;
            }

            foreach (explode('.', $key) as $item) {
                if (static::exist($subArray, $item)) {
                    $subArray = $subArray[$item];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 重写元素是否存在数组里
     * @param array $array
     * @param $key
     * @return bool
     */
    public static function exist(array $array, $key): bool {
        return array_key_exists($key, $array);
    }

    /**
     * 获取数组值
     * 如key => 'a.b' array => ['a' => ['b' => 1]] 则返回 1
     * @param array $array
     * @param $key
     * @param null $default
     * @return array|mixed|null|int|string
     */
    public static function get(array $array, $key, $default = null) {
        if (is_null($key)) {
            return $array;
        }

        if (static::exist($array, $key)) {
            return $array[$key];
        }

        $arr_key = explode('.', $key);
        foreach ($arr_key as $item) {
            if (static::exist($array, $item)) {
                $array = $array[$item];
            } else {
                return $default;
            }
        }

        return $array;
    }


    /**
     * 删除一个或多个数组的元素
     * @param array $array
     * @param $keys
     */
    public static function remove(array &$array, $keys):void {
        // 记录原来的数组
        $old = &$array;

        $keys = (array) $keys;

        //
        if (0 === count($keys)) {
            return;
        }

        foreach ($keys as $key) {
            if (static::exist($array, $key)) {
                unset($array[$key]);
                continue;
            }

            // 多维数组处理
            $parts = explode('.', $key);

            $array = &$old;

            // 递归删除
            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }
}