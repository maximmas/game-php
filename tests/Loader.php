<?php

declare(strict_types=1);

use GuzzleHttp\Exception\GuzzleException;
use App\Loader;
use PHPUnit\Framework\TestCase;

final class Loader extends TestCase
{

    private Loader $instance;


    public function setUp(): void
    {
        $httpClient = new GuzzleHttp\Client();
        $this->instance = new Loader($httpClient);
    }


    /**
     * @covers \App\Loader::getPageContent
     *
     */
    public function testGetPageContent(): void
    {

        $correctUrl = 'https://example.com';
        $nonExistUrl = 'https://exampllee.com';

        $correctTestString = '/This domain is for use in illustrative examples/i';
        $wrongTestString = '/Lorem ipsum/i';

        $this->assertMatchesRegularExpression(
            $correctTestString,
            $this->instance->getPageContent($correctUrl)
        );

        $this->assertDoesNotMatchRegularExpression(
            $wrongTestString,
            $this->instance->getPageContent($correctUrl)
        );

        $this->expectException(GuzzleException::class);
        $this->instance->getPageContent($nonExistUrl);

    }

}