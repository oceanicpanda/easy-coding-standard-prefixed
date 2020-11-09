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
namespace PhpCsFixer\Fixer\Operator;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author ntzm
 */
final class StandardizeIncrementFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * @internal
     */
    const EXPRESSION_END_TOKENS = [';', ')', ']', ',', ':', [\PhpCsFixer\Tokenizer\CT::T_DYNAMIC_PROP_BRACE_CLOSE], [\PhpCsFixer\Tokenizer\CT::T_DYNAMIC_VAR_BRACE_CLOSE], [\T_CLOSE_TAG]];
    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Increment and decrement operators should be used if possible.', [new \PhpCsFixer\FixerDefinition\CodeSample("<?php\n\$i += 1;\n"), new \PhpCsFixer\FixerDefinition\CodeSample("<?php\n\$i -= 1;\n")]);
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        // Must be run before IncrementStyleFixer in case user wants to
        // post-increment instead
        return 1;
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_PLUS_EQUAL, \T_MINUS_EQUAL]);
    }
    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens)
    {
        for ($index = $tokens->count() - 1; $index > 0; --$index) {
            $expressionEnd = $tokens[$index];
            if (!$expressionEnd->equalsAny(self::EXPRESSION_END_TOKENS)) {
                continue;
            }
            $numberIndex = $tokens->getPrevMeaningfulToken($index);
            $number = $tokens[$numberIndex];
            if (!$number->isGivenKind(\T_LNUMBER) || '1' !== $number->getContent()) {
                continue;
            }
            $operatorIndex = $tokens->getPrevMeaningfulToken($numberIndex);
            $operator = $tokens[$operatorIndex];
            if (!$operator->isGivenKind([\T_PLUS_EQUAL, \T_MINUS_EQUAL])) {
                continue;
            }
            $startIndex = $this->findStart($tokens, $tokens->getPrevMeaningfulToken($operatorIndex));
            $this->clearRangeLeaveComments($tokens, $tokens->getPrevMeaningfulToken($operatorIndex) + 1, $numberIndex);
            $tokens->insertAt($startIndex, new \PhpCsFixer\Tokenizer\Token($operator->isGivenKind(\T_PLUS_EQUAL) ? [\T_INC, '++'] : [\T_DEC, '--']));
        }
    }
    /**
     * Find the start of a reference.
     *
     * @param int $index
     *
     * @return int
     */
    private function findStart(\PhpCsFixer\Tokenizer\Tokens $tokens, $index)
    {
        while (!$tokens[$index]->equalsAny(['$', [\T_VARIABLE]])) {
            if ($tokens[$index]->equals(']')) {
                $index = $tokens->findBlockStart(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_INDEX_SQUARE_BRACE, $index);
            } elseif ($tokens[$index]->isGivenKind(\PhpCsFixer\Tokenizer\CT::T_DYNAMIC_PROP_BRACE_CLOSE)) {
                $index = $tokens->findBlockStart(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_DYNAMIC_PROP_BRACE, $index);
            } elseif ($tokens[$index]->isGivenKind(\PhpCsFixer\Tokenizer\CT::T_DYNAMIC_VAR_BRACE_CLOSE)) {
                $index = $tokens->findBlockStart(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_DYNAMIC_VAR_BRACE, $index);
            } elseif ($tokens[$index]->isGivenKind(\PhpCsFixer\Tokenizer\CT::T_ARRAY_INDEX_CURLY_BRACE_CLOSE)) {
                $index = $tokens->findBlockStart(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_ARRAY_INDEX_CURLY_BRACE, $index);
            } else {
                $index = $tokens->getPrevMeaningfulToken($index);
            }
        }
        while ($tokens[$tokens->getPrevMeaningfulToken($index)]->equals('$')) {
            $index = $tokens->getPrevMeaningfulToken($index);
        }
        if ($tokens[$tokens->getPrevMeaningfulToken($index)]->isGivenKind(\T_OBJECT_OPERATOR)) {
            return $this->findStart($tokens, $tokens->getPrevMeaningfulToken($index));
        }
        return $index;
    }
    /**
     * Clear tokens in the given range unless they are comments.
     *
     * @param int $indexStart
     * @param int $indexEnd
     */
    private function clearRangeLeaveComments(\PhpCsFixer\Tokenizer\Tokens $tokens, $indexStart, $indexEnd)
    {
        for ($i = $indexStart; $i <= $indexEnd; ++$i) {
            $token = $tokens[$i];
            if ($token->isComment()) {
                continue;
            }
            if ($token->isWhitespace("\n\r")) {
                continue;
            }
            $tokens->clearAt($i);
        }
    }
}