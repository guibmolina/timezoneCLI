<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Tests\UseCases;

use Guilherme\Timezone\Entity\Country;
use Guilherme\Timezone\Repository\CountryTimeZone;
use Guilherme\Timezone\UseCases\CountryDate\CountryDate;
use Guilherme\Timezone\ValueObject\Code;
use PHPUnit\Framework\TestCase;

class CountryDateTest extends TestCase
{
    /** @test */
    public function itMustReturnDateTimeOfCountry()
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

        $country = $this->getMockBuilder(Country::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['dateTime'])
            ->getMock();

        $country->expects($this->once())
            ->method('dateTime')
            ->willReturn('2022-04-20 08:01');

        $repository->expects($this->once())
            ->method('countryByCode')
            ->with($code)
            ->willReturn($country);

        $countryDate = new CountryDate($repository);

        self::assertEquals('2022-04-20 08:01', $countryDate->date($code));
    }
}
