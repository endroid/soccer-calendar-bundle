<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerCalendarBundle\Controller;

use Endroid\Calendar\Writer\IcalWriter;
use Endroid\SoccerCalendar\Factory\CalendarFactory;
use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Endroid\SoccerData\Loader\MatchLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;

final class TeamCalendarController
{
    private $competitionLoader;
    private $teamLoader;
    private $matchLoader;
    private $calendarFactory;
    private $calendarWriter;

    public function __construct(CompetitionLoaderInterface $competitionLoader, TeamLoaderInterface $teamLoader, MatchLoaderInterface $matchLoader, CalendarFactory $calendarFactory, IcalWriter $calendarWriter)
    {
        $this->competitionLoader = $competitionLoader;
        $this->teamLoader = $teamLoader;
        $this->matchLoader = $matchLoader;
        $this->calendarFactory = $calendarFactory;
        $this->calendarWriter = $calendarWriter;
    }

    public function __invoke(string $competitionName, string $teamName): Response
    {
        $competition = $this->competitionLoader->loadByName($competitionName);
        $this->teamLoader->loadByCompetition($competition);
        $team = $competition->getTeamByName($teamName);
        $this->matchLoader->loadByTeam($team);

        $calendar = $this->calendarFactory->createTeamCalendar($team);

        return new Response($this->calendarWriter->writeToString($calendar));
    }
}
