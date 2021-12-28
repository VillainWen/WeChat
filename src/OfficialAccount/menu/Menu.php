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


namespace Villain\WeChat\OfficialAccount\Menu;


use Villain\WeChat\Core\Container;

class Menu {
    protected Container $app;
    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * 获取自定义菜单
     * @return mixed
     */
    public function list() {
        return $this->app->client->httpGet('cgi-bin/menu/get');
    }

    /**
     * 查询接口
     * @return mixed
     */
    public function current() {
        return $this->app->client->httpGet('cgi-bin/get_current_selfmenu_info');
    }

    /**
     * 创建菜单包含个性化菜单
     * @param array $buttons
     * @param array $matchRule
     * @return mixed
     */
    public function create(array $buttons, array $matchRule = []) {
        if (!empty($matchRule)) {
            return $this->app->client->httpPostJson('cgi-bin/menu/addconditional', [
                'button' => $buttons,
                'matchrule' => $matchRule,
            ]);
        }

        return $this->app->client->httpPostJson('cgi-bin/menu/create', ['button' => $buttons]);
    }

    /**
     * 删除某个菜单
     * @param int|null $menuId
     * @return mixed
     */
    public function delete(int $menuId = null) {
        if (is_null($menuId)) {
            return $this->app->client->httpGet('cgi-bin/menu/delete');
        }

        return $this->app->client->httpPostJson('cgi-bin/menu/delconditional', ['menuid' => $menuId]);
    }

    /**
     * 个性化菜单匹配结果
     * @param string $userId
     * @return mixed
     */
    public function match(string $userId) {
        return $this->app->client->httpPostJson('cgi-bin/menu/trymatch', ['user_id' => $userId]);
    }
}