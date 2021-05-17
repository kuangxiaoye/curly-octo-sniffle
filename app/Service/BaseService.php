<?php


namespace app\Service;


use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;

class BaseService
{
    /**
     * 获取Dd商品列表
     * @param     $gameCode
     * @param     $goodsType
     * @param     $page
     * @param int $minPrice
     * @param int $maxPrice
     */

    public function getGoodsIdList($gameCode, $goodsType, $page)
    {
        $html = $this->getGoodsIdListPage($gameCode, $goodsType, $page, $minPrice = 100, $maxPrice = 200);
        $goodsInfoList = [];
        $subcrawler = new Crawler($html);
        $subcrawler->filter('.goods-list-item')->each(function ($node) use (&$goodsInfoList) {
            $title = trim($node->filter('.game-account-flag')->text());
            $game = trim($node->filter('.game-qufu-value a')->eq(0)->text());
            $area = trim($node->filter('.game-qufu-value a')->eq(2)->text());
            $goodsUrl = $node->filter('.h1-box h2 a')->attr('href');
            $goodsId = substr(substr($goodsUrl, 10), 0, 20); //做字符串截取
            $stock = $node->filter('.kucun span')->text();
            $priceStr = $node->filter('.goods-price span')->text();
            $price = substr(substr($priceStr, 3), 0, 3);
            $ratioStr = $node->filter('.p-r66 p')->eq(0)->text();
            $ratio = preg_replace('/([\x80-\xff]*)/i', '', substr($ratioStr, 5));
            $goodsInfoList[] = [
                'goodsid'  => $goodsId,
                'game'     => $game,
                'ratio'    => $ratio,
                'stock'    => $stock,
                'title'    => $title,
                'price'    => $price,
                'area'     => $area,
                'createon' => dateNow(),
            ];
        });
        var_dump($goodsInfoList);
        die();
        return $goodsInfoList;
    }

    private function getGoodsIdListPage($gameCode, $goodsType, $page, $minPrice = 100, $maxPrice = 200)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://www.dd373.com/s-$gameCode-0-0-0-0-0-$goodsType-0-2-0-0-0-$page-0-5-0.html?MinPrice=$minPrice&MaxPrice=$maxPrice",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => array(),
        ));

        $html = curl_exec($curl);

        curl_close($curl);

        return $html;
    }
}