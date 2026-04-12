<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;
use WyriHaximus\PSR3\Utils;

use function stripos;

/** @api */
final readonly class MessageKeywordFilterLogger implements LoggerInterface
{
    use LoggerTrait;

    /** @param array<string> $keywords */
    public function __construct(private array $keywords, private LoggerInterface $logger)
    {
    }

    /**
     * @param array<mixed> $context
     *
     * @inheritDoc
     * @phpstan-ignore typeCoverage.paramTypeCoverage
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $message = (string) $message;
        foreach ($this->keywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                return;
            }
        }

        $level = Utils::formatValue($level);
        Utils::checkCorrectLogLevel($level);

        /** @phpstan-ignore psr3.interpolated */
        $this->logger->log(
            $level,
            /** @phpstan-ignore argument.type */
            Utils::processPlaceHolders($message, $context),
            $context,
        );
    }
}
