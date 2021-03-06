<?php

namespace KlZkSdk\Api;

use KlZkSdk\Tools\GateWay;

class Link extends GateWay
{
    const CPS_URL = 'https://cps.kaola.com/cps/zhuankeLogin?showWapBanner=0';

    public function cps($targetUrl = '', $tc1 = '', $tc2 = '', $unionId = null)
    {
        return self::CPS_URL . '&' . http_build_query([
                'unionId'   => $unionId ?: $this->unionId,
                'tc1'       => $tc1,
                'tc2'       => $tc2,
                'targetUrl' => urlencode($targetUrl)
            ]);
    }
}