<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class ContextLoggerPrefixFilterLogger extends AbstractLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log($level, $message, array $context = [])
    {
        $message = (string)$message;
        $pos = strrpos($message, ']');
        if ($pos !== false) {
            $message = substr($message, $pos + 1);
            $message = trim($message);
        }
        $this->logger->log($level, $message, $context);
    }
}
