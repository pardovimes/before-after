<?php

namespace App\Domain\Player;

class PlayerTransformer
{
    public function toArray(Player $player)
    {
        return [
            "name" => strtoupper($player->getName()),
            "position"=> $player->getPosition(),
            "jerseyNumber"=> $player->getNumber(),
            "dateOfBirth"=> $player->getBirthDate()->format('Y-m-d'),
            "nationality"=> $player->getNationality(),
            "contractUntil"=> $player->getContractUntil()->format('Y-m-d'),
        ];
    }
}
