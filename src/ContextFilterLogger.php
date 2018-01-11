<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use function igorw\get_in;

final class ContextFilterLogger extends AbstractLogger
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
     * @var bool
     */
    private $exclude;

    /**
     * @param string          $field
     * @param array           $values
     * @param LoggerInterface $logger
     * @param bool            $exclude
     */
    public function __construct(string $field, array $values, LoggerInterface $logger, bool $exclude = true)
    {
        $this->field = explode('.', $field);
        $this->values = $values;
        $this->logger = $logger;
        $this->exclude = $exclude;
    }

    public function log($level, $message, array $context = [])
    {
        $value = get_in($context, $this->field);
        if ($value !== null && in_array($value, $this->values, true) === $this->exclude) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}
