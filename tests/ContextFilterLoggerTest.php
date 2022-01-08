<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Filter\ContextFilterLogger;
use WyriHaximus\TestUtilities\TestCase;

final class ContextFilterLoggerTest extends TestCase
{
    public function testExclude(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]])->shouldBeCalled();

        $filter = new ContextFilterLogger('l.v.l', ['error'], $logger->reveal());
        $filter->log('error', 'fOo', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('error', 'bar', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]]);
    }

    public function testInclude(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]])->shouldBeCalled();

        $filter = new ContextFilterLogger('l.v.l', ['info'], $logger->reveal(), false);
        $filter->log('error', 'fOo', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('error', 'bar', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]]);
    }
}
