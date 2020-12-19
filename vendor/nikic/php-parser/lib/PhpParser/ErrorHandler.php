<?php

declare (strict_types=1);
namespace _PhpScoperfb2c402b972b\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\_PhpScoperfb2c402b972b\PhpParser\Error $error);
}
