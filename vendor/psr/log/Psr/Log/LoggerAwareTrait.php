<?php

namespace _PhpScoperbd5fb781fe24\Psr\Log;

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
    public function setLogger(\_PhpScoperbd5fb781fe24\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
