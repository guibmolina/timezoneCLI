<?php

declare(strict_types=1);

namespace Guilherme\Timezone\UseCases\CountryDate;

use Guilherme\Timezone\Repository\CountryTimeZone as Repository;
use Guilherme\Timezone\ValueObject\Code;

class CountryDate
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function date(Code $code)
    {
        $country = $this->repository->countryByCode($code);

        return $country->dateTime();
    }
}
