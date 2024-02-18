<?php

namespace App\Domain\Notifications\Tests\Unit;

use App\Infrastructure\Support\ExceptionFormat;
use Tests\TestCase;

class ExceptionFormatTest extends TestCase
{
    public function testLog(): void
    {
        $exception = new \Exception('testing');

        $message = ExceptionFormat::log($exception);

        $this->assertStringStartsWith('File:', $message);
    }
}
