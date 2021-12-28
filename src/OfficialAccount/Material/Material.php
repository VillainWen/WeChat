<?php declare(strict_types=1);
/*------------------------------------------------------------------------
 * Material.php
 * 	
 * 素材管理
 *
 * Created on alt+t
 *
 * Author: 蚊子 <1423782121@qq.com>
 * 
 * Copyright (c) 2021 All rights reserved.
 * ------------------------------------------------------------------------
 */


namespace Villain\WeChat\OfficialAccount\Material;


use Villain\WeChat\Core\Container;
use Villain\WeChat\Core\Exceptions\RuntimeException;
use Villain\WeChat\OfficialAccount\Message\Article;

class Material {

    protected Container $app;
    public function __construct(Container $app) {
        $this->app = $app;
    }

    /**
     * 上传图片素材
     * @param string $path
     * @return mixed
     * @throws RuntimeException
     */
    public function uploadImage(string $path) {
        return $this->upload('image', $path);
    }

    /**
     * 上传语音
     * @param string $path
     * @return mixed
     * @throws RuntimeException
     */
    public function uploadVoice(string $path)  {
        return $this->upload('voice', $path);
    }

    /**
     * 上传缩略图
     * @param string $path
     * @return mixed
     * @throws RuntimeException
     */
    public function uploadThumb(string $path) {
        return $this->upload('thumb', $path);
    }

    /**
     * 上传视频
     * @param string $path
     * @param string $title
     * @param string $description
     * @return mixed
     * @throws RuntimeException
     */
    public function uploadVideo(string $path, string $title, string $description) {
        $params = [
            'description' => json_encode(
                [
                    'title' => $title,
                    'introduction' => $description,
                ],
                JSON_UNESCAPED_UNICODE
            ),
        ];

        return $this->upload('video', $path, $params);
    }

    /**
     * 上传素材
     * @param $type
     * @param $path
     * @param array $form
     * @return mixed
     * @throws RuntimeException
     */
    public function upload($type, $path, array $form = []) {
        if (!file_exists($path) || !is_readable($path)) {
            throw new RuntimeException(sprintf('File does not exist, or the file is unreadable: "%s"', $path));
        }
        $form['type'] = $type;

        $api = $this->getApi($type);

        return $this->app->client->httpUpload($api, ['media' => $path], $form);
    }

    /**
     * @param $type
     * @return string
     */
    public function getApi($type):string {
        switch ($type) {
            case 'news_image': $api = 'cgi-bin/media/uploadimg';break;
            default: $api = 'cgi-bin/material/add_material';break;
        }
        return $api;
    }

    /**
     * 上传临时素材
     * @param $type // image 10M|voice 2M|video 10MB|thumb 64KB
     * @param string $path
     * @param array $from
     * @return mixed
     */
    public function uploadTempMaterial ($type, string $path, array $from = []) {
        $files = [
            'media' => $path
        ];

        return $this->app->client->httpUpload('cgi-bin/media/upload', $files, $from, ['type' => $type]);
    }

    /**
     * 图文素材
     * @param Article $articles
     * @return mixed
     */
    public function uploadArticle (Article $articles) {
        if ($articles instanceof Article || !empty($articles->getData['title'])) {
            $articles = [$articles->getData()];
        }

        $params = [
            'articles' => $articles
        ];

        return $this->app->client->httpPostJson('cgi-bin/material/add_news', $params);
    }

    /**
     * @param string $mediaId
     * @param $article
     * @param int $index
     * @return mixed
     */
    public function updateArticle(string $mediaId, $article, int $index = 0) {
        if ($article instanceof Article) {
            $article = [$article->getData()];
        }

        $params = [
            'media_id' => $mediaId,
            'index' => $index,
            'articles' => isset($article['title']) ? $article : (isset($article[$index]) ? $article[$index] : []),
        ];

        return $this->app->client->httpPostJson('cgi-bin/material/update_news', $params);
    }

    /**
     * 上传文章图片素材
     * @param string $path
     * @return mixed
     * @throws RuntimeException
     */
    public function uploadArticleImage(string $path) {
        return $this->upload('news_image', $path);
    }

    /**
     * 获取素材信息
     * @param string $mediaId
     * @return mixed
     */
    public function get (string $mediaId) {
        return $this->app->client->httpPostJson('cgi-bin/material/get_material', [
            'media_id' => $mediaId
        ]);
    }

    /**
     * 删除素材
     * @param string $mediaId
     * @return mixed
     */
    public function delete(string $mediaId) {
        return $this->app->client->httpPostJson('cgi-bin/material/del_material', ['media_id' => $mediaId]);
    }

    /**
     * 获取素材列表
     * @param string $type // 图片（image）、视频（video）、语音 （voice）、图文（news
     * @param int $offset
     * @param int $count
     * @return mixed
     */
    public function list(string $type, int $offset = 0, int $count = 20) {
        $params = [
            'type' => $type,
            'offset' => $offset,
            'count' => $count,
        ];

        return $this->app->client->httpPostJson('cgi-bin/material/batchget_material', $params);
    }

    /**
     * 获取素材总数
     * @return mixed
     */
    public function stats() {
        return $this->app->client->httpGet('cgi-bin/material/get_materialcount');
    }
}