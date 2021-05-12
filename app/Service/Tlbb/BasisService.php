<?php


namespace app\Service\Tlbb;



use app\Service\Notice\FangTang;
use League\Flysystem\Cached\Storage\Predis;
use think\Cache;
use think\cache\driver\Redis;

class BasisService
{
    public function sxds()
    {
        while (true) {
            sleep(rand(5, 10));
            $this->doCrawSxds();
        }
    }
    public function doCrawSxds()
    {
        $curl = curl_init();
        $address = "https://tl.sxds.com/detail/";
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tl.sxds.com/wares/?pageSize=12&gameId=74&goodsTypeId=1&jobsId=331&pages=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $resu = strstr($response,"goodsListData");
        $resu = substr($resu,strripos($resu,"goodsList:")+10);

        $goodStr = substr($resu,0,strrpos($resu,",goodsShowTileList"));

        $goodListUnSort = explode('goodsSn:"',$goodStr);
        foreach ($goodListUnSort as $item){
            $goodsId = substr($item,0,19);
            if (!strstr($goodsId,"Z")){
                continue;
            }

            $redis = (new Redis());
            $exs = $redis->get($goodsId);
            if (empty($exs)) {
                (new FangTang())->sc_send("快来看呀！", $address . $goodsId);
                $redis->set($goodsId, $goodsId);
            }
        }
    }
}