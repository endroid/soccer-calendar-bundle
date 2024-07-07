<?php

declare(strict_types=1);

namespace Endroid\SoccerCalendarBundle\Controller;

use Endroid\Calendar\Writer\IcalWriter;
use Endroid\SoccerCalendar\Factory\CalendarFactory;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Symfony\Component\HttpFoundation\Response;

final class TeamCalendarController
{
    public function __construct(
        private readonly TeamLoaderInterface $teamLoader,
        private readonly CalendarFactory $calendarFactory,
        private readonly IcalWriter $calendarWriter
    ) {
    }

    public function __invoke(string $identifier): Response
    {
        $team = $this->teamLoader->load($identifier);
        $calendar = $this->calendarFactory->createTeamCalendar($team);

        return new Response($this->calendarWriter->writeToString($calendar, new \DateTimeImmutable(), new \DateTimeImmutable('+1 year')), Response::HTTP_OK, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="calendar-'.time().'.ics"',
        ]);
    }
}
