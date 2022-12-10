<?php

declare(strict_types=1);

namespace Endroid\SoccerCalendarBundle\Controller;

use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class TeamListController
{
    public function __construct(
        /** @var array<string> */
        private array $competitionNames,
        private Environment $templating,
        private CompetitionLoaderInterface $competitionLoader,
        private TeamLoaderInterface $teamLoader
    ) {
    }

    /**
     * @Route("/", name="soccer_calendar_list")
     */
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
