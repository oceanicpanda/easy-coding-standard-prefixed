<?php

declare (strict_types=1);
namespace _PhpScopercda2b863d098\Migrify\PhpConfigPrinter\ServiceOptionConverter;

use _PhpScopercda2b863d098\Migrify\MigrifyKernel\Exception\NotImplementedYetException;
use _PhpScopercda2b863d098\Migrify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use _PhpScopercda2b863d098\PhpParser\Node\Expr\MethodCall;
final class SharedPublicServiceOptionKeyYamlToPhpFactory implements \_PhpScopercda2b863d098\Migrify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScopercda2b863d098\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScopercda2b863d098\PhpParser\Node\Expr\MethodCall
    {
        if ($key === 'public') {
            if ($yaml === \false) {
                return new \_PhpScopercda2b863d098\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
            }
            return new \_PhpScopercda2b863d098\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        throw new \_PhpScopercda2b863d098\Migrify\MigrifyKernel\Exception\NotImplementedYetException();
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, ['shared', 'public'], \true);
    }
}
