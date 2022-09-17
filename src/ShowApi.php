<?php

namespace API;

class ShowApi
{
    /**
     * @var string appid
     */
    public string $appid = '';
    /**
     * @var string secret
     */
    public string $secret = '';

    /**
     * @param string $appid
     * @param string $secret
     */
    public function __construct(string $appid, string $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    /**
     * 获取sgin
     * @param array $data
     * @return string
     */
    public function getSign(array $data): string
    {
        $str = '';
        foreach ($data as $k => $v) {
            $str .= $k . $v;
        }
        $str .= $this->secret;
        return md5($str);
    }

    /**
     * 请求
     * @param string $url 地址
     * @param array $data 请求参数
     * @return array
     */
    public function request(string $url, array $data): array
    {
        $data['showapi_appid'] = $this->appid;
        $data['showapi_timestamp'] = time();
        $sign = $this->getSign($data);
        $data['showapi_sign'] = $sign;
        $url = $url . '?' . http_build_query($data);

        $data = file_get_contents($url);
        return json_decode($data, true);
    }
}