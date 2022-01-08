<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

use function explode;
use function igorw\get_in;
use function in_array;

final class ContextFilterLogger extends AbstractLogger
{
    /** @var array<string> */
    private array $field;

    /** @var array<mixed> */
    private array $values;

    private LoggerInterface $logger;

    private bool $exclude;

    /**
     * @param array<mixed> $values
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(string $field, array $values, LoggerInterface $logger, bool $exclude = true)
    {
        $this->field   = explode('.', $field);
        $this->values  = $values;
        $this->logger  = $logger;
        $this->exclude = $exclude;
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function log($level, $message, array $context = []): void
    {
        $value = get_in($context, $this->field);
        if ($value !== null && in_array($value, $this->values, true) === $this->exclude) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
