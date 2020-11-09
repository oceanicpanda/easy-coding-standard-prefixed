<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\IdentificatorHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function array_key_exists;
use function sprintf;
use const _PhpScoper0d0ee1ba46d4\T_BITWISE_AND;
use const T_ELSE;
use const _PhpScoper0d0ee1ba46d4\T_EQUAL;
use const T_IF;
use const _PhpScoper0d0ee1ba46d4\T_INLINE_THEN;
use const T_LOGICAL_AND;
use const T_LOGICAL_OR;
use const T_LOGICAL_XOR;
use const T_RETURN;
use const _PhpScoper0d0ee1ba46d4\T_SEMICOLON;
use const T_WHITESPACE;
class RequireTernaryOperatorSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_TERNARY_OPERATOR_NOT_USED = 'TernaryOperatorNotUsed';
    /** @var bool */
    public $ignoreMultiLine = \false;
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_IF];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $ifPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $ifPointer) : void
    {
        $tokens = $phpcsFile->getTokens();
        if (!\array_key_exists('scope_closer', $tokens[$ifPointer])) {
            // If without curly braces is not supported.
            return;
        }
        $elsePointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $tokens[$ifPointer]['scope_closer'] + 1);
        if ($elsePointer === null || $tokens[$elsePointer]['code'] !== \T_ELSE) {
            return;
        }
        if (!\array_key_exists('scope_closer', $tokens[$elsePointer])) {
            // Else without curly braces is not supported.
            return;
        }
        if (!$this->isCompatibleScope($phpcsFile, $tokens[$ifPointer]['scope_opener'], $tokens[$ifPointer]['scope_closer']) || !$this->isCompatibleScope($phpcsFile, $tokens[$elsePointer]['scope_opener'], $tokens[$elsePointer]['scope_closer'])) {
            return;
        }
        /** @var int $firstPointerInIf */
        $firstPointerInIf = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $tokens[$ifPointer]['scope_opener'] + 1);
        /** @var int $firstPointerInElse */
        $firstPointerInElse = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $tokens[$elsePointer]['scope_opener'] + 1);
        if ($tokens[$firstPointerInIf]['code'] === \T_RETURN && $tokens[$firstPointerInElse]['code'] === \T_RETURN) {
            $this->checkIfWithReturns($phpcsFile, $ifPointer, $elsePointer, $firstPointerInIf, $firstPointerInElse);
            return;
        }
        $this->checkIfWithAssignments($phpcsFile, $ifPointer, $elsePointer, $firstPointerInIf, $firstPointerInElse);
    }
    private function checkIfWithReturns(\PHP_CodeSniffer\Files\File $phpcsFile, int $ifPointer, int $elsePointer, int $returnInIf, int $returnInElse) : void
    {
        $ifContainsComment = $this->containsComment($phpcsFile, $ifPointer);
        $elseContainsComment = $this->containsComment($phpcsFile, $elsePointer);
        $conditionContainsLogicalOperators = $this->containsLogicalOperators($phpcsFile, $ifPointer);
        $errorParameters = ['Use ternary operator.', $ifPointer, self::CODE_TERNARY_OPERATOR_NOT_USED];
        if ($ifContainsComment || $elseContainsComment || $conditionContainsLogicalOperators) {
            $phpcsFile->addError(...$errorParameters);
            return;
        }
        $fix = $phpcsFile->addFixableError(...$errorParameters);
        if (!$fix) {
            return;
        }
        $tokens = $phpcsFile->getTokens();
        $pointerAfterReturnInIf = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $returnInIf + 1);
        /** @var int $semicolonAfterReturnInIf */
        $semicolonAfterReturnInIf = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $pointerAfterReturnInIf + 1);
        $pointerAfterReturnInElse = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $returnInElse + 1);
        $semicolonAfterReturnInElse = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $pointerAfterReturnInElse + 1);
        $phpcsFile->fixer->beginChangeset();
        $phpcsFile->fixer->replaceToken($ifPointer, 'return');
        $phpcsFile->fixer->replaceToken($tokens[$ifPointer]['parenthesis_opener'], '');
        $phpcsFile->fixer->replaceToken($tokens[$ifPointer]['parenthesis_closer'], ' ? ');
        for ($i = $tokens[$ifPointer]['parenthesis_closer'] + 1; $i < $pointerAfterReturnInIf; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->replaceToken($semicolonAfterReturnInIf, ' : ');
        for ($i = $semicolonAfterReturnInIf + 1; $i < $pointerAfterReturnInElse; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        for ($i = $semicolonAfterReturnInElse + 1; $i <= $tokens[$elsePointer]['scope_closer']; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->endChangeset();
    }
    private function checkIfWithAssignments(\PHP_CodeSniffer\Files\File $phpcsFile, int $ifPointer, int $elsePointer, int $firstPointerInIf, int $firstPointerInElse) : void
    {
        $tokens = $phpcsFile->getTokens();
        $identificatorEndPointerInIf = \SlevomatCodingStandard\Helpers\IdentificatorHelper::findEndPointer($phpcsFile, $firstPointerInIf);
        $identificatorEndPointerInElse = \SlevomatCodingStandard\Helpers\IdentificatorHelper::findEndPointer($phpcsFile, $firstPointerInElse);
        if ($identificatorEndPointerInIf === null || $identificatorEndPointerInElse === null) {
            return;
        }
        $identificatorInIf = \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $firstPointerInIf, $identificatorEndPointerInIf);
        $identificatorInElse = \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $firstPointerInElse, $identificatorEndPointerInElse);
        if ($identificatorInIf !== $identificatorInElse) {
            return;
        }
        $assignmentPointerInIf = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $identificatorEndPointerInIf + 1);
        $assignmentPointerInElse = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $identificatorEndPointerInElse + 1);
        if ($tokens[$assignmentPointerInIf]['code'] !== \T_EQUAL || $tokens[$assignmentPointerInElse]['code'] !== \T_EQUAL) {
            return;
        }
        $pointerAfterAssignmentInIf = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $assignmentPointerInIf + 1);
        $pointerAfterAssignmentInElse = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $assignmentPointerInElse + 1);
        if ($tokens[$pointerAfterAssignmentInIf]['code'] === \T_BITWISE_AND || $tokens[$pointerAfterAssignmentInElse]['code'] === \T_BITWISE_AND) {
            return;
        }
        $ifContainsComment = $this->containsComment($phpcsFile, $ifPointer);
        $elseContainsComment = $this->containsComment($phpcsFile, $elsePointer);
        $conditionContainsLogicalOperators = $this->containsLogicalOperators($phpcsFile, $ifPointer);
        $errorParameters = ['Use ternary operator.', $ifPointer, self::CODE_TERNARY_OPERATOR_NOT_USED];
        if ($ifContainsComment || $elseContainsComment || $conditionContainsLogicalOperators) {
            $phpcsFile->addError(...$errorParameters);
            return;
        }
        $fix = $phpcsFile->addFixableError(...$errorParameters);
        if (!$fix) {
            return;
        }
        /** @var int $semicolonAfterAssignmentInIf */
        $semicolonAfterAssignmentInIf = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $pointerAfterAssignmentInIf + 1);
        $semicolonAfterAssignmentInElse = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $pointerAfterAssignmentInElse + 1);
        $phpcsFile->fixer->beginChangeset();
        $phpcsFile->fixer->replaceToken($ifPointer, \sprintf('%s = ', $identificatorInIf));
        for ($i = $ifPointer + 1; $i <= $tokens[$ifPointer]['parenthesis_opener']; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->replaceToken($tokens[$ifPointer]['parenthesis_closer'], ' ? ');
        for ($i = $tokens[$ifPointer]['parenthesis_closer'] + 1; $i < $pointerAfterAssignmentInIf; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->replaceToken($semicolonAfterAssignmentInIf, ' : ');
        for ($i = $semicolonAfterAssignmentInIf + 1; $i < $pointerAfterAssignmentInElse; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        for ($i = $semicolonAfterAssignmentInElse + 1; $i <= $tokens[$elsePointer]['scope_closer']; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->endChangeset();
    }
    private function isCompatibleScope(\PHP_CodeSniffer\Files\File $phpcsFile, int $scopeOpenerPointer, int $scopeCloserPointer) : bool
    {
        $semicolonPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_SEMICOLON, $scopeOpenerPointer + 1, $scopeCloserPointer);
        if ($semicolonPointer === null) {
            return \false;
        }
        if (\SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \T_INLINE_THEN, $scopeOpenerPointer + 1, $semicolonPointer) !== null) {
            return \false;
        }
        if ($this->ignoreMultiLine) {
            $firstContentPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $scopeOpenerPointer + 1);
            if (\SlevomatCodingStandard\Helpers\TokenHelper::findNextContent($phpcsFile, \T_WHITESPACE, $phpcsFile->eolChar, $firstContentPointer + 1, $semicolonPointer) !== null) {
                return \false;
            }
        }
        $pointerAfterSemicolon = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $semicolonPointer + 1);
        return $pointerAfterSemicolon === $scopeCloserPointer;
    }
    private function containsComment(\PHP_CodeSniffer\Files\File $phpcsFile, int $scopeOwnerPointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        return \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, \PHP_CodeSniffer\Util\Tokens::$commentTokens, $tokens[$scopeOwnerPointer]['scope_opener'] + 1, $tokens[$scopeOwnerPointer]['scope_closer']) !== null;
    }
    private function containsLogicalOperators(\PHP_CodeSniffer\Files\File $phpcsFile, int $scopeOwnerPointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        return \SlevomatCodingStandard\Helpers\TokenHelper::findNext($phpcsFile, [\T_LOGICAL_AND, \T_LOGICAL_OR, \T_LOGICAL_XOR], $tokens[$scopeOwnerPointer]['parenthesis_opener'] + 1, $tokens[$scopeOwnerPointer]['parenthesis_closer']) !== null;
    }
}