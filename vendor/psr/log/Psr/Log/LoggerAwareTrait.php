<?php

namespace _PhpScoper9e3283ae8193\Psr\Log;

/**
 * Basic Implementation of LoggerAwareInterface.
 */
trait LoggerAwareTrait
{
    /** @var LoggerInterface */
    protected $logger;
    /**
     * Sets a logger.
     * 
     * @param LoggerInterface $logger
     */
    public function setLogger(\_PhpScoper9e3283ae8193\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
