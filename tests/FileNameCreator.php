<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\FileNameCreator;

final class FileNameCreator extends TestCase
{

    private FileNameCreator $instance;

    public function setUp(): void
    {
        $this->instance = new FileNameCreator();
    }


    /**
     * @covers \App\FileNameCreator::convertDomain
     *
     */
    public function testConvertDomain(): void
    {

        $url1 = 'https://example.com';
        $url2 = 'https://app.example.com';
        $url3 = 'https://www.app.example.com';
        $url4 = 'https://www.app.example.mobile';
        $url5 = 'https://example-mobile.com';
        $url6 = 'https://app.example-mobile.com';

        $this->assertEquals('example-com', $this->instance->convertDomain($url1));
        $this->assertEquals('app-example-com', $this->instance->convertDomain($url2));
        $this->assertEquals('www-app-example-com', $this->instance->convertDomain($url3));
        $this->assertEquals('www-app-example-mobile', $this->instance->convertDomain($url4));
        $this->assertEquals('example-mobile-com', $this->instance->convertDomain($url5));
        $this->assertEquals('app-example-mobile-com', $this->instance->convertDomain($url6));

    }


    /**
     * @covers \App\FileNameCreator::convertPath
     *
     */
    public function testConvertPath(): void
    {

        // 1. вернуть path
        $url1 = 'https://example.com/page';
        $url2 = 'https://app.example.com/page-test';
        $url3 = 'https://www.app.example.com/page2-test/index/';
        $url4 = 'https://www.app.example.mobile/index.html';
        $url5 = 'https://example-mobile.com/post?id=123';
        $url6 = 'https://app.example-mobile.com/categories/mobile/actions';

        $url7 = 'https://app.example-mobile.com/categories/mobile.php';
        $url8 = 'https://app.example-mobile.com/categories/mobile.html';
        $url9 = 'https://app.example-mobile.com/categories/mobile.cgi';


        $this->assertEquals('-page', $this->instance->convertPath($url1));
        $this->assertEquals('-page-test', $this->instance->convertPath($url2));
        $this->assertEquals('-page2-test-index', $this->instance->convertPath($url3));
        $this->assertEquals('-index', $this->instance->convertPath($url4));
        $this->assertEquals('-post', $this->instance->convertPath($url5));
        $this->assertEquals('-categories-mobile-actions', $this->instance->convertPath($url6));

        $this->assertEquals('-categories-mobile', $this->instance->convertPath($url7));
        $this->assertEquals('-categories-mobile', $this->instance->convertPath($url8));
        $this->assertEquals('-categories-mobile', $this->instance->convertPath($url9));

    }

    /**
     * @covers \App\FileNameCreator::create
     *
     */
    public function testCreate(): void
    {

        $url1 = 'https://ru.hexlet.io/courses/about-me';
        $url2 = 'https://app.example.com/page-test';
        $url3 = 'https://www.app.example.com/page2-test/index/';
        $url4 = 'https://www.app.example.mobile/index.html';
        $url5 = 'https://example-mobile.com/post?id=123';
        $url6 = 'https://app.example-mobile.com/categories/mobile/actions';
        $url7 = 'https://app.example-mobile.com/categories/mobile.php';
        $url8 = 'https://app.example-mobile.com/categories/mobile.html';
        $url9 = 'https://app.example-mobile.com/categories/mobile.cgi';
        $url10 = 'https://example.com';

        $this->assertEquals(
            'ru-hexlet-io-courses-about-me.html',
            $this->instance->create($url1));
        $this->assertEquals(
            'app-example-com-page-test.html',
            $this->instance->create($url2));
        $this->assertEquals(
            'www-app-example-com-page2-test-index.html',
            $this->instance->create($url3));
        $this->assertEquals(
            'www-app-example-mobile-index.html',
            $this->instance->create($url4));
        $this->assertEquals(
            'example-mobile-com-post.html',
            $this->instance->create($url5));
        $this->assertEquals(
            'app-example-mobile-com-categories-mobile-actions.html',
            $this->instance->create($url6));
        $this->assertEquals('app-example-mobile-com-categories-mobile.html',
            $this->instance->create($url7));
        $this->assertEquals('app-example-mobile-com-categories-mobile.html',
            $this->instance->create($url8));
        $this->assertEquals('app-example-mobile-com-categories-mobile.html',
            $this->instance->create($url9));
        $this->assertEquals('example-com.html',
            $this->instance->create($url10));

        $this->assertFalse($this->instance->create());
        $this->assertFalse($this->instance->create(''));

    }


}