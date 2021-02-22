<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use _PhpScoperfcee700af3df\Nette\Utils\Strings;
use _PhpScoperfcee700af3df\PhpParser\BuilderHelpers;
use _PhpScoperfcee700af3df\PhpParser\Node\Arg;
use _PhpScoperfcee700af3df\PhpParser\Node\Expr;
use _PhpScoperfcee700af3df\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperfcee700af3df\PhpParser\Node\Expr\FuncCall;
use _PhpScoperfcee700af3df\PhpParser\Node\Name\FullyQualified;
use _PhpScoperfcee700af3df\PhpParser\Node\Scalar\String_;
use _PhpScoperfcee700af3df\Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class StringExprResolver
{
    /**
     * @see https://regex101.com/r/laf2wR/1
     * @var string
     */
    private const TWIG_HTML_XML_SUFFIX_REGEX = '#\\.(twig|html|xml)$#';
    /**
     * @var ConstantNodeFactory
     */
    private $constantNodeFactory;
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var SymfonyFunctionNameProvider
     */
    private $symfonyFunctionNameProvider;
    public function __construct(\Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory $constantNodeFactory, \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider $symfonyFunctionNameProvider)
    {
        $this->constantNodeFactory = $constantNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
        $this->symfonyFunctionNameProvider = $symfonyFunctionNameProvider;
    }
    public function resolve(string $value, bool $skipServiceReference, bool $skipClassesToConstantReference) : \_PhpScoperfcee700af3df\PhpParser\Node\Expr
    {
        if ($value === '') {
            return new \_PhpScoperfcee700af3df\PhpParser\Node\Scalar\String_($value);
        }
        $constFetch = $this->constantNodeFactory->createConstantIfValue($value);
        if ($constFetch !== null) {
            return $constFetch;
        }
        // do not print "\n" as empty space, but use string value instead
        if (\in_array($value, ["\r", "\n", "\r\n"], \true)) {
            return $this->keepNewline($value);
        }
        $value = \ltrim($value, '\\');
        if ($this->isClassType($value)) {
            return $this->resolveClassType($skipClassesToConstantReference, $value);
        }
        if (\_PhpScoperfcee700af3df\Nette\Utils\Strings::startsWith($value, '@=')) {
            $value = \ltrim($value, '@=');
            $expr = $this->resolve($value, $skipServiceReference, $skipClassesToConstantReference);
            $args = [new \_PhpScoperfcee700af3df\PhpParser\Node\Arg($expr)];
            return new \_PhpScoperfcee700af3df\PhpParser\Node\Expr\FuncCall(new \_PhpScoperfcee700af3df\PhpParser\Node\Name\FullyQualified(\Symplify\PhpConfigPrinter\ValueObject\FunctionName::EXPR), $args);
        }
        // is service reference
        if (\_PhpScoperfcee700af3df\Nette\Utils\Strings::startsWith($value, '@') && !$this->isFilePath($value)) {
            $refOrServiceFunctionName = $this->symfonyFunctionNameProvider->provideRefOrService();
            return $this->resolveServiceReferenceExpr($value, $skipServiceReference, $refOrServiceFunctionName);
        }
        return \_PhpScoperfcee700af3df\PhpParser\BuilderHelpers::normalizeValue($value);
    }
    private function keepNewline(string $value) : \_PhpScoperfcee700af3df\PhpParser\Node\Scalar\String_
    {
        $string = new \_PhpScoperfcee700af3df\PhpParser\Node\Scalar\String_($value);
        $string->setAttribute(\_PhpScoperfcee700af3df\Rector\NodeTypeResolver\Node\AttributeKey::KIND, \_PhpScoperfcee700af3df\PhpParser\Node\Scalar\String_::KIND_DOUBLE_QUOTED);
        return $string;
    }
    private function isFilePath(string $value) : bool
    {
        return (bool) \_PhpScoperfcee700af3df\Nette\Utils\Strings::match($value, self::TWIG_HTML_XML_SUFFIX_REGEX);
    }
    /**
     * @return String_|ClassConstFetch
     */
    private function resolveClassType(bool $skipClassesToConstantReference, string $value) : \_PhpScoperfcee700af3df\PhpParser\Node\Expr
    {
        if ($skipClassesToConstantReference) {
            return new \_PhpScoperfcee700af3df\PhpParser\Node\Scalar\String_($value);
        }
        return $this->commonNodeFactory->createClassReference($value);
    }
    private function isClassType(string $value) : bool
    {
        if (!\ctype_upper($value[0])) {
            return \false;
        }
        if (\class_exists($value)) {
            return \true;
        }
        return \interface_exists($value);
    }
    private function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \_PhpScoperfcee700af3df\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \_PhpScoperfcee700af3df\PhpParser\Node\Arg($expr)];
        return new \_PhpScoperfcee700af3df\PhpParser\Node\Expr\FuncCall(new \_PhpScoperfcee700af3df\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
