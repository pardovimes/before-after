<?php

namespace App\Domain\Player;

class Player
{
    private $name;
    private $position;
    private $number;
    private $birthDate;
    private $nationality;
    private $contractUntil;

    public function __construct(string $name, string $position, int $number, \DateTime $birthDate, string $nationality, \DateTime $contractUntil)
    {
        $now = new \DateTime();
        if ($birthDate > $now) {
            throw new \InvalidArgumentException('This player didn\'t born yet');
        }
        if ($contractUntil < $now) {
            throw new \InvalidArgumentException('Contract invalid');
        }
        if ($number < 1) {
            throw new \InvalidArgumentException('Number of player invalid');
        }
        $this->name = $name;
        $this->position = $position;
        $this->number = $number;
        $this->birthDate = $birthDate;
        $this->nationality = $nationality;
        $this->contractUntil = $contractUntil;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getNationality(): string
    {
        return $this->nationality;
    }

    public function getContractUntil(): \DateTime
    {
        return $this->contractUntil;
    }
}
