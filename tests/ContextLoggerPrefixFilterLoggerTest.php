<?php declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\LoggerInterfaceTest;
use WyriHaximus\PSR3\Filter\ContextLoggerPrefixFilterLogger;
use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\processPlaceHolders;

final class ContextLoggerPrefixFilterLoggerTest extends LoggerInterfaceTest
{
    /**
     * @var array
     */
    public $logs = [];

    public function getLogger()
    {
        $that = $this;
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log(
            Argument::any(),
            Argument::any(),
            Argument::any()
        )->will(function ($args) use ($that) {
            list($level, $message, $context) = $args;
            $message = (string)$message;
            checkCorrectLogLevel($level);
            $message = processPlaceHolders($message, $context);
            $that->logs[] = $level . ' ' . $message;

            return true;
        });

        return new ContextLoggerPrefixFilterLogger($logger->reveal());
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function testRemovedContext()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', [])->shouldBeCalled();
        $logger->log('info', 'sub ponfar', [])->shouldBeCalled();

        $filter = new ContextLoggerPrefixFilterLogger($logger->reveal());
        $filter->log('info', '[Context] faa bor');
        $filter->log('info', '[Context] [SubContext] sub ponfar');
    }
}
