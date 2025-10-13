<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;
use WyriHaximus\PSR3\Utils;

use function in_array;

final readonly class LogLevelFilterLogger implements LoggerInterface
{
    use LoggerTrait;

    /** @param array<string> $levels */
    public function __construct(private array $levels, private LoggerInterface $logger)
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
        if (in_array($level, $this->levels, true)) {
            return;
        }

        $level = Utils::formatValue($level);
        Utils::checkCorrectLogLevel($level);

        /** @phpstan-ignore psr3.interpolated */
        $this->logger->log(
            $level,
            Utils::processPlaceHolders((string) $message, $context),
            $context,
        );
    }
}
