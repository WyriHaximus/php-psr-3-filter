<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\LogLevelFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class LogLevelFilterLoggerTest extends TestCase
{
    #[Test]
    public function filter(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('info', 'faa bor', [])->atLeast()->once();

        $filter = new LogLevelFilterLogger(['error'], $logger);
        $filter->log('error', 'fOo');
        $filter->log('error', 'bar');
        $filter->log('info', 'faa bor');
    }
}
