<?php

namespace Test;

require_once '../vendor/autoload.php';

use Villain\WeChat\OfficialAccount\Message\Article;
use Villain\WeChat\OfficialAccount\Message\News;
use Villain\WeChat\OfficialAccount\Message\NewsItem;
use Villain\WeChat\OfficialAccount\Message\Text;
use Villain\WeChat\WeChat;

$a = WeChat::OfficialAccount(['credentials' => [
    'appid' => 'wx415998ee51f1ab04',
    'secret' => 'ad21a43874facf914ce778691da4ad9d'
]]);
//$b = $a->cache->delete('villain.wechat.access_token.' . json_encode([
//        'appid' => 'wx415998ee51f1ab04',
//        'secret' => 'ad21a43874facf914ce778691da4ad9d'
//    ], 320));
//$button = "{'menu':{'button':[{'name':'创作者','sub_button':[{'type':'view','name':'创作者中心','url':'http:\/\/magictool.9iweb.com.cn\/creatorCenter'tton':[]},{'type':'view','name':'发布','url':'http:\/\/magictool.9iweb.com.cn\/publish','sub_button':[]}]},{'type':'view','name':'首页','url':'http:\/\/ctool.9iweb.com.cn','sub_button':[]}]}}";
//$json = json_decode($button, true);
////$b = $a->menu->create($json['menu']);
//var_dump($button);
//var_dump($json);
//var_dump(json_encode(['menu' => [
//        'button' => [['a' => 'b'], ['a' => 'c']]
//    ]
//], 320));
// 测试菜单列表
//$list = $a->menu->list();
//var_dump($list);

// 测试创建菜单
//$button = [
//    [
//        'type' => 'view',
//        'name' => '测试',
//        'url' => 'http://magictool.9iweb.com.cn/creatorCenter'
//    ]
//];
//$b = $a->menu->create($button, [
//    'client_platform_type' => 1
//]);
//var_dump($b);

//$b = $a->menu->delete(423188506);
//var_dump($b);

//
//$value = 'ContentId';
//$delimiter = "_";
//$a = preg_replace('/(.)(?=[A-Z])/', '$1'.$delimiter, $value);
//var_dump($a);

// 客服消息测试
//$message = new Text('ces');
////var_dump($message);

$item = new NewsItem([
    'url' => 'a',
    'image' => 'https://mmbiz.qpic.cn/mmbiz_png/LrcjpdpM1uFm195uNALw8LZPxzxiaiaIvBXT4SobiaSCkpKCV6B4QgV4pSefiahxSESBECXNnc1FUoIEAvYImjkOOA/0?wx_fmt=png',
    'title' => 'c',
    'description' => 'd',
]);

//$message = new News($item->getData());
//$b = $a->customer->message($message)->to('omD-VuE-_JqqKpogu1mCniTR3_zU')->send();
//var_dump($b);

// 素材管理
// 图片 _C8J2ZW2dsywarC_0un4B9255cQNvfNdtAdDMNTKmZ4

//$b = $a->material->uploadImage('/Users/villain/Logo图片/icon600*600.png');
//$b = $a->material->uploadTempMaterial('image', '/Users/villain/Logo图片/icon600*600.png');
//$message = new Article([
//    'thumb_media_id' => '_C8J2ZW2dsywarC_0un4B9255cQNvfNdtAdDMNTKmZ4',
//    'author' => 'asd',
//    'title' => '测试',
//    'content' => '啊啊啊啊',
//    'digest' => 'aaaaaa',
//    'content_source_url' => 'content_source_url',
//    'show_cover_pic' => '0'
//]);
//$message = new Article([
//    'thumb_media_id' => '_C8J2ZW2dsywarC_0un4B9255cQNvfNdtAdDMNTKmZ4',
//    'author' => 'asd',
//    'title' => '测试',
//    'content' => '啊啊啊啊',
//    'digest' => 'aaaaaaaaa',
//    'content_source_url' => 'content_source_url',
//    'show_cover_pic' => '0'
//]);
//$b = $a->material->get('_C8J2ZW2dsywarC_0un4B8L-BDJbo4cQqSv-RV6Olx8');
//$b = $a->material->stats();
//var_dump($b);
//var_dump($b);

//
//$b = $a->qrcode->create('QR_LIMIT_SCENE', ['scene_id' => 21]);
//var_dump($b);

//$b = $a->user->batch([
//    'openid' => 'omD-VuE-_JqqKpogu1mCniTR3_zU',
//    'lang' => 'zh_CN'
//]);
//var_dump($b);