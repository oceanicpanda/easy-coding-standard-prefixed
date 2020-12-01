<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoper4972b76c81a2\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper4972b76c81a2\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper4972b76c81a2\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}