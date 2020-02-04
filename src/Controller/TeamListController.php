<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerCalendarBundle\Controller;

use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class TeamListController
{
    private $competitionNames;
    private $templating;
    private $competitionLoader;
    private $teamLoader;

    public function __construct(array $competitionNames, Environment $templating, CompetitionLoaderInterface $competitionLoader, TeamLoaderInterface $teamLoader)
    {
        $this->competitionNames = $competitionNames;
        $this->templating = $templating;
        $this->competitionLoader = $competitionLoader;
        $this->teamLoader = $teamLoader;
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
