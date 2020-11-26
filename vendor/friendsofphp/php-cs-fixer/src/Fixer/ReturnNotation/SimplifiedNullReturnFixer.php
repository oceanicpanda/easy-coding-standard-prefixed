<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Fixer\ReturnNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\VersionSpecification;
use PhpCsFixer\FixerDefinition\VersionSpecificCodeSample;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Graham Campbell <graham@alt-three.com>
 */
final class SimplifiedNullReturnFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('A return statement wishing to return `void` should not return `null`.', [new \PhpCsFixer\FixerDefinition\CodeSample("<?php return null;\n"), new \PhpCsFixer\FixerDefinition\VersionSpecificCodeSample(<<<'EOT'
<?php

namespace _PhpScoper5cb8aea05893;

function foo()
{
    return null;
}
function bar() : int
{
    return null;
}
function baz() : ?int
{
    return null;
}
function xyz() : void
{
    return null;
}

EOT
, new \PhpCsFixer\FixerDefinition\VersionSpecification(70100))]);
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        // should be run before NoUselessReturnFixer
        return -17;
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return $tokens->isTokenKindFound(\T_RETURN);
    }
    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(\T_RETURN)) {
                continue;
            }
            if ($this->needFixing($tokens, $index)) {
                $this->clear($tokens, $index);
            }
        }
    }
    /**
     * Clear the return statement located at a given index.
     *
     * @param int $index
     */
    private function clear(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        while (!$tokens[++$index]->equals(';')) {
            if ($this->shouldClearToken($tokens, $index)) {
                $tokens->clearAt($index);
            }
        }
    }
    /**
     * Does the return statement located at a given index need fixing?
     *
     * @param int $index
     *
     * @return bool
     */
    private function needFixing(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        if ($this->isStrictOrNullableReturnTypeFunction($tokens, $index)) {
            return \false;
        }
        $content = '';
        while (!$tokens[$index]->equals(';')) {
            $index = $tokens->getNextMeaningfulToken($index);
            $content .= $tokens[$index]->getContent();
        }
        $content = \ltrim($content, '(');
        $content = \rtrim($content, ');');
        return 'null' === \strtolower($content);
    }
    /**
     * Is the return within a function with a non-void or nullable return type?
     *
     * @param int $returnIndex Current return token index
     *
     * @return bool
     */
    private function isStrictOrNullableReturnTypeFunction(\PhpCsFixer\Tokenizer\Tokens $tokens, $returnIndex)
    {
        $functionIndex = $returnIndex;
        do {
            $functionIndex = $tokens->getPrevTokenOfKind($functionIndex, [[\T_FUNCTION]]);
            if (null === $functionIndex) {
                return \false;
            }
            $openingCurlyBraceIndex = $tokens->getNextTokenOfKind($functionIndex, ['{']);
            $closingCurlyBraceIndex = $tokens->findBlockEnd(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_CURLY_BRACE, $openingCurlyBraceIndex);
        } while ($closingCurlyBraceIndex < $returnIndex);
        $possibleVoidIndex = $tokens->getPrevMeaningfulToken($openingCurlyBraceIndex);
        $isStrictReturnType = $tokens[$possibleVoidIndex]->isGivenKind(\T_STRING) && 'void' !== $tokens[$possibleVoidIndex]->getContent();
        $nullableTypeIndex = $tokens->getNextTokenOfKind($functionIndex, [[\PhpCsFixer\Tokenizer\CT::T_NULLABLE_TYPE]]);
        $isNullableReturnType = null !== $nullableTypeIndex && $nullableTypeIndex < $openingCurlyBraceIndex;
        return $isStrictReturnType || $isNullableReturnType;
    }
    /**
     * Should we clear the specific token?
     *
     * If the token is a comment, or is whitespace that is immediately before a
     * comment, then we'll leave it alone.
     *
     * @param int $index
     *
     * @return bool
     */
    private function shouldClearToken(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        $token = $tokens[$index];
        return !$token->isComment() && !($token->isWhitespace() && $tokens[$index + 1]->isComment());
    }
}
