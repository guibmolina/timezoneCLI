<?php

declare(strict_types=1);

namespace Guilherme\Timezone\UseCases\CountryTimezoneGMT;

use DateTimeZone;
use Guilherme\Timezone\Entity\Country;
use Guilherme\Timezone\Repository\CountryTimeZone as Repository;
use Guilherme\Timezone\ValueObject\Code;

class CountryTimezoneGMT
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function calculate(Code $codeCountryTarget): string
    {
        $countryTarget = $this->repository->countryByCode($codeCountryTarget);

        $dateOrigin = $this->repository->GMTDateTime();
        $dateTarget = $countryTarget->dateTime();

        $interval = date_diff(
            new \DateTime($dateOrigin),
            new \DateTime($dateTarget),
        );

        return $interval->format('%R%H:%I');
    }
}
