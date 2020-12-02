<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Naming;

use _PhpScoper992f4af8b9e0\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoper992f4af8b9e0\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoper992f4af8b9e0\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
