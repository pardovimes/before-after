<?php

namespace App\Domain\Team;

use App\Domain\Player\Player;

class Team
{
    private $id;
    private $name;
    private $players;
    private $competition;

    public function __construct(int $id, string $name, string $competition)
    {
        $this->id = $id;
        $this->name = $name;
        $this->competition = $competition;
        $this->players = [];
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    public function getYoungestPlayer(): ?Player
    {
        $youngestPlayer = null;
        foreach ($this->players as $player) {
            if (!$youngestPlayer) {
                $youngestPlayer = $player;
                continue;
            }
            if ($player->getBirthDate() > $youngestPlayer->getBirthDate()) {
                $youngestPlayer = $player;
            }
        }
        return $youngestPlayer;
    }

    public function numPlayers(): int
    {
        return count($this->players);
    }

    public function isFromThisCompetition(string $competition): bool
    {
        return $competition === $this->competition;
    }
}
