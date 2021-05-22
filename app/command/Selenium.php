<?php
declare (strict_types = 1);

namespace app\command;

use app\Service\Cm\SxService;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 爬取神仙代售账号
 * Class Sxds
 * @package app\command
 */
class Selenium extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('selenium')
            ->setDescription('the selenium command');
    }

    protected function execute(Input $input, Output $output)
    {
        (new \app\Service\Selenium\Selenium())->doSelenium();
    }
}
