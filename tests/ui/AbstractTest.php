<?php
namespace App\Tests\ui;

require_once("../../vendor/autoload.php");

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class AbstractTest
{
    private const selenium_server_url = "http://selenium:4444/wd/hub";

    public function test(): void
    {
        $driver = RemoteWebDriver::create(self::selenium_server_url, DesiredCapabilities::chrome());
        $driver->get("http://172.17.0.1");
        $driver->findElement(WebDriverBy::xpath("//input[@name = 'fullname']"))->sendKeys("2222");
        echo $driver->findElement(WebDriverBy::xpath("//input[@name = 'fullname']"))->getText();
        $driver->quit();
    }
    
}

$test = new AbstractTest();
$test->test();