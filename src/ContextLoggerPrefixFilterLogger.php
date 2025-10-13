<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;
use WyriHaximus\PSR3\Utils;

use function strrpos;
use function substr;
use function trim;

final readonly class ContextLoggerPrefixFilterLogger implements LoggerInterface
{
    use LoggerTrait;

    private const int POSITION_PLUS_PLUS = 1;

    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * @param array<string, mixed> $context
     *
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $message = (string) $message;
        $pos     = strrpos($message, ']');
        if ($pos !== false) {
            $message = substr($message, $pos + self::POSITION_PLUS_PLUS);
            $message = trim($message);
        }

        $level = Utils::formatValue($level);
        Utils::checkCorrectLogLevel($level);

        /** @phpstan-ignore psr3.interpolated */
        $this->logger->log(
            $level,
            Utils::processPlaceHolders($message, $context),
            $context,
        );
    }
}
