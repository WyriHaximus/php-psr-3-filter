<?php declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\Filter;

use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\LoggerInterfaceTest;
use WyriHaximus\PSR3\Filter\ContextFilterLogger;
use function WyriHaximus\PSR3\checkCorrectLogLevel;
use function WyriHaximus\PSR3\processPlaceHolders;

final class ContextFilterLoggerTest extends LoggerInterfaceTest
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

        return new ContextFilterLogger('does.not.exist', [], $logger->reveal());
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function testExclude()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]])->shouldBeCalled();

        $filter = new ContextFilterLogger('l.v.l', ['error'], $logger->reveal());
        $filter->log('error', 'fOo', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('error', 'bar', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]]);
    }

    public function testInclude()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]])->shouldBeCalled();

        $filter = new ContextFilterLogger('l.v.l', ['info'], $logger->reveal(), false);
        $filter->log('error', 'fOo', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('error', 'bar', ['l' => ['v' => ['l' => 'error']]]);
        $filter->log('info', 'faa bor', ['l' => ['v' => ['l' => 'info']]]);
    }
}
