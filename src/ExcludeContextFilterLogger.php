<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use function igorw\get_in;

final class ExcludeContextFilterLogger extends AbstractLogger
{
    /**
     * @var array
     */
    private $field;

    /**
     * @var array
     */
    private $values;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param array           $values
     * @param LoggerInterface $logger
     */
    public function __construct(string $field, array $values, LoggerInterface $logger)
    {
        $this->field = explode('.', $field);
        $this->values = $values;
        $this->logger = $logger;
    }

    public function log($level, $message, array $context = [])
    {
        $value = get_in($context, $this->field);
        if ($value !== null && in_array($value, $this->values, true)) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
