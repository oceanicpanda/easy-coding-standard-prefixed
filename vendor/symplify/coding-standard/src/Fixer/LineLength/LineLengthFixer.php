<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Fixer\LineLength;

use _PhpScoper0d0ee1ba46d4\Nette\Utils\Strings;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Symplify\CodingStandard\Fixer\AbstractSymplifyFixer;
use Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\BlockFinder;
use Symplify\CodingStandard\TokenRunner\Transformer\FixerTransformer\LineLengthTransformer;
use Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo;
use Throwable;
/**
 * @see \Symplify\CodingStandard\Tests\Fixer\LineLength\LineLengthFixer\LineLengthFixerTest
 * @see \Symplify\CodingStandard\Tests\Fixer\LineLength\LineLengthFixer\ConfiguredLineLengthFixerTest
 */
final class LineLengthFixer extends \Symplify\CodingStandard\Fixer\AbstractSymplifyFixer implements \PhpCsFixer\Fixer\ConfigurableFixerInterface
{
    /**
     * @api
     * @var string
     */
    public const LINE_LENGTH = 'line_length';
    /**
     * @api
     * @var string
     */
    public const BREAK_LONG_LINES = 'break_long_lines';
    /**
     * @api
     * @var string
     */
    public const INLINE_SHORT_LINES = 'inline_short_lines';
    /**
     * @var int
     */
    private $lineLength = 120;
    /**
     * @var bool
     */
    private $breakLongLines = \true;
    /**
     * @var bool
     */
    private $inlineShortLines = \true;
    /**
     * @var LineLengthTransformer
     */
    private $lineLengthTransformer;
    /**
     * @var BlockFinder
     */
    private $blockFinder;
    public function __construct(\Symplify\CodingStandard\TokenRunner\Transformer\FixerTransformer\LineLengthTransformer $lineLengthTransformer, \Symplify\CodingStandard\TokenRunner\Analyzer\FixerAnalyzer\BlockFinder $blockFinder)
    {
        $this->lineLengthTransformer = $lineLengthTransformer;
        $this->blockFinder = $blockFinder;
    }
    public function getDefinition() : \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Array items, method parameters, method call arguments, new arguments should be on same/standalone line to fit line length.', []);
    }
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens) : bool
    {
        return $tokens->isAnyTokenKindsFound([
            // "["
            \T_ARRAY,
            // "array"();
            \PhpCsFixer\Tokenizer\CT::T_ARRAY_SQUARE_BRACE_OPEN,
            '(',
            ')',
            // "function"
            \T_FUNCTION,
            // "use" (...)
            \PhpCsFixer\Tokenizer\CT::T_USE_LAMBDA,
            // "new"
            \T_NEW,
        ]);
    }
    public function fix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens) : void
    {
        // function arguments, function call parameters, lambda use()
        for ($position = \count($tokens) - 1; $position >= 0; --$position) {
            /** @var Token $token */
            $token = $tokens[$position];
            if ($token->equals(')')) {
                $this->processMethodCall($tokens, $position);
                continue;
            }
            // opener
            if ($token->isGivenKind([\T_FUNCTION, \PhpCsFixer\Tokenizer\CT::T_USE_LAMBDA, \T_NEW])) {
                $this->processFunctionOrArray($tokens, $position);
                continue;
            }
            // closer
            if ($token->isGivenKind(\PhpCsFixer\Tokenizer\CT::T_ARRAY_SQUARE_BRACE_CLOSE) || $token->equals(')') && $token->isArray()) {
                $this->processFunctionOrArray($tokens, $position);
            }
        }
    }
    public function getPriority() : int
    {
        return $this->getPriorityBefore(\PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer::class);
    }
    /**
     * @param mixed[]|null $configuration
     */
    public function configure(?array $configuration = null) : void
    {
        $this->lineLength = $configuration[self::LINE_LENGTH] ?? 120;
        $this->breakLongLines = $configuration[self::BREAK_LONG_LINES] ?? \true;
        $this->inlineShortLines = $configuration[self::INLINE_SHORT_LINES] ?? \true;
    }
    private function processMethodCall(\PhpCsFixer\Tokenizer\Tokens $tokens, int $position) : void
    {
        $methodNamePosition = $this->matchNamePositionForEndOfFunctionCall($tokens, $position);
        if ($methodNamePosition === null) {
            return;
        }
        $blockInfo = $this->blockFinder->findInTokensByPositionAndContent($tokens, $methodNamePosition, '(');
        if ($blockInfo === null) {
            return;
        }
        // has comments => dangerous to change: https://github.com/symplify/symplify/issues/973
        $comments = $tokens->findGivenKind(\T_COMMENT, $blockInfo->getStart(), $blockInfo->getEnd());
        if ($comments !== []) {
            return;
        }
        $this->lineLengthTransformer->fixStartPositionToEndPosition($blockInfo, $tokens, $this->lineLength, $this->breakLongLines, $this->inlineShortLines);
    }
    private function processFunctionOrArray(\PhpCsFixer\Tokenizer\Tokens $tokens, int $position) : void
    {
        $blockInfo = $this->blockFinder->findInTokensByEdge($tokens, $position);
        if ($blockInfo === null) {
            return;
        }
        if ($this->shouldSkip($tokens, $blockInfo)) {
            return;
        }
        $this->lineLengthTransformer->fixStartPositionToEndPosition($blockInfo, $tokens, $this->lineLength, $this->breakLongLines, $this->inlineShortLines);
    }
    /**
     * We go through tokens from down to up,
     * so we need to find ")" and then the start of function
     */
    private function matchNamePositionForEndOfFunctionCall(\PhpCsFixer\Tokenizer\Tokens $tokens, int $position) : ?int
    {
        try {
            $blockStart = $tokens->findBlockStart(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $position);
        } catch (\Throwable $throwable) {
            // not a block start
            return null;
        }
        $previousTokenPosition = $blockStart - 1;
        /** @var Token $possibleMethodNameToken */
        $possibleMethodNameToken = $tokens[$previousTokenPosition];
        // not a "methodCall()"
        if (!$possibleMethodNameToken->isGivenKind(\T_STRING)) {
            return null;
        }
        // starts with small letter?
        $content = $possibleMethodNameToken->getContent();
        if (!\ctype_lower($content[0])) {
            return null;
        }
        // is "someCall()"? we don't care, there are no arguments
        if ($tokens[$blockStart + 1]->equals(')')) {
            return null;
        }
        return $previousTokenPosition;
    }
    private function shouldSkip(\PhpCsFixer\Tokenizer\Tokens $tokens, \Symplify\CodingStandard\TokenRunner\ValueObject\BlockInfo $blockInfo) : bool
    {
        // no items inside => skip
        if ($blockInfo->getEnd() - $blockInfo->getStart() <= 1) {
            return \true;
        }
        // heredoc/nowdoc => skip
        $nextTokenPosition = $tokens->getNextMeaningfulToken($blockInfo->getStart());
        /** @var Token $nextToken */
        $nextToken = $tokens[$nextTokenPosition];
        if (\_PhpScoper0d0ee1ba46d4\Nette\Utils\Strings::contains($nextToken->getContent(), '<<<')) {
            return \true;
        }
        // is array with indexed values "=>"
        $doubleArrowTokens = $tokens->findGivenKind(\T_DOUBLE_ARROW, $blockInfo->getStart(), $blockInfo->getEnd());
        if ($doubleArrowTokens !== []) {
            return \true;
        }
        // has comments => dangerous to change: https://github.com/symplify/symplify/issues/973
        return (bool) $tokens->findGivenKind(\T_COMMENT, $blockInfo->getStart(), $blockInfo->getEnd());
    }
}