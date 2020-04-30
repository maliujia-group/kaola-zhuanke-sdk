<?php

namespace KlZkSdk;

use KlZkSdk\Api\Order;
use KlZkSdk\Api\Goods;
use KlzkSdk\Api\Link;

/**
 * @property Goods goods  查询商品API
 * @property Order order 活动API
 * @property Link link 跟单链接
 */
class KlZkFatory
{
    private $config;
    private $error;

    public function __construct($config = null)
    {
        if (empty($config)) {
            throw new \Exception('no config');
        }
        $this->config = $config;
        return $this;
    }

    public function __get($api)
    {
        try {
            $classname = __NAMESPACE__ . "\\Api\\" . ucfirst($api);
            if (!class_exists($classname)) {
                throw new \Exception('api undefined');
            }
            return new $classname($this->config, $this);
        } catch (\Exception $e) {
            throw new \Exception('api undefined');
        }
    }

    public function setError($message, $code = 0)
    {
        $this->error = [
            'code' => $code,
            'msg'  => $message
        ];
    }


    public function getError()
    {
        return $this->error;
    }


}