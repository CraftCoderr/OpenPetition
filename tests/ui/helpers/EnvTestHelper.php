<?php

namespace App\Tests\ui\helpers;

use Dotenv\Dotenv;
use OutOfBoundsException;

class EnvTestHelper
{
    private Dotenv $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__, '.env.test');
        $this->dotenv->load();
    }

    public function getValue(string $key): string
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        throw new OutOfBoundsException("Element with key [" . $key . "] doesn't exist");
    }
}