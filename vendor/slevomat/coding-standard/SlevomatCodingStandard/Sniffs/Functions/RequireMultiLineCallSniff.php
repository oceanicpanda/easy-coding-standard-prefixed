<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Helpers\FixerHelper;
use SlevomatCodingStandard\Helpers\IndentationHelper;
use SlevomatCodingStandard\Helpers\SniffSettingsHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function array_unique;
use function count;
use function in_array;
use function ltrim;
use function sprintf;
use function strlen;
use function trim;
use const _PhpScoper0d0ee1ba46d4\T_CLOSE_PARENTHESIS;
use const _PhpScoper0d0ee1ba46d4\T_CLOSE_SHORT_ARRAY;
use const _PhpScoper0d0ee1ba46d4\T_COMMA;
use const T_DOUBLE_COLON;
use const T_NEW;
use const T_OBJECT_OPERATOR;
use const _PhpScoper0d0ee1ba46d4\T_OPEN_PARENTHESIS;
use const _PhpScoper0d0ee1ba46d4\T_OPEN_SHORT_ARRAY;
class RequireMultiLineCallSniff extends \SlevomatCodingStandard\Sniffs\Functions\AbstractLineCall
{
    public const CODE_REQUIRED_MULTI_LINE_CALL = 'RequiredMultiLineCall';
    /** @var int */
    public $minLineLength = 121;
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $stringPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $stringPointer) : void
    {
        if (!$this->isCall($phpcsFile, $stringPointer)) {
            return;
        }
        $tokens = $phpcsFile->getTokens();
        $parenthesisOpenerPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $stringPointer + 1);
        $parenthesisCloserPointer = $tokens[$parenthesisOpenerPointer]['parenthesis_closer'];
        // No parameters
        $effectivePointerAfterParenthesisOpener = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $parenthesisOpenerPointer + 1);
        if ($effectivePointerAfterParenthesisOpener === $parenthesisCloserPointer) {
            return;
        }
        $parametersPointers = [\SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $parenthesisOpenerPointer + 1)];
        $level = 0;
        $pointers = \SlevomatCodingStandard\Helpers\TokenHelper::findNextAll($phpcsFile, [\T_COMMA, \T_OPEN_PARENTHESIS, \T_CLOSE_PARENTHESIS, \T_OPEN_SHORT_ARRAY, \T_CLOSE_SHORT_ARRAY], $parenthesisOpenerPointer + 1, $parenthesisCloserPointer);
        foreach ($pointers as $pointer) {
            if (\in_array($tokens[$pointer]['code'], [\T_OPEN_PARENTHESIS, \T_OPEN_SHORT_ARRAY], \true)) {
                $level++;
                continue;
            }
            if (\in_array($tokens[$pointer]['code'], [\T_CLOSE_PARENTHESIS, \T_CLOSE_SHORT_ARRAY], \true)) {
                $level--;
                continue;
            }
            if ($level !== 0) {
                continue;
            }
            $parameterPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $pointer + 1, $parenthesisCloserPointer);
            if ($parameterPointer !== null) {
                $parametersPointers[] = $parameterPointer;
            }
        }
        $lines = [$tokens[$parenthesisOpenerPointer]['line'], $tokens[$parenthesisCloserPointer]['line']];
        foreach ($parametersPointers as $parameterPointer) {
            $lines[] = $tokens[$parameterPointer]['line'];
        }
        // Each parameter on its line
        if (\count(\array_unique($lines)) - 2 >= \count($parametersPointers)) {
            return;
        }
        if ($this->shouldBeSkipped($phpcsFile, $stringPointer, $parenthesisCloserPointer)) {
            return;
        }
        $lineStart = $this->getLineStart($phpcsFile, $parenthesisOpenerPointer);
        if ($tokens[$parenthesisCloserPointer]['line'] === $tokens[$stringPointer]['line']) {
            $call = $this->getCall($phpcsFile, $parenthesisOpenerPointer, $parenthesisCloserPointer);
            $lineEnd = $this->getLineEnd($phpcsFile, $parenthesisCloserPointer);
            $lineLength = \strlen($lineStart . $call . $lineEnd);
        } else {
            $lineEnd = $this->getLineEnd($phpcsFile, $parenthesisOpenerPointer);
            $lineLength = \strlen($lineStart . $lineEnd);
        }
        $firstNonWhitespaceOnLine = \SlevomatCodingStandard\Helpers\TokenHelper::findFirstNonWhitespaceOnLine($phpcsFile, $stringPointer);
        $indentation = \SlevomatCodingStandard\Helpers\IndentationHelper::getIndentation($phpcsFile, $firstNonWhitespaceOnLine);
        $oneIndentation = \SlevomatCodingStandard\Helpers\IndentationHelper::getOneIndentationLevel($indentation);
        if (!$this->shouldReportError($lineLength, $lineStart, $lineEnd, \count($parametersPointers), \strlen(\SlevomatCodingStandard\Helpers\IndentationHelper::convertTabsToSpaces($phpcsFile, $oneIndentation)))) {
            return;
        }
        $previousPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousEffective($phpcsFile, $stringPointer - 1);
        $name = \ltrim($tokens[$stringPointer]['content'], '\\');
        if (\in_array($tokens[$previousPointer]['code'], [\T_OBJECT_OPERATOR, \T_DOUBLE_COLON], \true)) {
            $error = \sprintf('Call of method %s() should be splitted to more lines.', $name);
        } elseif ($tokens[$previousPointer]['code'] === \T_NEW) {
            $error = 'Constructor call should be splitted to more lines.';
        } else {
            $error = \sprintf('Call of function %s() should be splitted to more lines.', $name);
        }
        $fix = $phpcsFile->addFixableError($error, $stringPointer, self::CODE_REQUIRED_MULTI_LINE_CALL);
        if (!$fix) {
            return;
        }
        $parametersIndentation = \SlevomatCodingStandard\Helpers\IndentationHelper::addIndentation($indentation);
        $phpcsFile->fixer->beginChangeset();
        for ($i = $parenthesisOpenerPointer + 1; $i < $parenthesisCloserPointer; $i++) {
            if (\in_array($i, $parametersPointers, \true)) {
                \SlevomatCodingStandard\Helpers\FixerHelper::cleanWhitespaceBefore($phpcsFile, $i);
                $phpcsFile->fixer->addContentBefore($i, $phpcsFile->eolChar . $parametersIndentation);
            } elseif ($tokens[$i]['content'] === $phpcsFile->eolChar) {
                $phpcsFile->fixer->addContent($i, $oneIndentation);
            } else {
                // Create conflict so inner calls are fixed in next loop
                $phpcsFile->fixer->replaceToken($i, $tokens[$i]['content']);
            }
        }
        $phpcsFile->fixer->addContentBefore($parenthesisCloserPointer, $phpcsFile->eolChar . $indentation);
        $phpcsFile->fixer->endChangeset();
    }
    private function shouldBeSkipped(\PHP_CodeSniffer\Files\File $phpcsFile, int $stringPointer, int $parenthesisCloserPointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        $firstPointerOnLine = \SlevomatCodingStandard\Helpers\TokenHelper::findFirstNonWhitespaceOnLine($phpcsFile, $stringPointer);
        $stringPointersBefore = \SlevomatCodingStandard\Helpers\TokenHelper::findNextAll($phpcsFile, \SlevomatCodingStandard\Helpers\TokenHelper::getOnlyNameTokenCodes(), $firstPointerOnLine, $stringPointer);
        foreach ($stringPointersBefore as $stringPointerBefore) {
            $pointerAfterStringPointerBefore = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $stringPointerBefore + 1);
            if ($tokens[$pointerAfterStringPointerBefore]['code'] === \T_OPEN_PARENTHESIS && $tokens[$pointerAfterStringPointerBefore]['parenthesis_closer'] > $stringPointer) {
                return \true;
            }
        }
        $lastPointerOnLine = \SlevomatCodingStandard\Helpers\TokenHelper::findLastTokenOnLine($phpcsFile, $parenthesisCloserPointer);
        $stringPointersAfter = \SlevomatCodingStandard\Helpers\TokenHelper::findNextAll($phpcsFile, \SlevomatCodingStandard\Helpers\TokenHelper::getOnlyNameTokenCodes(), $parenthesisCloserPointer + 1, $lastPointerOnLine + 1);
        foreach ($stringPointersAfter as $stringPointerAfter) {
            $pointerAfterStringPointerAfter = \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $stringPointerAfter + 1);
            if ($pointerAfterStringPointerAfter !== null && $tokens[$pointerAfterStringPointerAfter]['code'] === \T_OPEN_PARENTHESIS && $tokens[$tokens[$pointerAfterStringPointerAfter]['parenthesis_closer']]['line'] === $tokens[$stringPointer]['line'] && $tokens[$pointerAfterStringPointerAfter]['parenthesis_closer'] !== \SlevomatCodingStandard\Helpers\TokenHelper::findNextEffective($phpcsFile, $pointerAfterStringPointerAfter + 1)) {
                return \true;
            }
        }
        return \false;
    }
    private function shouldReportError(int $lineLength, string $lineStart, string $lineEnd, int $parametersCount, int $indentationLength) : bool
    {
        $minLineLength = \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->minLineLength);
        if ($minLineLength === 0) {
            return \true;
        }
        if ($lineLength < $minLineLength) {
            return \false;
        }
        if ($parametersCount > 1) {
            return \true;
        }
        return \strlen(\trim($lineStart) . \trim($lineEnd)) > $indentationLength;
    }
}