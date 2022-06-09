<?php

declare(strict_types=1);

use App\Round;
use PHPUnit\Framework\TestCase;

final class RoundTest extends TestCase
{

    private Round $instance;


    public function setUp(): void
    {
      $this->instance = new Round();
    }

    /**
     * @covers \App\Game::createSoldiers
     *
     */
    public function testCreateSoldiers(): void
    {

        $this->assertCount(15, $this->instance->createSoldiers());

    }

}