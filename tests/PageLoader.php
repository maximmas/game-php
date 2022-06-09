<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/src/pageLoader.php';


final class PageLoader extends TestCase
{


    /**
     * @covers ::pageLoader()
     *
     */
    public function testPageLoader(): void
    {

        $correctPath = 'pages';
        $wrongPath = 'pages123';

        $correctUrl = 'https://ru.hexlet.io/courses';
        $wrongUrl = 'https://ru.123hexlet.io/courses';

        $correctHttpClient = Client::class;
        $wrongHttpClient = Client2::class;

        $this->assertTrue(pageLoader($correctUrl, $correctPath, $correctHttpClient));

        $this->assertFalse(pageLoader($wrongUrl, $correctPath, $correctHttpClient));
        $this->assertFalse(pageLoader($correctUrl, $wrongPath, $correctHttpClient));
        $this->assertFalse(pageLoader($correctUrl, $correctPath, $wrongHttpClient));
        $this->assertFalse(pageLoader($wrongUrl, $wrongPath, $wrongHttpClient));

    }

}