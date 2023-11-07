<?php

declare(strict_types=1);

namespace Endroid\SoccerCalendarBundle\Controller;

use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class TeamListController
{
    public function __construct(
        /** @var array<string> */
        private readonly array $competitionNames,
        private readonly Environment $templating,
        private readonly CompetitionLoaderInterface $competitionLoader,
        private readonly TeamLoaderInterface $teamLoader
    ) {
    }

    public function __invoke(): Response
    {
        $competitions = [];
        foreach ($this->competitionNames as $name) {
            $competition = $this->competitionLoader->loadByName($name);
            $this->teamLoader->loadByCompetition($competition);
            $competitions[] = $competition;
        }

        return new Response($this->templating->render('@EndroidSoccerCalendar/team/list.html.twig', [
            'competitions' => $competitions,
        ]));
    }
}
