<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\LogLevelFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class LogLevelFilterLoggerTest extends TestCase
{
    public function testFilter(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', [])->shouldBeCalled();

        $filter = new LogLevelFilterLogger(['error'], $logger->reveal());
        $filter->log('error', 'fOo');
        $filter->log('error', 'bar');
        $filter->log('info', 'faa bor');
    }
}
