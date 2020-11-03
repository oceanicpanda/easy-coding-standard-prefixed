<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\CognitiveComplexity\Tests\Rules\ClassLikeCognitiveComplexityRule;

use Iterator;
use _PhpScoper3d04c8135695\PHPStan\Rules\Rule;
use Symplify\CodingStandard\CognitiveComplexity\Rules\ClassLikeCognitiveComplexityRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;
final class ClassLikeCognitiveComplexityRuleTest extends \Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase
{
    /**
     * @dataProvider provideDataForTest()
     */
    public function test(string $filePath, array $expectedErrorMessagesWithLines) : void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }
    public function provideDataForTest() : \Iterator
    {
        $errorMessage = \sprintf(\Symplify\CodingStandard\CognitiveComplexity\Rules\ClassLikeCognitiveComplexityRule::ERROR_MESSAGE, 'Class', 'ClassWithManyComplexMethods', 54, 50);
        (yield [__DIR__ . '/Source/ClassWithManyComplexMethods.php', [[$errorMessage, 7]]]);
    }
    protected function getRule() : \_PhpScoper3d04c8135695\PHPStan\Rules\Rule
    {
        return $this->getRuleFromConfig(\Symplify\CodingStandard\CognitiveComplexity\Rules\ClassLikeCognitiveComplexityRule::class, __DIR__ . '/../../../../../packages/cognitive-complexity/config/cognitive-complexity-rules.neon');
    }
}
