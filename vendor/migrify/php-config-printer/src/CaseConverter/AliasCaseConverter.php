<?php

declare (strict_types=1);
namespace _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\CaseConverter;

use _PhpScopere5e7dca8c031\Migrify\MigrifyKernel\Exception\ShouldNotHappenException;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\YamlKey;
use _PhpScopere5e7dca8c031\Nette\Utils\Strings;
use _PhpScopere5e7dca8c031\PhpParser\Node\Arg;
use _PhpScopere5e7dca8c031\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere5e7dca8c031\PhpParser\Node\Expr\MethodCall;
use _PhpScopere5e7dca8c031\PhpParser\Node\Expr\Variable;
use _PhpScopere5e7dca8c031\PhpParser\Node\Scalar\String_;
use _PhpScopere5e7dca8c031\PhpParser\Node\Stmt\Expression;
/**
 * Handles this part:
 *
 * services:
 *     Some: Other <---
 */
final class AliasCaseConverter implements \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @see https://regex101.com/r/BwXkfO/2/
     * @var string
     */
    private const ARGUMENT_NAME_REGEX = '#\\$(?<argument_name>\\w+)#';
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScopere5e7dca8c031\PhpParser\Node\Stmt\Expression
    {
        if (!\is_string($key)) {
            throw new \_PhpScopere5e7dca8c031\Migrify\MigrifyKernel\Exception\ShouldNotHappenException();
        }
        $servicesVariable = new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\Variable(\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        if (\class_exists($key) || \interface_exists($key)) {
            $classReference = $this->commonNodeFactory->createClassReference($key);
            $argValues = [];
            $argValues[] = $classReference;
            $argValues[] = $values[\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS] ?? $values;
            $args = $this->argsNodeFactory->createFromValues($argValues, \true);
            $methodCall = new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
            return new \_PhpScopere5e7dca8c031\PhpParser\Node\Stmt\Expression($methodCall);
        }
        // handles: "SomeClass $someVariable: ..."
        $fullClassName = \_PhpScopere5e7dca8c031\Nette\Utils\Strings::before($key, ' $');
        if ($fullClassName !== null) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $values);
            return new \_PhpScopere5e7dca8c031\PhpParser\Node\Stmt\Expression($methodCall);
        }
        if (isset($values[\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS])) {
            $className = $values[\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS];
            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
            $methodCall = new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
            unset($values[\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS]);
        }
        /** @var string|mixed[] $values */
        if (\is_string($values) && $values[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$values], \true);
            $methodCall = new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\MethodCall($servicesVariable, \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
        } elseif (\is_array($values)) {
            /** @var MethodCall $methodCall */
            $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        }
        return new \_PhpScopere5e7dca8c031\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (isset($values[\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS])) {
            return \true;
        }
        if (\_PhpScopere5e7dca8c031\Nette\Utils\Strings::match($key, '#\\w+\\s+\\$\\w+#')) {
            return \true;
        }
        return \is_string($values) && $values[0] === '@';
    }
    private function createAliasNode(string $key, string $fullClassName, $serviceValues) : \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\MethodCall
    {
        $args = [];
        $classConstFetch = $this->commonNodeFactory->createClassReference($fullClassName);
        \_PhpScopere5e7dca8c031\Nette\Utils\Strings::match($key, self::ARGUMENT_NAME_REGEX);
        $argumentName = \strstr($key, '$');
        $concat = new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\BinaryOp\Concat($classConstFetch, new \_PhpScopere5e7dca8c031\PhpParser\Node\Scalar\String_(' ' . $argumentName));
        $args[] = new \_PhpScopere5e7dca8c031\PhpParser\Node\Arg($concat);
        $serviceName = \ltrim($serviceValues, '@');
        $args[] = new \_PhpScopere5e7dca8c031\PhpParser\Node\Arg(new \_PhpScopere5e7dca8c031\PhpParser\Node\Scalar\String_($serviceName));
        return new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\MethodCall(new \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\Variable(\_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \_PhpScopere5e7dca8c031\Migrify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
    }
}
