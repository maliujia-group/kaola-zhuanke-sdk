<?php

namespace KlZkSdk\Api;

use KlZkSdk\Tools\GateWay;

class Goods extends GateWay
{
    /**
     * 获取推荐商品列表  [返回的是商品ID列表]
     * @param $categoryId // 类名ID
     * @param int $pageIndex
     * @return bool|string
     * @throws \Exception
     * @link https://www.kdocs.cn/l/shwrmIbwm?f=101
     */
    public function queryRecommendGoodsList($categoryId, $pageIndex = 1)
    {
        return $this->send("kaola.zhuanke.api.queryRecommendGoodsList", [
            'categoryId' => $categoryId,
            'sortType'   => 1,  // 按佣金比例倒序
            'pageIndex'  => $pageIndex
        ]);
    }

    /**
     * 批量获取商品信息
     * @param $goodsIds
     * @param null $trackingCode1
     * @param null $trackingCode2
     */
    public function queryGoodsInfo($goodsIds, $trackingCode1 = null, $trackingCode2 = null)
    {
        if (is_array($goodsIds) && count($goodsIds) > 20) {
            return $this->setError("查询商品信息单次最多20条，请控制单次查询数量");
        }
        $goodsStr = is_array($goodsIds) ? implode(',', $goodsIds) : $goodsIds;
        $params   = [
            'goodsIds' => $goodsIds,
            'type'     => 0
        ];
        $trackingCode1 && $params['trackingCode1'] = $trackingCode1;
        $trackingCode2 && $params['trackingCode2'] = $trackingCode2;
        return $this->send("kaola.zhuanke.api.queryGoodsInfo", $params);
    }

    /**
     * 解析url中的商品信息
     * @param $goodsUrl
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function queryUrlGoodsInfo($goodsUrl)
    {
        $res = $this->send("kaola.zhuanke.api.queryGoodsInfo", [
            'type'     => 1,
            'goodsUrl' => $goodsUrl
        ]);
        if (is_array($res) && empty($res)) {
            return $this->setError("商品不存在");
        }
        return $res ? current($res) : false;
    }
}