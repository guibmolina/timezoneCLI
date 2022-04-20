<?php

declare(strict_types=1);

namespace Guilherme\Timezone\Tests\ValueObject;

use Guilherme\Timezone\Exceptions\CodeInvalidException;
use Guilherme\Timezone\ValueObject\Code;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    /** @test @dataProvider codeProviders */
    public function itShouldNotAcceptInvalidCode(string $code): void
    {
        $this->expectException(CodeInvalidException::class);

        $code = new Code($code);
    }

    public function codeProviders(): array
    {
        return [
            ['AA'],
            ['B'],
            ['CCCC'],
        ];
    }
}
