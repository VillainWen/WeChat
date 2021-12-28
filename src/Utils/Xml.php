<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * Xml.php
 * 	
 * Xml解析、Xml转数组、数组转XML
 *
 * Created on 2021-12-15
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\Utils;


class Xml {
    /**
     * 解析xml
     * @param string $content
     * @return array
     */
    public static function parse(string $content):array {
        // 格式化字符串
        $str = self::format($content);

        // 将字符串转化为xml格式
        $xml = simplexml_load_string($str, 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_NOCDATA | LIBXML_NOBLANKS);

        // 将xml格式转成数组形式
        return self::xml2Array($xml);
    }

    /**
     * 格式化字符串数据
     * @param $xml
     * @return string|string[]|null
     */
    public static function format (string $xml) {
        return preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]+/u', '', $xml);
    }

    /**
     * xml转数组
     * @param $xml
     * @return array
     */
    public static function xml2Array($xml):array {
        $result = null;
        if (is_object($xml)) {
            $result = (array) $xml;
        }

        if (is_array($xml)) {
            foreach ($xml as $key => $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * xml转Json
     * @param $xml
     * @return false|string
     */
    public static function xml2Json($xml) {
        return json_encode(self::xml2Array($xml), 320);
    }

    /**
     * data转xml
     * @param $data
     * @param string $item
     * @param string $id
     * @return string
     */
    public static function data2Xml($data, $item = 'item', $id = 'id'): string {
        $xml = $attr = '';

        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $id && $attr = " {$id}=\"{$key}\"";
                $key = $item;
            }

            $xml .= "<{$key}{$attr}>";

            if ((is_array($val) || is_object($val))) {
                $xml .= self::data2Xml((array) $val, $item, $id);
            } else {
                $xml .= is_numeric($val) ? $val : self::cdata($val);
            }

            $xml .= "</{$key}>";
        }

        return $xml;
    }

    /**
     * 设置cdata
     * @param $string
     * @return string
     */
    public static function cdata($string): string {
        return sprintf('<![CDATA[%s]]>', $string);
    }
}