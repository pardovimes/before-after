<?php

namespace App\Domain\Team;

interface TeamRepository
{
    /**
     * @param int $id
     * @return Team
     * @throws NonExistingTeam
     */
    public function findById(int $id): Team;
}
