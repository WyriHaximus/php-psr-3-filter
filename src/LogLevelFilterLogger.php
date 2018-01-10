<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class LogLevelFilterLogger extends AbstractLogger
{
    /**
     * @var array
     */
    private $levels;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param array           $levels
     * @param LoggerInterface $logger
     */
    public function __construct(array $levels, LoggerInterface $logger)
    {
        $this->levels = $levels;
        $this->logger = $logger;
    }

    public function log($level, $message, array $context = [])
    {
        if (in_array($level, $this->levels, true)) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
