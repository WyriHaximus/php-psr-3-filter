<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\Filter;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

final class MessageKeywordFilterLogger extends AbstractLogger
{
    /**
     * @var array
     */
    private $keywords;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param array           $keywords
     * @param LoggerInterface $logger
     */
    public function __construct(array $keywords, LoggerInterface $logger)
    {
        $this->keywords = $keywords;
        $this->logger = $logger;
    }

    public function log($level, $message, array $context = [])
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                return;
            }
        }

        $this->logger->log($level, $message, $context);
    }
}
