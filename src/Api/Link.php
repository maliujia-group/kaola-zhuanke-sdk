<?php

namespace KlzkSdk\Api;

use KlZkSDK\Tools\GateWay;

class Link extends GateWay
{
    const CPS_URL = 'https://cps.kaola.com/cps/zhuankeLogin?unionId=&tc1=&tc2=&showWapBanner=0&targetUrl=';

    public function cps($targetUrl = '', $tc1 = '', $tc2 = '', $unionId = null)
    {
        return self::CPS_URL . http_build_query([
                'unionId'   => $unionId ?: $this->unionId,
                'tc1'       => $tc1,
                'tc2'       => $tc2,
                'targetUrl' => $targetUrl
            ]);
    }
}