<?php

namespace _PhpScoper13160cf3462c\Psr\Log;

/**
 * Describes a logger-aware instance
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(\_PhpScoper13160cf3462c\Psr\Log\LoggerInterface $logger);
}
