<?php

declare (strict_types=1);
namespace _PhpScoper666af036e800\Migrify\PhpConfigPrinter\RoutingCaseConverter;

use _PhpScoper666af036e800\Migrify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use _PhpScoper666af036e800\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoper666af036e800\Migrify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper666af036e800\PhpParser\Node\Arg;
use _PhpScoper666af036e800\PhpParser\Node\Expr\MethodCall;
use _PhpScoper666af036e800\PhpParser\Node\Expr\Variable;
use _PhpScoper666af036e800\PhpParser\Node\Stmt\Expression;
final class PathRoutingCaseConverter implements \_PhpScoper666af036e800\Migrify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface
{
    /**
     * @var string[]
     */
    private const NESTED_KEYS = ['controller', 'defaults'];
    /**
     * @var string
     */
    private const PATH = 'path';
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\_PhpScoper666af036e800\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function match(string $key, $values) : bool
    {
        return isset($values[self::PATH]);
    }
    public function convertToMethodCall(string $key, $values) : \_PhpScoper666af036e800\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScoper666af036e800\PhpParser\Node\Expr\Variable(\_PhpScoper666af036e800\Migrify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        // @todo args
        $args = $this->createAddArgs($key, $values);
        $methodCall = new \_PhpScoper666af036e800\PhpParser\Node\Expr\MethodCall($variable, 'add', $args);
        foreach (self::NESTED_KEYS as $nestedKey) {
            if (!isset($values[$nestedKey])) {
                continue;
            }
            $args = $this->argsNodeFactory->createFromValues([$values[$nestedKey]]);
            $methodCall = new \_PhpScoper666af036e800\PhpParser\Node\Expr\MethodCall($methodCall, $nestedKey, $args);
        }
        return new \_PhpScoper666af036e800\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param mixed $values
     * @return Arg[]
     */
    private function createAddArgs(string $key, $values) : array
    {
        $argumentValues = [];
        $argumentValues[] = $key;
        if (isset($values[self::PATH])) {
            $argumentValues[] = $values[self::PATH];
        }
        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
