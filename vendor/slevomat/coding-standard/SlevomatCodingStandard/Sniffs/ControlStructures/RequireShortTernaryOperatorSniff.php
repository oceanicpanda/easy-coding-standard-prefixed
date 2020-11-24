<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function in_array;
use function sprintf;
use function strlen;
use function trim;
use const _PhpScoperd675aaf00c76\T_BOOLEAN_NOT;
use const _PhpScoperd675aaf00c76\T_CLOSE_PARENTHESIS;
use const _PhpScoperd675aaf00c76\T_CLOSE_SHORT_ARRAY;
use const _PhpScoperd675aaf00c76\T_CLOSE_SQUARE_BRACKET;
use const T_CLOSE_TAG;
use const T_COALESCE;
use const _PhpScoperd675aaf00c76\T_COMMA;
use const T_DOUBLE_ARROW;
use const _PhpScoperd675aaf00c76\T_INLINE_ELSE;
use const _PhpScoperd675aaf00c76\T_INLINE_THEN;
use const _PhpScoperd675aaf00c76\T_SEMICOLON;
class RequireShortTernaryOperatorSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_REQUIRED_SHORT_TERNARY_OPERATOR = 'RequiredShortTernaryOperator';
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_INLINE_THEN];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $inlineThenPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $inlineThenPointer) : void
    {
        $tokens = $phpcsFile->getTokens();
        $nextPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $inlineThenPointer + 1);
        if ($tokens[$nextPointer]['code'] === \T_INLINE_ELSE) {
            return;
        }
        $inlineElsePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_INLINE_ELSE, $inlineThenPointer + 1);
        $inlineElseEndPointer = $inlineElsePointer + 1;
        while (\true) {
            if (\in_array($tokens[$inlineElseEndPointer]['code'], [\T_SEMICOLON, \T_COMMA, \T_DOUBLE_ARROW, \T_CLOSE_SHORT_ARRAY, \T_COALESCE, \T_CLOSE_TAG], \true)) {
                break;
            }
            if ($tokens[$inlineElseEndPointer]['code'] === \T_CLOSE_PARENTHESIS && $tokens[$inlineElseEndPointer]['parenthesis_opener'] < $inlineElsePointer) {
                break;
            }
            if ($tokens[$inlineElseEndPointer]['code'] === \T_CLOSE_SQUARE_BRACKET && $tokens[$inlineElseEndPointer]['bracket_opener'] < $inlineElsePointer) {
                break;
            }
            $inlineElseEndPointer++;
        }
        $findConditionStartPointer = static function (int $conditionEndPointer, string $contentToFind) use($tokens) : int {
            $content = $tokens[$conditionEndPointer]['content'];
            $conditionStartPointer = $conditionEndPointer;
            while (\strlen($content) < \strlen($contentToFind) && isset($tokens[$conditionStartPointer - 1])) {
                $conditionStartPointer--;
                $content = $tokens[$conditionStartPointer]['content'] . $content;
            }
            return $conditionStartPointer;
        };
        $thenContent = \trim(\SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $inlineThenPointer + 1, $inlineElsePointer - 1));
        $elseContent = \trim(\SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $inlineElsePointer + 1, $inlineElseEndPointer - 1));
        $conditionEndPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousEffective($phpcsFile, $inlineThenPointer - 1);
        $conditionStartPointerBasedOnThenContent = $findConditionStartPointer($conditionEndPointer, $thenContent);
        $conditionStartPointerBasedOnElseContent = $findConditionStartPointer($conditionEndPointer, $elseContent);
        if ($thenContent === \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $conditionStartPointerBasedOnThenContent, $conditionEndPointer)) {
            $conditionStartPointer = $conditionStartPointerBasedOnThenContent;
        } elseif ($elseContent === \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $conditionStartPointerBasedOnElseContent, $conditionEndPointer)) {
            $conditionStartPointer = $conditionStartPointerBasedOnElseContent;
        } else {
            return;
        }
        /** @var int $pointerBeforeCondition */
        $pointerBeforeCondition = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousEffective($phpcsFile, $conditionStartPointer - 1);
        if (\in_array($tokens[$pointerBeforeCondition]['code'], \PHP_CodeSniffer\Util\Tokens::$booleanOperators, \true)) {
            return;
        }
        if (\in_array($tokens[$pointerBeforeCondition]['code'], \PHP_CodeSniffer\Util\Tokens::$comparisonTokens, \true)) {
            // Yoda condition
            return;
        }
        $condition = \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $conditionStartPointer, $conditionEndPointer);
        if ($tokens[$pointerBeforeCondition]['code'] === \T_BOOLEAN_NOT) {
            if ($elseContent !== $condition) {
                return;
            }
        } else {
            if ($thenContent !== $condition) {
                return;
            }
        }
        $fix = $phpcsFile->addFixableError('Use short ternary operator.', $inlineThenPointer, self::CODE_REQUIRED_SHORT_TERNARY_OPERATOR);
        if (!$fix) {
            return;
        }
        $pointerBeforeInlineElseEnd = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousEffective($phpcsFile, $inlineElseEndPointer - 1);
        $phpcsFile->fixer->beginChangeset();
        if ($tokens[$pointerBeforeCondition]['code'] === \T_BOOLEAN_NOT) {
            for ($i = $pointerBeforeCondition; $i < $conditionStartPointer; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            for ($i = $inlineThenPointer + 1; $i <= $pointerBeforeInlineElseEnd; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            $phpcsFile->fixer->addContent($inlineThenPointer, \sprintf(': %s', $thenContent));
        } else {
            for ($i = $inlineThenPointer + 1; $i < $inlineElsePointer; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
        }
        $phpcsFile->fixer->endChangeset();
    }
}
