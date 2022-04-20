<?php

declare(strict_types=1);

namespace Guilherme\Timezone\UseCases\TimezoneBetweenCountries;

use DateTime;
use Guilherme\Timezone\Repository\CountryTimeZone as Repository;
use Guilherme\Timezone\ValueObject\Code;

class TimezoneBetweenCountries
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function calculate(Code $codeCountryOrigin, Code $codeCountryTarget): string
    {
        $countryOrigin = $this->repository->countryByCode($codeCountryOrigin);
        $countryTarget = $this->repository->countryByCode($codeCountryTarget);

        $dateOrigin = $countryOrigin->dateTime();
        $dateTarget = $countryTarget->dateTime();

        $interval = date_diff(
            new DateTime($dateOrigin),
            new DateTime($dateTarget),
        );

        return $interval->format('%R%H:%I');
    }
}
