<?php


namespace app\Service\Selenium;


use app\Service\Proxy\Proxy;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class Selenium
{
    public function doSelenium()
    {
//        $ip = (new Proxy())->getProxyCache();
        $host = 'http://127.0.0.1:4444';

        $desiredCapabilities = DesiredCapabilities::chrome();

// Disable accepting SSL certificates
        $desiredCapabilities->setCapability('acceptSslCerts', false);

// Run headless firefox

        $chromeOptions = new ChromeOptions();
        $chromeOptions->addArguments(['--no-sandbox', '--headless']);

        $desiredCapabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);

        $host = 'http://localhost:4444/wd/hub'; // this is the default
//        $capabilities = array(WebDriverCapabilityType::BROWSER_NAME => 'chrome',
//                              WebDriverCapabilityType::PROXY        => array('proxyType' => 'manual',
//                                                                             'httpProxy' => $ip, 'sslProxy' => $ip));

        $driver = RemoteWebDriver::create($host, $desiredCapabilities);

        echo $url = "https://hotels.ctrip.com/hotels/list?city=4";
        $driver->get($url);

        for ($i = 0; $i < 10; $i++) {
            $js = "window.scrollBy(0,100000000);";
            $driver->executeScript($js);
            try {
                $bottomElement = $driver->findElement(WebDriverBy::className('list-btn-more'));
            } catch (\Exception $exception) {
                $driver->executeScript($js);
                print_r("滚动了");
                print_r("\n");
                sleep(3);
            }
            if ($bottomElement) {
                $bottomElement->click();
                print_r("点击了");
                print_r("\n");
                sleep(3);
            }
//else{
//                $driver->executeScript($js);
//                print_r("滚动了");
//                print_r("\n");
//                sleep(3);
//            }
        }

        print_r($source = $driver->getPageSource());
        file_put_contents('ctrip' . '.html', $source);

        $driver->quit();
    }
}