<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Tests\UseCases;

use Guilherme\Timezone\Entity\Country;
use Guilherme\Timezone\Repository\CountryTimeZone;
use Guilherme\Timezone\UseCases\TimezoneBetweenCountries\TimezoneBetweenCountries;
use Guilherme\Timezone\ValueObject\Code;
use PHPUnit\Framework\TestCase;

class TimezoneBetweenCountriesTest extends TestCase
{
    /** @test */
    public function itShouldCompareTimezoneBetweenTwoCountries()
    {
        $repository = $this->getMockBuilder(CountryTimeZone::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['countryByCode'])
            ->getMock();

        $code = $this->getMockBuilder(Code::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__toString'])
            ->getMock();

        $code->method('__toString')
            ->willReturn('BRA');

        $code2 = $this->getMockBuilder(Code::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__toString'])
            ->getMock();

        $code2->method('__toString')
            ->willReturn('FRA');

        $country = $this->getMockBuilder(Country::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['dateTime'])
            ->getMock();

        $country->expects($this->once())
            ->method('dateTime')
            ->willReturn('2022-04-20 08:01');

        $country2 = $this->getMockBuilder(Country::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['dateTime'])
            ->getMock();

        $country2->expects($this->once())
            ->method('dateTime')
            ->willReturn('2022-04-20 13:01');

        $repository->expects($this->exactly(2))
            ->method('countryByCode')
            ->withConsecutive([$code], [$code2])
            ->willReturnOnConsecutiveCalls($country, $country2);

        $timezoneBetweenCountries = new TimezoneBetweenCountries($repository);

        self::assertEquals(
            '+05:00',
            $timezoneBetweenCountries->calculate($code, $code2)
        );
    }
}
