<?php

namespace Test\Unit\Application\Team;

use App\Domain\Team\HasNoPlayersException;
use App\Domain\Team\NotValidCompetitionException;
use PHPUnit\Framework\TestCase;
use App\Application\Team\GetTeamYoungestPlayerUseCase;
use App\Domain\Player\PlayerTransformer;
use App\Infrastructure\Team\Persistence\InMemory\FakeTeamRepository;

class GetTeamYoungestPlayerUseCaseTest extends TestCase
{
    protected $usecase;

    protected function setUp(): void
    {
        $this->usecase = new GetTeamYoungestPlayerUseCase(
            new FakeTeamRepository(),
            new PlayerTransformer()
        );
    }

    public function testValidTeamWithValidYoungestPlayer()
    {
        $youngestPlayer = $this->usecase->execute(1);
        $expectedData = [
            "name" => "CARLOS",
            "position" => "goalkeeper",
            "jerseyNumber" => 13,
            "dateOfBirth" => "1988-12-13",
            "nationality" => "spanish",
            "contractUntil" => "2025-12-13"
        ];
        $this->assertEquals($youngestPlayer, $expectedData);
    }

    public function testValidTeamWithoutPlayers()
    {
        $this->expectException(HasNoPlayersException::class);
        $this->usecase->execute(2);
    }

    public function testTeamFromOtherCompetition()
    {
        $this->expectException(NotValidCompetitionException::class);
        $this->usecase->execute(3);
    }
}
