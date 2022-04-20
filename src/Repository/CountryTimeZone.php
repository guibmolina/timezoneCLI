<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Repository;

use DateTimeZone;
use Guilherme\Timezone\Entity\Country;
use Guilherme\Timezone\Exceptions\CountryCodeNotFoundException;
use Guilherme\Timezone\ValueObject\Code;

class CountryTimeZone
{
    private array $countryTimeZone;

    public function __construct()
    {
        $this->countryTimeZone = include 'timezoneCountry.php';
    }

    public function countryByCode(Code $code): Country
    {
        if (array_key_exists("$code", $this->countryTimeZone)) {
            return new Country(new DateTimeZone($this->countryTimeZone["$code"]));
        }

        throw new CountryCodeNotFoundException(
            "Country code $code not found" . PHP_EOL .
            "Run './index.php -c' to see all codes'"
        );
    }

    public function GMTDateTime(): string
    {
        return gmdate('Y-m-d H:i');
    }
}
