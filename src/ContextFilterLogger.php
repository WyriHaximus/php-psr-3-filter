<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Stringable;
use WyriHaximus\PSR3\Utils;

use function explode;
use function in_array;

final readonly class ContextFilterLogger implements LoggerInterface
{
    use LoggerTrait;
    use GetFieldTrait;

    /** @var array<string> */
    private array $field;

    /**
     * @param array<mixed> $values
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(string $field, private array $values, private LoggerInterface $logger, private bool $exclude = true)
    {
        $this->field = explode('.', $field);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $value = self::getField($context, $this->field);
        if ($value !== null && in_array($value, $this->values, true) === $this->exclude) {
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
