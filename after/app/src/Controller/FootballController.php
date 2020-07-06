<?php

namespace App\Controller;

use App\Application\Team\GetTeamYoungestPlayerUseCase;
use App\Domain\Team\HasNoPlayersException;
use App\Domain\Team\NonExistingTeam;
use App\Domain\Team\NotValidCompetitionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FootballController
{
    private $usecase;

    public function __construct(GetTeamYoungestPlayerUseCase $usecase)
    {
        $this->usecase = $usecase;
    }

    /**
     * @Route("/team/{teamID}/youngest-player/")
     */
    public function youngestPlayerTeam($teamID)
    {
        try {
            $youngestPlayer = $this->usecase->execute($teamID);
            return new JsonResponse($youngestPlayer);
        } catch (NonExistingTeam $e) {
            return new JsonResponse(['message' => "This team doesn't exists"], 404);
        } catch (HasNoPlayersException $e) {
            return new JsonResponse(['message' => "This team doesn't have players"], 404);
        } catch (NotValidCompetitionException $e) {
            return new JsonResponse(['message' => "This team doesn't it's not from a valid competition"], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }
}
