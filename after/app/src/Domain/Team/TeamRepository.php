<?php

namespace App\Domain\Team;

interface TeamRepository
{
    public function findById(int $id): Team;
}
