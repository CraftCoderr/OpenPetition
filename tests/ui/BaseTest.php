<?php

namespace App\Tests\ui;

use Doctrine\ORM\EntityManager;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseTest extends KernelTestCase
{
    private const SELENIUM_SERVER_URL = "http://selenium:4444/wd/hub";
    private const BASE_URL = "http://caddy/autotest";
    private static EntityManager $entityManager;

    public static function setUpBeforeClass(): void
    {
        self::$entityManager = self::bootKernel()->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function getRemoteDriver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(self::SELENIUM_SERVER_URL, DesiredCapabilities::chrome());
    }

    protected function getBaseURL(): string
    {
        return self::BASE_URL;
    }

    protected static function getEntityManager(): EntityManager
    {
        return self::$entityManager;
    }
}