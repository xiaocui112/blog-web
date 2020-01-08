<?php

namespace App\Handlers;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler{
    /**
     * 翻译
     *
     * @param string $text
     * @return string
     */
    public function translate(string $text)
    {
        // $http=new Client();
        // $api= 'http://api.fanyi.baidu.com/api/trans/vip/translate';
        // $appid = config('services.baidu_translate.appid');
        // $key = config('services.baidu_translate.key');
        // $salt = time();
        // if (empty($appid) || empty($key)) {
        //     return $this->pinyin($text);
        // }
        // $sign = md5($appid . $text . $salt . $key);
        // $query = http_build_query([
        //     "q"     =>  '我很好',
        //     "from"  => "zh",
        //     "to"    => "en",
        //     "appid" => $appid,
        //     "salt"  => $salt,
        //     "sign"  => $sign,
        // ]);
        // $response = $http->get($api . $query);

        // $result = json_decode($response->getBody(), true);
        // if (isset($result['trans_result'][0]['dst'])) {
        //     return Str::slug($result['trans_result'][0]['dst']);
        // } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyin($text);
        // }
    }
    public function pinyin(string $text)
    {
        return Str::slug((new Pinyin())->permalink($text));
    }
}