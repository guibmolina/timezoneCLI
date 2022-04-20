<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Tests\Entity;

use DateTime;
use DateTimeZone;
use Guilherme\Timezone\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    /** @test */
    public function itMustReturnACountryDateFormatted()
    {
        $country = new Country(new DateTimeZone('America/Sao_Paulo'));

        $dateTimeZone = new DateTimeZone('America/Sao_Paulo');
        $dateTime = new DateTime('now', $dateTimeZone);
        $dateTimeFormatted = $dateTime->format('Y-m-d H:i');

        self::assertEquals($dateTimeFormatted, $country->dateTime());
    }
}
