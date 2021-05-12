<?php
namespace app\controller;

use app\BaseController;

class Tlbb extends BaseController
{
    /**
     * 神仙代售抓取任务
     */
    public function index(){
        echo "运行成功";
        $tlbbService = New \app\Service\Tlbb\BasisService();
        while (true) {
            sleep(rand(5,10));
            $tlbbService->doCrawSxds();
        }
    }
}
