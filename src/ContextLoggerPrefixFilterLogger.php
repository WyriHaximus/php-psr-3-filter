<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

use function Safe\substr;
use function strrpos;
use function trim;

use const WyriHaximus\Constants\Numeric\ONE;

final class ContextLoggerPrefixFilterLogger extends AbstractLogger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, $message, array $context = []): void
    {
        $message = (string) $message;
        $pos     = strrpos($message, ']');
        if ($pos !== false) {
            $message = substr($message, $pos + ONE);
            $message = trim($message);
        }

        $this->logger->log($level, $message, $context);
    }
}
