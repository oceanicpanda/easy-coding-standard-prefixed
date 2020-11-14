<?php

declare (strict_types=1);
namespace _PhpScoperb09c3ec8e01a\Migrify\PhpConfigPrinter\Naming;

use _PhpScoperb09c3ec8e01a\Nette\Utils\Strings;
final class ClassNaming
{
    public function getShortName(string $class) : string
    {
        if (\_PhpScoperb09c3ec8e01a\Nette\Utils\Strings::contains($class, '\\')) {
            return (string) \_PhpScoperb09c3ec8e01a\Nette\Utils\Strings::after($class, '\\', -1);
        }
        return $class;
    }
}
