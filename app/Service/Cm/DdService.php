<?php


namespace app\Service\Cm;


use app\model\DdGoodsList;
use app\Service\BaseService;


class DdService extends BaseService
{
    /**
     * 落地天龙DD价格数据 每分钟同步一次
     * @throws \Exception
     */
    public function doSyncTl()
    {
        $gameCode = 'u7udm8';
        $goodsType = '1xv82k';
        $game = '天龙八部怀旧';
        var_dump(123);
        die(123);
        $this->ddGoodsSync($gameCode, $goodsType, $game);
    }

    /**
     * 根据游戏与类型同步数据到数据库
     * @param $gameCode
     * @param $goodsType
     * @param $game
     * @throws \Exception
     */
    public function ddGoodsSync($gameCode, $goodsType, $game)
    {

        $page = 1;
        $goodInfoList = [];
        $goodsListAll = [];
        $goodsListByArea = [];
        $goodsListNeed = [];
        $baseService = new BaseService();
        $goodsModel = new DdGoodsList();
        do {
            try {
                $goodInfoList = $baseService->getGoodsIdList($gameCode, $goodsType, $page);
                var_dump($goodInfoList);
                die();
            } catch (\Exception $exception) {
            }
            $page++;
            $goodsListAll = array_merge($goodsListAll, $goodInfoList);
        } while (!empty($goodInfoList));

        foreach ($goodsListAll as $item) {
            $goodsListByArea[$item['area']][] = $item;
        }

        foreach ($goodsListByArea as $area => $infoList) {
            if (count($infoList) <= 1) {
                continue;
            }
            array_multisort(array_column($infoList, 'ratio'), SORT_DESC, $infoList);
            $infoList[0]['area'] = $area;
            $infoList[0]['game'] = $game;
            $goodsListNeed[] = $infoList[0];
        }

        $goodsModel->replace()->saveAll($goodsListNeed);
    }
}