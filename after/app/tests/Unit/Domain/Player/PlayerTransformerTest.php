<?php

namespace Test\Unit\Domain\Player;

use App\Domain\Player\PlayerTransformer;
use PHPUnit\Framework\TestCase;
use App\Domain\Player\Player;

class PlayerTransformerTest extends TestCase
{
    public function testTransformNull()
    {
        $transformer = new PlayerTransformer();
        $this->expectException(\ArgumentCountError::class);
        $transformer->toArray();
    }

    public function testTransformPlayerToArray()
    {
        $player = new Player('carlos', 'goalkeeper', 13, new \DateTime('1988-12-13'), 'spanish', new \DateTime('+1 day'));
        $transformer = new PlayerTransformer();

        $arrayPlayerInfo = $transformer->toArray($player);
        $expectedArrayPlayerInfo = [
            "name" => 'CARLOS',
            "position" => 'goalkeeper',
            "jerseyNumber" => 13,
            "dateOfBirth" => '1988-12-13',
            "nationality" => 'spanish',
            "contractUntil" => (new \DateTime('+1 day'))->format('Y-m-d'),
        ];

        $this->assertEquals($expectedArrayPlayerInfo, $arrayPlayerInfo);
    }
}
