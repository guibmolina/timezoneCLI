<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Tests\Repository;

use Guilherme\Timezone\Entity\Country;
use Guilherme\Timezone\Exceptions\CountryCodeNotFoundException;
use Guilherme\Timezone\Repository\CountryTimeZone;
use Guilherme\Timezone\ValueObject\Code;
use PHPUnit\Framework\TestCase;

class CountryTimeZoneTest extends TestCase
{
    /** @test */
    public function itMustReturnACountryIfFoundByCode(): void
    {
        $code = $this->getMockBuilder(Code::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__toString'])
            ->getMock();

        $code->method('__toString')
            ->willReturn('BRA');

        $countryTimezone = new CountryTimeZone();

        self::assertInstanceOf(
            Country::class,
            $countryTimezone->countryByCode($code)
        );
    }

    /** @test */
    public function itShouldThrowAExceptionWhenNotFoundCountry(): void
    {
        $code = $this->getMockBuilder(Code::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__toString'])
            ->getMock();

        $code->method('__toString')
            ->willReturn('AAA');

        $countryTimezone = new CountryTimeZone();

        $this->expectException(CountryCodeNotFoundException::class);

        $countryTimezone->countryByCode($code);
    }
}
