<?php

declare(strict_types=1);

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
    public function __construct(
        private readonly CompetitionLoaderInterface $competitionLoader,
        private readonly TeamLoaderInterface $teamLoader,
        private readonly GameLoaderInterface $gameLoader,
        private readonly CalendarFactory $calendarFactory,
        private readonly IcalWriter $calendarWriter
    ) {
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
            'Content-Disposition' => 'attachment; filename="calendar-'.time().'.ics"',
        ]);
    }
}
