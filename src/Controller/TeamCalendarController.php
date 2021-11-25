<?php

declare(strict_types=1);

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
use Endroid\SoccerData\Loader\GameLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TeamCalendarController
{
    private $competitionLoader;
    private $teamLoader;
    private $gameLoader;
    private $calendarFactory;
    private $calendarWriter;

    public function __construct(
        CompetitionLoaderInterface $competitionLoader,
        TeamLoaderInterface $teamLoader,
        GameLoaderInterface $gameLoader,
        CalendarFactory $calendarFactory,
        IcalWriter $calendarWriter
    ) {
        $this->competitionLoader = $competitionLoader;
        $this->teamLoader = $teamLoader;
        $this->gameLoader = $gameLoader;
        $this->calendarFactory = $calendarFactory;
        $this->calendarWriter = $calendarWriter;
    }

    /**
     * @Route("/{competitionName}/team/{teamName}.ics", name="soccer_calendar_team")
     */
    public function __invoke(string $competitionName, string $teamName): Response
    {
        $competition = $this->competitionLoader->loadByName($competitionName);
        $this->teamLoader->loadByCompetition($competition);
        $team = $competition->getTeamByName($teamName);
        $this->gameLoader->loadByTeam($team);

        $calendar = $this->calendarFactory->createTeamCalendar($team);

        return new Response($this->calendarWriter->writeToString($calendar, new \DateTimeImmutable(), new \DateTimeImmutable('+1 year')), Response::HTTP_OK, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="calendar-'.time().'.ics"'
        ]);
    }
}
