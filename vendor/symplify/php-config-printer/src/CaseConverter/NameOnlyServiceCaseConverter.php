<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoperb6a8e65b492c\PhpParser\Node\Arg;
use _PhpScoperb6a8e65b492c\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb6a8e65b492c\PhpParser\Node\Expr\Variable;
use _PhpScoperb6a8e65b492c\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class NameOnlyServiceCaseConverter implements \Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoperb6a8e65b492c\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \_PhpScoperb6a8e65b492c\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb6a8e65b492c\PhpParser\Node\Expr\Variable(\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \_PhpScoperb6a8e65b492c\PhpParser\Node\Arg($classConstFetch)]);
        return new \_PhpScoperb6a8e65b492c\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
