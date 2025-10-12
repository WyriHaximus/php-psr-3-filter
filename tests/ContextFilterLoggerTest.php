<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\ContextFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class ContextFilterLoggerTest extends TestCase
{
    #[Test]
    public function exclude(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]])->atLeast()->once();

        $filter = new ContextFilterLogger('l.v.l', ['error'], $logger);
        $filter->log('error', 'fOo', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('error', 'bar', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]]);
    }

    #[Test]
    public function include(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]])->atLeast()->once();

        $filter = new ContextFilterLogger('l.v.l', ['info'], $logger, false);
        $filter->log('error', 'fOo', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('error', 'bar', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]]);
    }
}
