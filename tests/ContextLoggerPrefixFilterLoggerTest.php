<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\ContextLoggerPrefixFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class ContextLoggerPrefixFilterLoggerTest extends TestCase
{
    #[Test]
    public function removedContext(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('info', 'faa bor', [])->atLeast()->once();
        $logger->expects('log')->with('info', 'sub ponfar', [])->atLeast()->once();

        $filter = new ContextLoggerPrefixFilterLogger($logger);
        $filter->log('info', '[Context] faa bor');
        $filter->log('info', '[Context] [SubContext] sub ponfar');
    }
}
