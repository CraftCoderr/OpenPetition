<?php

namespace App\Tests\ui;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    private const selenium_server_url = "http://selenium:4444/wd/hub";

    private const base_url = "http://caddy/kosmos1";

    protected function getRemoteDriver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(self::selenium_server_url, DesiredCapabilities::chrome());
    }

    protected function getBaseURL(): string
    {
        return self::base_url;
    }

}