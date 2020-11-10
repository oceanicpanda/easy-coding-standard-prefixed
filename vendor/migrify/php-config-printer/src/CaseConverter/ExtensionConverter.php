<?php

declare (strict_types=1);
namespace _PhpScoper48800f361566\Migrify\PhpConfigPrinter\CaseConverter;

use _PhpScoper48800f361566\Migrify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper48800f361566\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use _PhpScoper48800f361566\Migrify\PhpConfigPrinter\ValueObject\MethodName;
use _PhpScoper48800f361566\Migrify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper48800f361566\Migrify\PhpConfigPrinter\ValueObject\YamlKey;
use _PhpScoper48800f361566\PhpParser\Node\Expr\MethodCall;
use _PhpScoper48800f361566\PhpParser\Node\Expr\Variable;
use _PhpScoper48800f361566\PhpParser\Node\Stmt\Expression;
/**
 * Handles this part:
 *
 * framework: <---
 *     key: value
 */
final class ExtensionConverter implements \_PhpScoper48800f361566\Migrify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var string
     */
    private $rootKey;
    /**
     * @var YamlKey
     */
    private $yamlKey;
    public function __construct(\_PhpScoper48800f361566\Migrify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \_PhpScoper48800f361566\Migrify\PhpConfigPrinter\ValueObject\YamlKey $yamlKey)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlKey = $yamlKey;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper48800f361566\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \_PhpScoper48800f361566\PhpParser\Node\Expr\Variable(\_PhpScoper48800f361566\Migrify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \_PhpScoper48800f361566\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \_PhpScoper48800f361566\Migrify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \_PhpScoper48800f361566\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, $this->yamlKey->provideRootKeys(), \true);
    }
}
