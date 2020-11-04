<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\CommentHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function array_key_exists;
use function preg_match;
use function preg_replace;
use function strlen;
use function substr;
use const T_COMMENT;
use const _PhpScoper48b5ec5b60cf\T_DOC_COMMENT_OPEN_TAG;
use const T_WHITESPACE;
class EmptyCommentSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{
    public const CODE_EMPTY_COMMENT = 'EmptyComment';
    /**
     * @return array<int, (int|string)>
     */
    public function register() : array
    {
        return [\T_DOC_COMMENT_OPEN_TAG, \T_COMMENT];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $commentStartPointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $commentStartPointer) : void
    {
        $commentEndPointer = \SlevomatCodingStandard\Helpers\CommentHelper::getCommentEndPointer($phpcsFile, $commentStartPointer);
        if ($commentEndPointer === null) {
            // Part of block comment
            return;
        }
        $commentContent = $this->getCommentContent($phpcsFile, $commentStartPointer, $commentEndPointer);
        $isLineComment = \SlevomatCodingStandard\Helpers\CommentHelper::isLineComment($phpcsFile, $commentStartPointer);
        $isEmpty = $this->isEmpty($commentContent, $isLineComment);
        if (!$isEmpty) {
            return;
        }
        if ($isLineComment && $this->isPartOfMultiLineInlineComments($phpcsFile, $commentStartPointer, $commentEndPointer)) {
            return;
        }
        $fix = $phpcsFile->addFixableError('Empty comment', $commentStartPointer, self::CODE_EMPTY_COMMENT);
        if (!$fix) {
            return;
        }
        $tokens = $phpcsFile->getTokens();
        /** @var int $pointerBeforeWhitespaceBeforeComment */
        $pointerBeforeWhitespaceBeforeComment = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousExcluding($phpcsFile, \T_WHITESPACE, $commentStartPointer - 1);
        $whitespaceBeforeComment = $pointerBeforeWhitespaceBeforeComment !== $commentStartPointer - 1 ? \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $pointerBeforeWhitespaceBeforeComment + 1, $commentStartPointer - 1) : '';
        $fixedWhitespaceBeforeComment = \preg_replace('~[ \\t]+$~', '', $whitespaceBeforeComment);
        $phpcsFile->fixer->beginChangeset();
        for ($i = $pointerBeforeWhitespaceBeforeComment + 1; $i < $commentStartPointer; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $phpcsFile->fixer->addContent($pointerBeforeWhitespaceBeforeComment, $fixedWhitespaceBeforeComment);
        for ($i = $commentStartPointer; $i <= $commentEndPointer; $i++) {
            $phpcsFile->fixer->replaceToken($i, '');
        }
        $whitespacePointerAfterComment = $commentEndPointer + 1;
        if ($tokens[$pointerBeforeWhitespaceBeforeComment]['line'] === $tokens[$commentStartPointer]['line']) {
            if (\substr($tokens[$commentEndPointer]['content'], -\strlen($phpcsFile->eolChar)) === $phpcsFile->eolChar) {
                $phpcsFile->fixer->addNewline($commentEndPointer);
            }
        } elseif (\array_key_exists($whitespacePointerAfterComment, $tokens) && $tokens[$whitespacePointerAfterComment]['code'] === \T_WHITESPACE) {
            $fixedWhitespaceAfterComment = \preg_replace('~^[ \\t]*' . $phpcsFile->eolChar . '~', '', $tokens[$whitespacePointerAfterComment]['content']);
            $phpcsFile->fixer->replaceToken($whitespacePointerAfterComment, $fixedWhitespaceAfterComment);
        }
        $phpcsFile->fixer->endChangeset();
    }
    private function isEmpty(string $comment, bool $isLineComment) : bool
    {
        return $isLineComment ? (bool) \preg_match('~^\\s*$~', $comment) : (bool) \preg_match('~^[\\s\\*]*$~', $comment);
    }
    private function getCommentContent(\PHP_CodeSniffer\Files\File $phpcsFile, int $commentStartPointer, int $commentEndPointer) : string
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$commentStartPointer]['code'] === \T_DOC_COMMENT_OPEN_TAG) {
            return \SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $commentStartPointer + 1, $commentEndPointer - 1);
        }
        if (\preg_match('~^(?://|#)(.*)~', $tokens[$commentStartPointer]['content'], $matches) !== 0) {
            return $matches[1];
        }
        return \substr(\SlevomatCodingStandard\Helpers\TokenHelper::getContent($phpcsFile, $commentStartPointer, $commentEndPointer), 2, -2);
    }
    private function isPartOfMultiLineInlineComments(\PHP_CodeSniffer\Files\File $phpcsFile, int $commentStartPointer, int $commentEndPointer) : bool
    {
        if (!$this->isNonEmptyLineCommentBefore($phpcsFile, $commentStartPointer)) {
            return \false;
        }
        return $this->isNonEmptyLineCommentAfter($phpcsFile, $commentEndPointer);
    }
    private function isNonEmptyLineCommentBefore(\PHP_CodeSniffer\Files\File $phpcsFile, int $commentStartPointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        /** @var int $beforeCommentStartPointer */
        $beforeCommentStartPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousExcluding($phpcsFile, \T_WHITESPACE, $commentStartPointer - 1);
        if ($tokens[$beforeCommentStartPointer]['code'] !== \T_COMMENT) {
            return \false;
        }
        if (!\SlevomatCodingStandard\Helpers\CommentHelper::isLineComment($phpcsFile, $beforeCommentStartPointer)) {
            return \false;
        }
        if ($tokens[$beforeCommentStartPointer]['line'] + 1 !== $tokens[$commentStartPointer]['line']) {
            return \false;
        }
        /** @var int $beforeCommentEndPointer */
        $beforeCommentEndPointer = \SlevomatCodingStandard\Helpers\CommentHelper::getCommentEndPointer($phpcsFile, $beforeCommentStartPointer);
        if (!$this->isEmpty($this->getCommentContent($phpcsFile, $beforeCommentStartPointer, $beforeCommentEndPointer), \true)) {
            return \true;
        }
        return $this->isNonEmptyLineCommentBefore($phpcsFile, $beforeCommentStartPointer);
    }
    private function isNonEmptyLineCommentAfter(\PHP_CodeSniffer\Files\File $phpcsFile, int $commentEndPointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        $afterCommentStartPointer = \SlevomatCodingStandard\Helpers\TokenHelper::findNextExcluding($phpcsFile, \T_WHITESPACE, $commentEndPointer + 1);
        if ($afterCommentStartPointer === null) {
            return \false;
        }
        if ($tokens[$afterCommentStartPointer]['code'] !== \T_COMMENT) {
            return \false;
        }
        if (!\SlevomatCodingStandard\Helpers\CommentHelper::isLineComment($phpcsFile, $afterCommentStartPointer)) {
            return \false;
        }
        if ($tokens[$commentEndPointer]['line'] + 1 !== $tokens[$afterCommentStartPointer]['line']) {
            return \false;
        }
        /** @var int $afterCommentEndPointer */
        $afterCommentEndPointer = \SlevomatCodingStandard\Helpers\CommentHelper::getCommentEndPointer($phpcsFile, $afterCommentStartPointer);
        if (!$this->isEmpty($this->getCommentContent($phpcsFile, $afterCommentStartPointer, $afterCommentEndPointer), \true)) {
            return \true;
        }
        return $this->isNonEmptyLineCommentAfter($phpcsFile, $afterCommentEndPointer);
    }
}
