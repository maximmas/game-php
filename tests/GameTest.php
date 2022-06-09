<?php

declare(strict_types=1);

use App\Game;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{

    private Game $instance;


    public function setUp(): void
    {
      $this->instance = new Game();
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