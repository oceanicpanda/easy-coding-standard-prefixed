<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\Nette\Utils\Strings;
use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\Class_;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\Property;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\ExcessivePublicCountRule\ExcessivePublicCountRuleTest
 */
final class ExcessivePublicCountRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Too many public elements on class - %d. Try narrow it down under %d';
    /**
     * @var string
     * @see https://regex101.com/r/YnDoFR/1
     */
    private const VALUE_OBJECT_REGEX = '#\\bValueObject\\b#';
    /**
     * @var int
     */
    private $maxPublicClassElementCount;
    public function __construct(int $maxPublicClassElementCount)
    {
        $this->maxPublicClassElementCount = $maxPublicClassElementCount;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        $classPublicElementCount = $this->resolveClassPublicElementCount($node);
        if ($classPublicElementCount < $this->maxPublicClassElementCount) {
            return [];
        }
        $errorMessage = \sprintf(self::ERROR_MESSAGE, $classPublicElementCount, $this->maxPublicClassElementCount);
        return [$errorMessage];
    }
    private function resolveClassPublicElementCount(\_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Class_ $class) : int
    {
        $publicElementCount = 0;
        $className = (string) $class->namespacedName;
        foreach ($class->stmts as $classStmt) {
            if ($this->shouldSkipClassStmt($classStmt, $className)) {
                continue;
            }
            ++$publicElementCount;
        }
        return $publicElementCount;
    }
    private function shouldSkipClassStmt(\_PhpScoper3d04c8135695\PhpParser\Node\Stmt $classStmt, string $className) : bool
    {
        if (!$classStmt instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Property && !$classStmt instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod && !$classStmt instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassConst) {
            return \true;
        }
        if (!$classStmt->isPublic()) {
            return \true;
        }
        if (\_PhpScoper3d04c8135695\Nette\Utils\Strings::match($className, self::VALUE_OBJECT_REGEX) && $classStmt instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassConst) {
            return \true;
        }
        if ($classStmt instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod) {
            $methodName = (string) $classStmt->name;
            return \_PhpScoper3d04c8135695\Nette\Utils\Strings::startsWith($methodName, '__');
        }
        return \false;
    }
}
