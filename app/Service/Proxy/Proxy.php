<?php

namespace app\Service\Proxy;

use think\Cache;
use think\cache\driver\File;

class Proxy
{
    public function getProxyCache()
    {
        $ip = Cache::get("proxy");
        if (!empty($ip)) {
            return $ip;
        } else {
            $ip = $this->getKDLip();
            Cache::set("proxy", $ip, 30);
            return $ip;
        }
    }

    public function ipHandle($ip){
        $ipInfo['ip'] = explode(":",$ip)[0];
        $ipInfo['port'] = explode(":",$ip)[1];

        return $ipInfo;
    }

    public function getKDLip($orderId = '932149130520831')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => 'http://dps.kdlapi.com/api/getdps/?orderid=' . $orderId . '&num=1&pt=1&format=json&sep=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        return $response['data']['proxy_list'][0];
    }

}