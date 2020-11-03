<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\Nette\Utils\Strings;
use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\FuncCall;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
use Symplify\CodingStandard\Contract\RegexRuleInterface;
abstract class AbstractRegexRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule implements \Symplify\CodingStandard\Contract\RegexRuleInterface
{
    /**
     * @var string[]
     */
    private const FUNC_CALLS_WITH_FIRST_ARG_REGEX = ['preg_match', 'preg_match_all', 'preg_split', 'preg_replace', 'preg_replace_callback'];
    /**
     * @var string[]
     */
    private const NETTE_UTILS_CALLS_METHOD_NAMES_WITH_SECOND_ARG_REGEX = ['match', 'matchAll', 'replace', 'split'];
    /**
     * @var string
     */
    private const NETTE_UTILS_STRINGS_CLASS = \_PhpScoper3d04c8135695\Nette\Utils\Strings::class;
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper3d04c8135695\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param StaticCall|FuncCall $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\FuncCall) {
            return $this->processFuncCall($node);
        }
        return $this->processStaticCall($node);
    }
    /**
     * @return string[]
     */
    private function processFuncCall(\_PhpScoper3d04c8135695\PhpParser\Node\Expr\FuncCall $funcCall) : array
    {
        if ($funcCall->name instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr) {
            return [];
        }
        $funcCallName = (string) $funcCall->name;
        if (!\in_array($funcCallName, self::FUNC_CALLS_WITH_FIRST_ARG_REGEX, \true)) {
            return [];
        }
        return $this->processRegexFuncCall($funcCall);
    }
    /**
     * @return string[]
     */
    private function processStaticCall(\_PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall $staticCall) : array
    {
        if ($staticCall->class instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr) {
            return [];
        }
        if ($staticCall->name instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr) {
            return [];
        }
        $className = (string) $staticCall->class;
        if ($className !== self::NETTE_UTILS_STRINGS_CLASS) {
            return [];
        }
        $methodName = (string) $staticCall->name;
        if (!\in_array($methodName, self::NETTE_UTILS_CALLS_METHOD_NAMES_WITH_SECOND_ARG_REGEX, \true)) {
            return [];
        }
        return $this->processRegexStaticCall($staticCall);
    }
}
