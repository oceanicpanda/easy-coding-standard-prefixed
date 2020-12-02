<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScopera23ebff5477f\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScopera23ebff5477f\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScopera23ebff5477f\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
