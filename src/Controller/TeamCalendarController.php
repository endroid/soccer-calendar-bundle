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
use Endroid\SoccerData\Loader\MatchLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;

final class TeamCalendarController
{
    public function __invoke(string $name, TeamLoaderInterface $teamLoader, MatchLoaderInterface $matchLoader, CalendarFactory $calendarFactory, IcalWriter $writer): Response
    {
        $team = $teamLoader->loadByName($name);
        $matchLoader->loadByTeam($team);

        $calendar = $calendarFactory->createTeamCalendar($team);

        return new Response($writer->writeToString($calendar));
    }
}
