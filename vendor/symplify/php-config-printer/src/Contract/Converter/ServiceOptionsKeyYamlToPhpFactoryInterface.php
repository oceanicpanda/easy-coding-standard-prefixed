<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoper0c0702cca4ac\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoper0c0702cca4ac\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoper0c0702cca4ac\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
