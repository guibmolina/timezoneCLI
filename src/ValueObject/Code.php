<?php

declare(strict_types=1);

namespace Guilherme\Timezone\ValueObject;

use Guilherme\Timezone\Exceptions\CodeInvalidException;

class Code
{
    private string $code;

    public function __construct(string $code)
    {
        $this->setCode($code);
    }

    private function setCode(string $code): void
    {
        if (strlen($code) !== 3) {
            throw new CodeInvalidException(
                'Code is invalid' . PHP_EOL .
                "Run './index.php -c' to see all codes'"
            );
        }

        $this->code = strtoupper($code);
    }

    public function __toString()
    {
        return $this->code;
    }
}
