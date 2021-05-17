<?php
declare (strict_types = 1);

namespace app\command;

use app\Service\Cm\DdService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

/**
 * 维护DD373商品信息
 * Class Dd
 * @package app\command
 */
class Dd extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('ddtlbb')
            ->setDescription('the dd command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        (new DdService())->doSyncTl();
    }
}
