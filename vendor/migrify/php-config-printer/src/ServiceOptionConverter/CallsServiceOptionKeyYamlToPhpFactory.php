<?php

declare (strict_types=1);
namespace _PhpScoper6207116d4311\Migrify\PhpConfigPrinter\ServiceOptionConverter;

use _PhpScoper6207116d4311\Migrify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use _PhpScoper6207116d4311\Migrify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory;
use _PhpScoper6207116d4311\Migrify\PhpConfigPrinter\ValueObject\YamlServiceKey;
use _PhpScoper6207116d4311\PhpParser\Node\Expr\MethodCall;
final class CallsServiceOptionKeyYamlToPhpFactory implements \_PhpScoper6207116d4311\Migrify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;
    public function __construct(\_PhpScoper6207116d4311\Migrify\PhpConfigPrinter\NodeFactory\Service\SingleServicePhpNodeFactory $singleServicePhpNodeFactory)
    {
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoper6207116d4311\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoper6207116d4311\PhpParser\Node\Expr\MethodCall
    {
        return $this->singleServicePhpNodeFactory->createCalls($methodCall, $yaml);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \_PhpScoper6207116d4311\Migrify\PhpConfigPrinter\ValueObject\YamlServiceKey::CALLS;
    }
}
