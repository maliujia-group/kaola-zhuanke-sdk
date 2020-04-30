<?php

namespace KlZkSdk\Api;

use KlZkSdk\Tools\GateWay;

class Order extends GateWay
{

    /**
     * 按时间段查询订单列表
     * @param $startTime
     * @param $endTime
     * @param int $type
     * @return array|bool|string
     * @throws \Exception
     */
    public function queryRange($startTime, $endTime, $type = 1)
    {
        // 查询类型，默认1 为下单时间段查询，否则都按更新时间段查询
        $queryType = $type == 1 ? 1 : 3;
        $start     = is_numeric($startTime) ? $startTime : strtotime($startTime);
        $end       = is_numeric($endTime) ? $endTime : strtotime($endTime);
        if ($end - $start > 3600) {
            return $this->setError("订单按照时间段查询，时间段不得大于1小时");
        }
        return $this->send("kaola.zhuanke.api.queryOrderInfo", [
            'type'      => $queryType,
            'startDate' => $start * 1000,
            'endDate'   => $end * 1000
        ]);
    }

    /**
     * 根据订单ID查询订单信息
     * @param $orderId
     * @return bool|mixed|string
     */
    public function byOrderId($orderId)
    {
        $res = $this->send("kaola.zhuanke.api.queryOrderInfo", [
            'type'    => 2,
            'orderId' => $orderId
        ]);
        return $res ? current($res) : false;
    }
}