<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerCalendarBundle\Controller;

use Endroid\SoccerData\Entity\Competition;
use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class TeamListController
{
    public function __invoke(array $competitionNames, Environment $twig, CompetitionLoaderInterface $competitionLoader): Response
    {
        $competitions = [];

        foreach ($competitionNames as $name) {
            $competition = $competitionLoader->loadByName($name);


            $teams = $this->getTeams($url);

            $competition = [
                'name' => $name,
                'teams' => $teams,
            ];

            $competitions[] = $competition;
        }

        return new Response($twig->render('@EndroidSoccerCalendar/team/list.html.twig', [
            'competitions' => $competitions
        ]));
    }

    private function loadCompetition(string $url): Competition
    {
        $competition = new Competition($url);

    }
}
