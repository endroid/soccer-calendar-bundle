<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerCalendarBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamListControllerTest extends WebTestCase
{
    public function testGenerateController()
    {
        $client = static::createClient();
        $client->request('GET', '/soccer-calendar/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Soccer Calendars', $client->getResponse()->getContent());
    }
}
