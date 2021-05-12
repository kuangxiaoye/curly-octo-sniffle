<?php
declare (strict_types = 1);

namespace app\command;

use app\controller\Tlbb;
use app\Service\Tlbb\BasisService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Sxds extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('sxds')
            ->setDescription('the sxds command');
    }

    protected function execute(Input $input, Output $output)
    {
        (new BasisService())->sxds();
    }
}
