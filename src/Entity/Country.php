<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Entity;

use DateTime;
use DateTimeZone;

class Country
{
    private DateTime $date;

    public function __construct(DateTimeZone $countryTimeZone)
    {
        $this->date = new DateTime('now', $countryTimeZone);
    }

    public function dateTime(): string
    {
        return $this->date->format('Y-m-d H:i');
    }
}
