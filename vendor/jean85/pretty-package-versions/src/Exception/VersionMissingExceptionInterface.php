<?php

declare (strict_types=1);
namespace _PhpScoper0ba97041430d\Jean85\Exception;

interface VersionMissingExceptionInterface extends \Throwable
{
    public static function create(string $packageName) : self;
}
