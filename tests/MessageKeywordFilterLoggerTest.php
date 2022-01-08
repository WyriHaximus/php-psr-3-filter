<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\MessageKeywordFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class MessageKeywordFilterLoggerTest extends TestCase
{
    public function testFilter(): void
    {
        $keywords = ['foo', 'bAr'];
        $logger   = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', [])->shouldBeCalled();

        $filter = new MessageKeywordFilterLogger($keywords, $logger->reveal());
        $filter->log('info', 'fOo');
        $filter->log('info', 'bar');
        $filter->log('info', 'faa bor');
    }
}
