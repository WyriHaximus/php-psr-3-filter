<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\ContextLoggerPrefixFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class ContextLoggerPrefixFilterLoggerTest extends TestCase
{
    public function testRemovedContext(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', [])->shouldBeCalled();
        $logger->log('info', 'sub ponfar', [])->shouldBeCalled();

        $filter = new ContextLoggerPrefixFilterLogger($logger->reveal());
        $filter->log('info', '[Context] faa bor');
        $filter->log('info', '[Context] [SubContext] sub ponfar');
    }
}
