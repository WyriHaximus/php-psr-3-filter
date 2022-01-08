<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

use function in_array;

final class LogLevelFilterLogger extends AbstractLogger
{
    /** @var array<string> */
    private array $levels;

    private LoggerInterface $logger;

    /**
     * @param array<string> $levels
     */
    public function __construct(array $levels, LoggerInterface $logger)
    {
        $this->levels = $levels;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, $message, array $context = []): void
    {
        if (in_array($level, $this->levels, true)) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
