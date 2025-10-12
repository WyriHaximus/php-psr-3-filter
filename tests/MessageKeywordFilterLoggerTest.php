<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\MessageKeywordFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class MessageKeywordFilterLoggerTest extends TestCase
{
    #[Test]
    public function filter(): void
    {
        $keywords = ['foo', 'bAr'];
        $logger   = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('info', 'faa bor', [])->atLeast()->once();

        $filter = new MessageKeywordFilterLogger($keywords, $logger);
        $filter->log('info', 'fOo');
        $filter->log('info', 'bar');
        $filter->log('info', 'faa bor');
    }
}
