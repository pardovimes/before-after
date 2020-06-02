<?php

namespace App\Infrastructure\Team\Persistence\InMemory;

use App\Domain\Player\Player;
use App\Domain\Team\Team;
use App\Domain\Team\TeamRepository;

class FakeTeamRepository implements TeamRepository
{
    const TEAMS = [
        1 => [
            'name' => 'FCB',
            'competition' => 'Primera Division 2018',
            'players' => [
                [
                    'name' => 'carlos',
                    'position' => 'goalkeeper',
                    'number' => 13,
                    'birthDate' => '1988-12-13',
                    'nationality' => 'spanish',
                    'contractUntil' => '2025-12-13',
                ],
                [
                    'name' => 'antonio',
                    'position' => 'defense',
                    'number' => 5,
                    'birthDate' => '1978-12-13',
                    'nationality' => 'spanish',
                    'contractUntil' => '2023-12-13',
                ],
            ]
        ],
        2 => [
            'name' => 'Empty FCB',
            'competition' => 'Primera Division 2018',
            'players' => [],
        ],
        3 => [
            'name' => 'Empty England FC',
            'competition' => 'Premier 2018',
            'players' => [],
        ],
    ];

    public function findById(int $id): Team
    {
        $rawInfo = self::TEAMS[$id];
        $team = new Team($id, $rawInfo['name'], $rawInfo['competition']);
        foreach ($rawInfo['players'] as $playerRawInfo) {
            $player = new Player(
                $playerRawInfo['name'],
                $playerRawInfo['position'],
                $playerRawInfo['number'],
                new \DateTime($playerRawInfo['birthDate']),
                $playerRawInfo['nationality'],
                new \DateTime($playerRawInfo['contractUntil'])
            );
            $team->addPlayer($player);
        }
        return $team;
    }
}
