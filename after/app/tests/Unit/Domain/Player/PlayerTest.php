<?php

namespace Test\Unit\Domain\Player;

use PHPUnit\Framework\TestCase;
use App\Domain\Player\Player;

class PlayerTest extends TestCase
{
    public function testCreateValidPlayer()
    {
        $birthDate = new \DateTime('1988-12-13');
        $contractUntil = new \DateTime('+1 day');
        $player = new Player('carlos', 'goalkeeper', 13, $birthDate, 'spanish', $contractUntil);
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testCreateNonBornPlayer()
    {
        $tomorrowAsBirthDate = new \DateTime('+1 day');
        $contractUntil = new \DateTime('2025-12-13');
        $this->expectException(\InvalidArgumentException::class);
        new Player('carlos', 'goalkeeper', 13, $tomorrowAsBirthDate, 'spanish', $contractUntil);
    }

    public function testCreatePlayerWithPastContract()
    {
        $birthDate = new \DateTime('1988-12-13');
        $contractUntilYesterday = new \DateTime('-1 day');
        $this->expectException(\InvalidArgumentException::class);
        new Player('carlos', 'goalkeeper', 13, $birthDate, 'spanish', $contractUntilYesterday);
    }

    public function testCreatePlayerWithNegativeNumber()
    {
        $birthDate = new \DateTime('1988-12-13');
        $contractUntil = new \DateTime('+1 day');
        $this->expectException(\InvalidArgumentException::class);
        new Player('carlos', 'goalkeeper', -13, $birthDate, 'spanish', $contractUntil);
    }
}
