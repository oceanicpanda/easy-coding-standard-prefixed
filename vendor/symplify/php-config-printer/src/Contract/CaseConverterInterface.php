<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Contract;

use _PhpScopera51a90153f58\PhpParser\Node\Stmt\Expression;
interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values) : bool;
    public function convertToMethodCall($key, $values) : \_PhpScopera51a90153f58\PhpParser\Node\Stmt\Expression;
}
