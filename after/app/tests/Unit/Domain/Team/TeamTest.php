<?php

namespace Test\Unit\Team;

use App\Domain\Player\Player;
use App\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testCreateValidTeam()
    {
        $team = new Team(1, 'Canet FC', 'Primera division 2018');
        $this->assertInstanceOf(Team::class, $team);
    }

    public function testAddPlayer()
    {
        $mockedPlayer = $this->createMock(Player::class);
        $team = new Team(1, 'Canet FC', 'Primera division 2018');
        $team->addPlayer($mockedPlayer);
        $this->assertEquals(1, $team->numPlayers());
    }

    public function testGetYoungestPlayerOfEmptyTeam()
    {
        $team = new Team(1, 'Canet FC', 'Primera division 2018');
        $this->assertEquals(null, $team->getYoungestPlayer());
    }

    public function testGetYoungestPlayerWithPlayersSameBirthDate()
    {
        $birthDateForPlayers = new \DateTime('1988-12-13');

        $mockedPlayerOne = $this->createMock(Player::class);
        $mockedPlayerOne->method('getBirthDate')->willReturn($birthDateForPlayers);
        $mockedPlayerOne->method('getNumber')->willReturn(5);

        $mockedPlayerTwo = $this->createMock(Player::class);
        $mockedPlayerTwo->method('getBirthDate')->willReturn($birthDateForPlayers);
        $mockedPlayerTwo->method('getNumber')->willReturn(10);

        $team = new Team(1, 'Canet FC', 'Primera division 2018');
        $team->addPlayer($mockedPlayerOne);
        $team->addPlayer($mockedPlayerTwo);

        $youngestPlayer = $team->getYoungestPlayer();
        $this->assertEquals($mockedPlayerOne, $youngestPlayer);
        $this->assertEquals(5, $youngestPlayer->getNumber());
    }

    public function testGetYoungestPlayerWithPlayersDifferentBirthDate()
    {
        $mockedPlayerOne = $this->createMock(Player::class);
        $mockedPlayerOne->method('getBirthDate')->willReturn(new \DateTime('1978-12-13'));
        $mockedPlayerOne->method('getNumber')->willReturn(5);

        $mockedPlayerTwo = $this->createMock(Player::class);
        $mockedPlayerTwo->method('getBirthDate')->willReturn(new \DateTime('1988-12-13'));
        $mockedPlayerTwo->method('getNumber')->willReturn(13);

        $team = new Team(1, 'Canet FC', 'Primera division 2018');
        $team->addPlayer($mockedPlayerOne);
        $team->addPlayer($mockedPlayerTwo);

        $youngestPlayer = $team->getYoungestPlayer();
        $this->assertEquals($mockedPlayerTwo, $youngestPlayer);
        $this->assertEquals(13, $youngestPlayer->getNumber());
    }

    /**
     * @dataProvider competitionNamesProvider
     * @param $teamCompetition
     * @param $isFromThatCompetitionName
     * @param $expectedResult
     */
    public function testIfTeamIsFromCompetition($teamCompetition, $isFromThatCompetitionName, $expectedResult)
    {
        $team = new Team(1, 'Canet FC', $teamCompetition);
        $this->assertEquals($expectedResult, $team->isFromThisCompetition($isFromThatCompetitionName));
    }

    public function competitionNamesProvider()
    {
        return [
            ['Primera division 2018', 'Fake Division 2199', false],
            ['Primera division 2018', 'Primera division 2018', true],
            ['Primera division 2018', 'Primera division 2019', false],
        ];
    }
}
