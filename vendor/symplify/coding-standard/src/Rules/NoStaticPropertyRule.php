<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
use _PhpScoper3d04c8135695\PHPStan\DependencyInjection\Container;
use _PhpScoper3d04c8135695\Psr\Container\ContainerInterface;
use _PhpScoper3d04c8135695\Symfony\Component\HttpKernel\KernelInterface;
use Symplify\CodingStandard\PHPStan\Types\ContainsTypeAnalyser;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\NoStaticPropertyRule\NoStaticPropertyRuleTest
 */
final class NoStaticPropertyRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Do not use static property';
    /**
     * @var string[]
     */
    private const CACHEABLE_TYPES = [\_PhpScoper3d04c8135695\Psr\Container\ContainerInterface::class, \_PhpScoper3d04c8135695\PHPStan\DependencyInjection\Container::class, \_PhpScoper3d04c8135695\Symfony\Component\HttpKernel\KernelInterface::class];
    /**
     * @var ContainsTypeAnalyser
     */
    private $containsTypeAnalyser;
    public function __construct(\Symplify\CodingStandard\PHPStan\Types\ContainsTypeAnalyser $containsTypeAnalyser)
    {
        $this->containsTypeAnalyser = $containsTypeAnalyser;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticPropertyFetch::class];
    }
    /**
     * @param StaticPropertyFetch $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->containsTypeAnalyser->containsExprTypes($node, $scope, self::CACHEABLE_TYPES)) {
            return [];
        }
        return [self::ERROR_MESSAGE];
    }
}
