<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

use function stripos;

final class MessageKeywordFilterLogger extends AbstractLogger
{
    /** @var array<string> */
    private array $keywords;

    private LoggerInterface $logger;

    /**
     * @param array<string> $keywords
     */
    public function __construct(array $keywords, LoggerInterface $logger)
    {
        $this->keywords = $keywords;
        $this->logger   = $logger;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, $message, array $context = []): void
    {
        foreach ($this->keywords as $keyword) {
            if (stripos((string) $message, $keyword) !== false) {
                return;
            }
        }

        $this->logger->log($level, $message, $context);
    }
}
