<?php

namespace KlZkSdk\Tools;

use KlZkSdk\KlZkFatory;

class GateWay
{
    /**
     * @title 京东联盟官方配置
     * @var mixed
     */
    protected $appSecret;
    protected $unionId;

    const API_URL = 'https://cps.kaola.com/zhuanke/api?';

    /**
     * @var KlZkFatory
     */
    protected $fatory;


    /**
     * GateWay constructor.
     * @param array $config
     * @param KlZkFatory $fatory
     */
    public function __construct(array $config, KlZkFatory $fatory)
    {
        $this->unionId = $config['unionId'] ?? '';
        $this->appSecret = $config['appSecret'];
        $this->fatory = $fatory;
    }

    protected function setError($message, $code = 0)
    {
        $this->fatory->setError($message, $code);
        return false;
    }

    /**
     * 生成签名
     * @param $parameter
     * @return string
     */
    protected function getStringToSign($parameter)
    {
        ksort($parameter);
        $str = '';
        foreach ($parameter as $key => $value) {
            if (!empty($value)) {
                $str .= ($key) . ($value);
            }
        }
        $str = $this->appSecret . $str . $this->appSecret;
        return strtoupper(md5($str));
    }

    /**
     * 获取带签名基础参数
     * @param $method
     * @param array $specialParameter
     * @return array
     */
    protected function baseParameter($method, array $specialParameter)
    {
        $publicParameter = [
            'v'          => '1.0',
            'signMethod' => 'md5',
            'timestamp'  => date('Y-m-d H:i:s', time()),
            'unionId'    => $this->unionId,
            'method'     => $method,
        ];
        $publicParameter['sign'] = $this->getStringToSign(array_merge($publicParameter, $specialParameter));
        return $publicParameter;
    }


    /**
     * 发送参数请求
     * @param $method
     * @param $specialParameter
     * @param bool $raw
     * @return bool|string|array
     */
    protected function send($method, array $specialParameter, $raw = false)
    {
        $publicData = self::baseParameter($method, $specialParameter);

        $postData = array_merge($publicData, $specialParameter);

        $result = Helpers::curl_post(self::API_URL . http_build_query($postData), $postData, [
            'Accept：application/json; charset=UTF-8'
        ]);
        return $this->parseReps($result, $raw);
    }

    /**
     * 解析参数
     * @param $result
     * @param bool $raw
     * @return mixed
     */
    private function parseReps($result, $raw = false)
    {
        $decodeObject = json_decode($result, true);
        if (is_string($decodeObject)) {
            return $this->setError($decodeObject);
        }
        if (is_null($decodeObject)) {
            return $this->setError("Api返回结果为空");
        }

        if ($decodeObject['code'] != 200) {
            return $this->setError($decodeObject['desc'], $decodeObject['code']);
        }
        return $decodeObject['data'] ?? [];
    }
}