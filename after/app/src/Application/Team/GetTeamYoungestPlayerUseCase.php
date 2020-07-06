<?php

namespace App\Application\Team;

use App\Domain\Player\PlayerTransformer;
use App\Domain\Team\HasNoPlayersException;
use App\Domain\Team\NonExistingTeam;
use App\Domain\Team\NotValidCompetitionException;
use App\Domain\Team\TeamRepository;

class GetTeamYoungestPlayerUseCase
{
    const AVAILABLE_COMPETITION = 'Primera Division 2018';
    private $teams;
    private $transformer;

    public function __construct(TeamRepository $teams, PlayerTransformer $transformer)
    {
        $this->teams = $teams;
        $this->transformer = $transformer;
    }

    /**
     * @param int $teamID
     * @return array
     * @throws HasNoPlayersException
     * @throws NotValidCompetitionException
     * @throws NonExistingTeam
     */
    public function execute(int $teamID)
    {
        $team = $this->teams->findById($teamID);
        if (!$team->isFromThisCompetition(self::AVAILABLE_COMPETITION)) {
            throw new NotValidCompetitionException('This team is not from '.self::AVAILABLE_COMPETITION);
        }
        $youngestPlayer = $team->getYoungestPlayer();
        if (!$youngestPlayer) {
            throw new HasNoPlayersException('This team has no players');
        }

        return $this->transformer->toArray($youngestPlayer);
    }
}
