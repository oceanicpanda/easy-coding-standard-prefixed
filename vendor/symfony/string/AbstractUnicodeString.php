<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb6361033cf41\Symfony\Component\String;

use _PhpScoperb6361033cf41\Symfony\Component\String\Exception\ExceptionInterface;
use _PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException;
use _PhpScoperb6361033cf41\Symfony\Component\String\Exception\RuntimeException;
/**
 * Represents a string of abstract Unicode characters.
 *
 * Unicode defines 3 types of "characters" (bytes, code points and grapheme clusters).
 * This class is the abstract type to use as a type-hint when the logic you want to
 * implement is Unicode-aware but doesn't care about code points vs grapheme clusters.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @throws ExceptionInterface
 */
abstract class AbstractUnicodeString extends \_PhpScoperb6361033cf41\Symfony\Component\String\AbstractString
{
    public const NFC = \Normalizer::NFC;
    public const NFD = \Normalizer::NFD;
    public const NFKC = \Normalizer::NFKC;
    public const NFKD = \Normalizer::NFKD;
    // all ASCII letters sorted by typical frequency of occurrence
    private const ASCII = " eiasntrolud][cmp'\ng|hv.fb,:=-q10C2*yx)(L9AS/P\"EjMIk3>5T<D4}B{8FwR67UGN;JzV#HOW_&!K?XQ%Y\\\tZ+~^\$@`\0\1\2\3\4\5\6\7\10\v\f\r\16\17\20\21\22\23\24\25\26\27\30\31\32\33\34\35\36\37";
    // the subset of folded case mappings that is not in lower case mappings
    private const FOLD_FROM = ['İ', 'µ', 'ſ', "ͅ", 'ς', 'ϐ', 'ϑ', 'ϕ', 'ϖ', 'ϰ', 'ϱ', 'ϵ', 'ẛ', "ι", 'ß', 'İ', 'ŉ', 'ǰ', 'ΐ', 'ΰ', 'և', 'ẖ', 'ẗ', 'ẘ', 'ẙ', 'ẚ', 'ẞ', 'ὐ', 'ὒ', 'ὔ', 'ὖ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'ᾐ', 'ᾑ', 'ᾒ', 'ᾓ', 'ᾔ', 'ᾕ', 'ᾖ', 'ᾗ', 'ᾘ', 'ᾙ', 'ᾚ', 'ᾛ', 'ᾜ', 'ᾝ', 'ᾞ', 'ᾟ', 'ᾠ', 'ᾡ', 'ᾢ', 'ᾣ', 'ᾤ', 'ᾥ', 'ᾦ', 'ᾧ', 'ᾨ', 'ᾩ', 'ᾪ', 'ᾫ', 'ᾬ', 'ᾭ', 'ᾮ', 'ᾯ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'ᾼ', 'ῂ', 'ῃ', 'ῄ', 'ῆ', 'ῇ', 'ῌ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'ῢ', 'ΰ', 'ῤ', 'ῦ', 'ῧ', 'ῲ', 'ῳ', 'ῴ', 'ῶ', 'ῷ', 'ῼ', 'ﬀ', 'ﬁ', 'ﬂ', 'ﬃ', 'ﬄ', 'ﬅ', 'ﬆ', 'ﬓ', 'ﬔ', 'ﬕ', 'ﬖ', 'ﬗ'];
    private const FOLD_TO = ['i̇', 'μ', 's', 'ι', 'σ', 'β', 'θ', 'φ', 'π', 'κ', 'ρ', 'ε', 'ṡ', 'ι', 'ss', 'i̇', 'ʼn', 'ǰ', 'ΐ', 'ΰ', 'եւ', 'ẖ', 'ẗ', 'ẘ', 'ẙ', 'aʾ', 'ss', 'ὐ', 'ὒ', 'ὔ', 'ὖ', 'ἀι', 'ἁι', 'ἂι', 'ἃι', 'ἄι', 'ἅι', 'ἆι', 'ἇι', 'ἀι', 'ἁι', 'ἂι', 'ἃι', 'ἄι', 'ἅι', 'ἆι', 'ἇι', 'ἠι', 'ἡι', 'ἢι', 'ἣι', 'ἤι', 'ἥι', 'ἦι', 'ἧι', 'ἠι', 'ἡι', 'ἢι', 'ἣι', 'ἤι', 'ἥι', 'ἦι', 'ἧι', 'ὠι', 'ὡι', 'ὢι', 'ὣι', 'ὤι', 'ὥι', 'ὦι', 'ὧι', 'ὠι', 'ὡι', 'ὢι', 'ὣι', 'ὤι', 'ὥι', 'ὦι', 'ὧι', 'ὰι', 'αι', 'άι', 'ᾶ', 'ᾶι', 'αι', 'ὴι', 'ηι', 'ήι', 'ῆ', 'ῆι', 'ηι', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'ῢ', 'ΰ', 'ῤ', 'ῦ', 'ῧ', 'ὼι', 'ωι', 'ώι', 'ῶ', 'ῶι', 'ωι', 'ff', 'fi', 'fl', 'ffi', 'ffl', 'st', 'st', 'մն', 'մե', 'մի', 'վն', 'մխ'];
    // the subset of upper case mappings that map one code point to many code points
    private const UPPER_FROM = ['ß', 'ﬀ', 'ﬁ', 'ﬂ', 'ﬃ', 'ﬄ', 'ﬅ', 'ﬆ', 'և', 'ﬓ', 'ﬔ', 'ﬕ', 'ﬖ', 'ﬗ', 'ŉ', 'ΐ', 'ΰ', 'ǰ', 'ẖ', 'ẗ', 'ẘ', 'ẙ', 'ẚ', 'ὐ', 'ὒ', 'ὔ', 'ὖ', 'ᾶ', 'ῆ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'ῢ', 'ΰ', 'ῤ', 'ῦ', 'ῧ', 'ῶ'];
    private const UPPER_TO = ['SS', 'FF', 'FI', 'FL', 'FFI', 'FFL', 'ST', 'ST', 'ԵՒ', 'ՄՆ', 'ՄԵ', 'ՄԻ', 'ՎՆ', 'ՄԽ', 'ʼN', 'Ϊ́', 'Ϋ́', 'J̌', 'H̱', 'T̈', 'W̊', 'Y̊', 'Aʾ', 'Υ̓', 'Υ̓̀', 'Υ̓́', 'Υ̓͂', 'Α͂', 'Η͂', 'Ϊ̀', 'Ϊ́', 'Ι͂', 'Ϊ͂', 'Ϋ̀', 'Ϋ́', 'Ρ̓', 'Υ͂', 'Ϋ͂', 'Ω͂'];
    // the subset of https://github.com/unicode-org/cldr/blob/master/common/transforms/Latin-ASCII.xml that is not in NFKD
    private const TRANSLIT_FROM = ['Æ', 'Ð', 'Ø', 'Þ', 'ß', 'æ', 'ð', 'ø', 'þ', 'Đ', 'đ', 'Ħ', 'ħ', 'ı', 'ĸ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'ŉ', 'Ŋ', 'ŋ', 'Œ', 'œ', 'Ŧ', 'ŧ', 'ƀ', 'Ɓ', 'Ƃ', 'ƃ', 'Ƈ', 'ƈ', 'Ɖ', 'Ɗ', 'Ƌ', 'ƌ', 'Ɛ', 'Ƒ', 'ƒ', 'Ɠ', 'ƕ', 'Ɩ', 'Ɨ', 'Ƙ', 'ƙ', 'ƚ', 'Ɲ', 'ƞ', 'Ƣ', 'ƣ', 'Ƥ', 'ƥ', 'ƫ', 'Ƭ', 'ƭ', 'Ʈ', 'Ʋ', 'Ƴ', 'ƴ', 'Ƶ', 'ƶ', 'Ǆ', 'ǅ', 'ǆ', 'Ǥ', 'ǥ', 'ȡ', 'Ȥ', 'ȥ', 'ȴ', 'ȵ', 'ȶ', 'ȷ', 'ȸ', 'ȹ', 'Ⱥ', 'Ȼ', 'ȼ', 'Ƚ', 'Ⱦ', 'ȿ', 'ɀ', 'Ƀ', 'Ʉ', 'Ɇ', 'ɇ', 'Ɉ', 'ɉ', 'Ɍ', 'ɍ', 'Ɏ', 'ɏ', 'ɓ', 'ɕ', 'ɖ', 'ɗ', 'ɛ', 'ɟ', 'ɠ', 'ɡ', 'ɢ', 'ɦ', 'ɧ', 'ɨ', 'ɪ', 'ɫ', 'ɬ', 'ɭ', 'ɱ', 'ɲ', 'ɳ', 'ɴ', 'ɶ', 'ɼ', 'ɽ', 'ɾ', 'ʀ', 'ʂ', 'ʈ', 'ʉ', 'ʋ', 'ʏ', 'ʐ', 'ʑ', 'ʙ', 'ʛ', 'ʜ', 'ʝ', 'ʟ', 'ʠ', 'ʣ', 'ʥ', 'ʦ', 'ʪ', 'ʫ', 'ᴀ', 'ᴁ', 'ᴃ', 'ᴄ', 'ᴅ', 'ᴆ', 'ᴇ', 'ᴊ', 'ᴋ', 'ᴌ', 'ᴍ', 'ᴏ', 'ᴘ', 'ᴛ', 'ᴜ', 'ᴠ', 'ᴡ', 'ᴢ', 'ᵫ', 'ᵬ', 'ᵭ', 'ᵮ', 'ᵯ', 'ᵰ', 'ᵱ', 'ᵲ', 'ᵳ', 'ᵴ', 'ᵵ', 'ᵶ', 'ᵺ', 'ᵻ', 'ᵽ', 'ᵾ', 'ᶀ', 'ᶁ', 'ᶂ', 'ᶃ', 'ᶄ', 'ᶅ', 'ᶆ', 'ᶇ', 'ᶈ', 'ᶉ', 'ᶊ', 'ᶌ', 'ᶍ', 'ᶎ', 'ᶏ', 'ᶑ', 'ᶒ', 'ᶓ', 'ᶖ', 'ᶙ', 'ẚ', 'ẜ', 'ẝ', 'ẞ', 'Ỻ', 'ỻ', 'Ỽ', 'ỽ', 'Ỿ', 'ỿ', '©', '®', '₠', '₢', '₣', '₤', '₧', '₺', '₹', 'ℌ', '℞', '㎧', '㎮', '㏆', '㏗', '㏞', '㏟', '¼', '½', '¾', '⅓', '⅔', '⅕', '⅖', '⅗', '⅘', '⅙', '⅚', '⅛', '⅜', '⅝', '⅞', '⅟', '〇', '‘', '’', '‚', '‛', '“', '”', '„', '‟', '′', '″', '〝', '〞', '«', '»', '‹', '›', '‐', '‑', '‒', '–', '—', '―', '︱', '︲', '﹘', '‖', '⁄', '⁅', '⁆', '⁎', '、', '。', '〈', '〉', '《', '》', '〔', '〕', '〘', '〙', '〚', '〛', '︑', '︒', '︹', '︺', '︽', '︾', '︿', '﹀', '﹑', '﹝', '﹞', '｟', '｠', '｡', '､', '×', '÷', '−', '∕', '∖', '∣', '∥', '≪', '≫', '⦅', '⦆'];
    private const TRANSLIT_TO = ['AE', 'D', 'O', 'TH', 'ss', 'ae', 'd', 'o', 'th', 'D', 'd', 'H', 'h', 'i', 'q', 'L', 'l', 'L', 'l', '\'n', 'N', 'n', 'OE', 'oe', 'T', 't', 'b', 'B', 'B', 'b', 'C', 'c', 'D', 'D', 'D', 'd', 'E', 'F', 'f', 'G', 'hv', 'I', 'I', 'K', 'k', 'l', 'N', 'n', 'OI', 'oi', 'P', 'p', 't', 'T', 't', 'T', 'V', 'Y', 'y', 'Z', 'z', 'DZ', 'Dz', 'dz', 'G', 'g', 'd', 'Z', 'z', 'l', 'n', 't', 'j', 'db', 'qp', 'A', 'C', 'c', 'L', 'T', 's', 'z', 'B', 'U', 'E', 'e', 'J', 'j', 'R', 'r', 'Y', 'y', 'b', 'c', 'd', 'd', 'e', 'j', 'g', 'g', 'G', 'h', 'h', 'i', 'I', 'l', 'l', 'l', 'm', 'n', 'n', 'N', 'OE', 'r', 'r', 'r', 'R', 's', 't', 'u', 'v', 'Y', 'z', 'z', 'B', 'G', 'H', 'j', 'L', 'q', 'dz', 'dz', 'ts', 'ls', 'lz', 'A', 'AE', 'B', 'C', 'D', 'D', 'E', 'J', 'K', 'L', 'M', 'O', 'P', 'T', 'U', 'V', 'W', 'Z', 'ue', 'b', 'd', 'f', 'm', 'n', 'p', 'r', 'r', 's', 't', 'z', 'th', 'I', 'p', 'U', 'b', 'd', 'f', 'g', 'k', 'l', 'm', 'n', 'p', 'r', 's', 'v', 'x', 'z', 'a', 'd', 'e', 'e', 'i', 'u', 'a', 's', 's', 'SS', 'LL', 'll', 'V', 'v', 'Y', 'y', '(C)', '(R)', 'CE', 'Cr', 'Fr.', 'L.', 'Pts', 'TL', 'Rs', 'x', 'Rx', 'm/s', 'rad/s', 'C/kg', 'pH', 'V/m', 'A/m', ' 1/4', ' 1/2', ' 3/4', ' 1/3', ' 2/3', ' 1/5', ' 2/5', ' 3/5', ' 4/5', ' 1/6', ' 5/6', ' 1/8', ' 3/8', ' 5/8', ' 7/8', ' 1/', '0', '\'', '\'', ',', '\'', '"', '"', ',,', '"', '\'', '"', '"', '"', '<<', '>>', '<', '>', '-', '-', '-', '-', '-', '-', '-', '-', '-', '||', '/', '[', ']', '*', ',', '.', '<', '>', '<<', '>>', '[', ']', '[', ']', '[', ']', ',', '.', '[', ']', '<<', '>>', '<', '>', ',', '[', ']', '((', '))', '.', ',', '*', '/', '-', '/', '\\', '|', '||', '<<', '>>', '((', '))'];
    private static $transliterators = [];
    /**
     * @return static
     */
    public static function fromCodePoints(int ...$codes) : self
    {
        $string = '';
        foreach ($codes as $code) {
            if (0x80 > ($code %= 0x200000)) {
                $string .= \chr($code);
            } elseif (0x800 > $code) {
                $string .= \chr(0xc0 | $code >> 6) . \chr(0x80 | $code & 0x3f);
            } elseif (0x10000 > $code) {
                $string .= \chr(0xe0 | $code >> 12) . \chr(0x80 | $code >> 6 & 0x3f) . \chr(0x80 | $code & 0x3f);
            } else {
                $string .= \chr(0xf0 | $code >> 18) . \chr(0x80 | $code >> 12 & 0x3f) . \chr(0x80 | $code >> 6 & 0x3f) . \chr(0x80 | $code & 0x3f);
            }
        }
        return new static($string);
    }
    /**
     * Generic UTF-8 to ASCII transliteration.
     *
     * Install the intl extension for best results.
     *
     * @param string[]|\Transliterator[]|\Closure[] $rules See "*-Latin" rules from Transliterator::listIDs()
     */
    public function ascii(array $rules = []) : self
    {
        $str = clone $this;
        $s = $str->string;
        $str->string = '';
        \array_unshift($rules, 'nfd');
        $rules[] = 'latin-ascii';
        if (\function_exists('transliterator_transliterate')) {
            $rules[] = 'any-latin/bgn';
        }
        $rules[] = 'nfkd';
        $rules[] = '[:nonspacing mark:] remove';
        while (\strlen($s) - 1 > ($i = \strspn($s, self::ASCII))) {
            if (0 < --$i) {
                $str->string .= \substr($s, 0, $i);
                $s = \substr($s, $i);
            }
            if (!($rule = \array_shift($rules))) {
                $rules = [];
                // An empty rule interrupts the next ones
            }
            if ($rule instanceof \Transliterator) {
                $s = $rule->transliterate($s);
            } elseif ($rule instanceof \Closure) {
                $s = $rule($s);
            } elseif ($rule) {
                if ('nfd' === ($rule = \strtolower($rule))) {
                    \normalizer_is_normalized($s, self::NFD) ?: ($s = \normalizer_normalize($s, self::NFD));
                } elseif ('nfkd' === $rule) {
                    \normalizer_is_normalized($s, self::NFKD) ?: ($s = \normalizer_normalize($s, self::NFKD));
                } elseif ('[:nonspacing mark:] remove' === $rule) {
                    $s = \preg_replace('/\\p{Mn}++/u', '', $s);
                } elseif ('latin-ascii' === $rule) {
                    $s = \str_replace(self::TRANSLIT_FROM, self::TRANSLIT_TO, $s);
                } elseif ('de-ascii' === $rule) {
                    $s = \preg_replace("/([AUO])̈(?=\\p{Ll})/u", '$1e', $s);
                    $s = \str_replace(["ä", "ö", "ü", "Ä", "Ö", "Ü"], ['ae', 'oe', 'ue', 'AE', 'OE', 'UE'], $s);
                } elseif (\function_exists('transliterator_transliterate')) {
                    if (null === ($transliterator = self::$transliterators[$rule] ?? (self::$transliterators[$rule] = \Transliterator::create($rule)))) {
                        if ('any-latin/bgn' === $rule) {
                            $rule = 'any-latin';
                            $transliterator = self::$transliterators[$rule] ?? (self::$transliterators[$rule] = \Transliterator::create($rule));
                        }
                        if (null === $transliterator) {
                            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException(\sprintf('Unknown transliteration rule "%s".', $rule));
                        }
                        self::$transliterators['any-latin/bgn'] = $transliterator;
                    }
                    $s = $transliterator->transliterate($s);
                }
            } elseif (!\function_exists('iconv')) {
                $s = \preg_replace('/[^\\x00-\\x7F]/u', '?', $s);
            } else {
                $s = @\preg_replace_callback('/[^\\x00-\\x7F]/u', static function ($c) {
                    $c = (string) \iconv('UTF-8', 'ASCII//TRANSLIT', $c[0]);
                    if ('' === $c && '' === \iconv('UTF-8', 'ASCII//TRANSLIT', '²')) {
                        throw new \LogicException(\sprintf('"%s" requires a translit-able iconv implementation, try installing "gnu-libiconv" if you\'re using Alpine Linux.', static::class));
                    }
                    return 1 < \strlen($c) ? \ltrim($c, '\'`"^~') : ('' !== $c ? $c : '?');
                }, $s);
            }
        }
        $str->string .= $s;
        return $str;
    }
    public function camel() : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        $str->string = \str_replace(' ', '', \preg_replace_callback('/\\b./u', static function ($m) use(&$i) {
            return 1 === ++$i ? 'İ' === $m[0] ? 'i̇' : \mb_strtolower($m[0], 'UTF-8') : \mb_convert_case($m[0], \MB_CASE_TITLE, 'UTF-8');
        }, \preg_replace('/[^\\pL0-9]++/u', ' ', $this->string)));
        return $str;
    }
    /**
     * @return int[]
     */
    public function codePointsAt(int $offset) : array
    {
        $str = $this->slice($offset, 1);
        if ('' === $str->string) {
            return [];
        }
        $codePoints = [];
        foreach (\preg_split('//u', $str->string, -1, \PREG_SPLIT_NO_EMPTY) as $c) {
            $codePoints[] = \mb_ord($c, 'UTF-8');
        }
        return $codePoints;
    }
    public function folded(bool $compat = \true) : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        if (!$compat || \PHP_VERSION_ID < 70300 || !\defined('Normalizer::NFKC_CF')) {
            $str->string = \normalizer_normalize($str->string, $compat ? \Normalizer::NFKC : \Normalizer::NFC);
            $str->string = \mb_strtolower(\str_replace(self::FOLD_FROM, self::FOLD_TO, $this->string), 'UTF-8');
        } else {
            $str->string = \normalizer_normalize($str->string, \Normalizer::NFKC_CF);
        }
        return $str;
    }
    public function join(array $strings, string $lastGlue = null) : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        $tail = null !== $lastGlue && 1 < \count($strings) ? $lastGlue . \array_pop($strings) : '';
        $str->string = \implode($this->string, $strings) . $tail;
        if (!\preg_match('//u', $str->string)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        return $str;
    }
    public function lower() : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        $str->string = \mb_strtolower(\str_replace('İ', 'i̇', $str->string), 'UTF-8');
        return $str;
    }
    public function match(string $regexp, int $flags = 0, int $offset = 0) : array
    {
        $match = (\PREG_PATTERN_ORDER | \PREG_SET_ORDER) & $flags ? 'preg_match_all' : 'preg_match';
        if ($this->ignoreCase) {
            $regexp .= 'i';
        }
        \set_error_handler(static function ($t, $m) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException($m);
        });
        try {
            if (\false === $match($regexp . 'u', $this->string, $matches, $flags | \PREG_UNMATCHED_AS_NULL, $offset)) {
                $lastError = \preg_last_error();
                foreach (\get_defined_constants(\true)['pcre'] as $k => $v) {
                    if ($lastError === $v && '_ERROR' === \substr($k, -6)) {
                        throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\RuntimeException('Matching failed with ' . $k . '.');
                    }
                }
                throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\RuntimeException('Matching failed with unknown error code.');
            }
        } finally {
            \restore_error_handler();
        }
        return $matches;
    }
    /**
     * @return static
     */
    public function normalize(int $form = self::NFC) : self
    {
        if (!\in_array($form, [self::NFC, self::NFD, self::NFKC, self::NFKD])) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Unsupported normalization form.');
        }
        $str = clone $this;
        \normalizer_is_normalized($str->string, $form) ?: ($str->string = \normalizer_normalize($str->string, $form));
        return $str;
    }
    public function padBoth(int $length, string $padStr = ' ') : \_PhpScoperb6361033cf41\parent
    {
        if ('' === $padStr || !\preg_match('//u', $padStr)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        $pad = clone $this;
        $pad->string = $padStr;
        return $this->pad($length, $pad, \STR_PAD_BOTH);
    }
    public function padEnd(int $length, string $padStr = ' ') : \_PhpScoperb6361033cf41\parent
    {
        if ('' === $padStr || !\preg_match('//u', $padStr)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        $pad = clone $this;
        $pad->string = $padStr;
        return $this->pad($length, $pad, \STR_PAD_RIGHT);
    }
    public function padStart(int $length, string $padStr = ' ') : \_PhpScoperb6361033cf41\parent
    {
        if ('' === $padStr || !\preg_match('//u', $padStr)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        }
        $pad = clone $this;
        $pad->string = $padStr;
        return $this->pad($length, $pad, \STR_PAD_LEFT);
    }
    public function replaceMatches(string $fromRegexp, $to) : \_PhpScoperb6361033cf41\parent
    {
        if ($this->ignoreCase) {
            $fromRegexp .= 'i';
        }
        if (\is_array($to) || $to instanceof \Closure) {
            if (!\is_callable($to)) {
                throw new \TypeError(\sprintf('Argument 2 passed to "%s::replaceMatches()" must be callable, array given.', static::class));
            }
            $replace = 'preg_replace_callback';
            $to = static function (array $m) use($to) : string {
                $to = $to($m);
                if ('' !== $to && (!\is_string($to) || !\preg_match('//u', $to))) {
                    throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Replace callback must return a valid UTF-8 string.');
                }
                return $to;
            };
        } elseif ('' !== $to && !\preg_match('//u', $to)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 string.');
        } else {
            $replace = 'preg_replace';
        }
        \set_error_handler(static function ($t, $m) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException($m);
        });
        try {
            if (null === ($string = $replace($fromRegexp . 'u', $to, $this->string))) {
                $lastError = \preg_last_error();
                foreach (\get_defined_constants(\true)['pcre'] as $k => $v) {
                    if ($lastError === $v && '_ERROR' === \substr($k, -6)) {
                        throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\RuntimeException('Matching failed with ' . $k . '.');
                    }
                }
                throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\RuntimeException('Matching failed with unknown error code.');
            }
        } finally {
            \restore_error_handler();
        }
        $str = clone $this;
        $str->string = $string;
        return $str;
    }
    public function reverse() : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        $str->string = \implode('', \array_reverse(\preg_split('/(\\X)/u', $str->string, -1, \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY)));
        return $str;
    }
    public function snake() : \_PhpScoperb6361033cf41\parent
    {
        $str = $this->camel()->title();
        $str->string = \mb_strtolower(\preg_replace(['/(\\p{Lu}+)(\\p{Lu}\\p{Ll})/u', '/([\\p{Ll}0-9])(\\p{Lu})/u'], '_PhpScoperb6361033cf41\\1_\\2', $str->string), 'UTF-8');
        return $str;
    }
    public function title(bool $allWords = \false) : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        $limit = $allWords ? -1 : 1;
        $str->string = \preg_replace_callback('/\\b./u', static function (array $m) : string {
            return \mb_convert_case($m[0], \MB_CASE_TITLE, 'UTF-8');
        }, $str->string, $limit);
        return $str;
    }
    public function trim(string $chars = " \t\n\r\0\v\f ﻿") : \_PhpScoperb6361033cf41\parent
    {
        if (" \t\n\r\0\v\f ﻿" !== $chars && !\preg_match('//u', $chars)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 chars.');
        }
        $chars = \preg_quote($chars);
        $str = clone $this;
        $str->string = \preg_replace("{^[{$chars}]++|[{$chars}]++\$}uD", '', $str->string);
        return $str;
    }
    public function trimEnd(string $chars = " \t\n\r\0\v\f ﻿") : \_PhpScoperb6361033cf41\parent
    {
        if (" \t\n\r\0\v\f ﻿" !== $chars && !\preg_match('//u', $chars)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 chars.');
        }
        $chars = \preg_quote($chars);
        $str = clone $this;
        $str->string = \preg_replace("{[{$chars}]++\$}uD", '', $str->string);
        return $str;
    }
    public function trimStart(string $chars = " \t\n\r\0\v\f ﻿") : \_PhpScoperb6361033cf41\parent
    {
        if (" \t\n\r\0\v\f ﻿" !== $chars && !\preg_match('//u', $chars)) {
            throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid UTF-8 chars.');
        }
        $chars = \preg_quote($chars);
        $str = clone $this;
        $str->string = \preg_replace("{^[{$chars}]++}uD", '', $str->string);
        return $str;
    }
    public function upper() : \_PhpScoperb6361033cf41\parent
    {
        $str = clone $this;
        $str->string = \mb_strtoupper($str->string, 'UTF-8');
        if (\PHP_VERSION_ID < 70300) {
            $str->string = \str_replace(self::UPPER_FROM, self::UPPER_TO, $str->string);
        }
        return $str;
    }
    public function width(bool $ignoreAnsiDecoration = \true) : int
    {
        $width = 0;
        $s = \str_replace(["\0", "\5", "\7"], '', $this->string);
        if (\false !== \strpos($s, "\r")) {
            $s = \str_replace(["\r\n", "\r"], "\n", $s);
        }
        if (!$ignoreAnsiDecoration) {
            $s = \preg_replace('/[\\p{Cc}\\x7F]++/u', '', $s);
        }
        foreach (\explode("\n", $s) as $s) {
            if ($ignoreAnsiDecoration) {
                $s = \preg_replace('/(?:\\x1B(?:
                    \\[ [\\x30-\\x3F]*+ [\\x20-\\x2F]*+ [0x40-\\x7E]
                    | [P\\]X^_] .*? \\x1B\\\\
                    | [\\x41-\\x7E]
                )|[\\p{Cc}\\x7F]++)/xu', '', $s);
            }
            // Non printable characters have been dropped, so wcswidth cannot logically return -1.
            $width += $this->wcswidth($s);
        }
        return $width;
    }
    /**
     * @return static
     */
    private function pad(int $len, self $pad, int $type) : \_PhpScoperb6361033cf41\parent
    {
        $sLen = $this->length();
        if ($len <= $sLen) {
            return clone $this;
        }
        $padLen = $pad->length();
        $freeLen = $len - $sLen;
        $len = $freeLen % $padLen;
        switch ($type) {
            case \STR_PAD_RIGHT:
                return $this->append(\str_repeat($pad->string, $freeLen / $padLen) . ($len ? $pad->slice(0, $len) : ''));
            case \STR_PAD_LEFT:
                return $this->prepend(\str_repeat($pad->string, $freeLen / $padLen) . ($len ? $pad->slice(0, $len) : ''));
            case \STR_PAD_BOTH:
                $freeLen /= 2;
                $rightLen = \ceil($freeLen);
                $len = $rightLen % $padLen;
                $str = $this->append(\str_repeat($pad->string, $rightLen / $padLen) . ($len ? $pad->slice(0, $len) : ''));
                $leftLen = \floor($freeLen);
                $len = $leftLen % $padLen;
                return $str->prepend(\str_repeat($pad->string, $leftLen / $padLen) . ($len ? $pad->slice(0, $len) : ''));
            default:
                throw new \_PhpScoperb6361033cf41\Symfony\Component\String\Exception\InvalidArgumentException('Invalid padding type.');
        }
    }
    /**
     * Based on https://github.com/jquast/wcwidth, a Python implementation of https://www.cl.cam.ac.uk/~mgk25/ucs/wcwidth.c.
     */
    private function wcswidth(string $string) : int
    {
        $width = 0;
        foreach (\preg_split('//u', $string, -1, \PREG_SPLIT_NO_EMPTY) as $c) {
            $codePoint = \mb_ord($c, 'UTF-8');
            if (0 === $codePoint || 0x34f === $codePoint || 0x200b <= $codePoint && 0x200f >= $codePoint || 0x2028 === $codePoint || 0x2029 === $codePoint || 0x202a <= $codePoint && 0x202e >= $codePoint || 0x2060 <= $codePoint && 0x2063 >= $codePoint) {
                continue;
            }
            // Non printable characters
            if (32 > $codePoint || 0x7f <= $codePoint && 0xa0 > $codePoint) {
                return -1;
            }
            static $tableZero;
            if (null === $tableZero) {
                $tableZero = (require __DIR__ . '/Resources/data/wcswidth_table_zero.php');
            }
            if ($codePoint >= $tableZero[0][0] && $codePoint <= $tableZero[$ubound = \count($tableZero) - 1][1]) {
                $lbound = 0;
                while ($ubound >= $lbound) {
                    $mid = \floor(($lbound + $ubound) / 2);
                    if ($codePoint > $tableZero[$mid][1]) {
                        $lbound = $mid + 1;
                    } elseif ($codePoint < $tableZero[$mid][0]) {
                        $ubound = $mid - 1;
                    } else {
                        continue 2;
                    }
                }
            }
            static $tableWide;
            if (null === $tableWide) {
                $tableWide = (require __DIR__ . '/Resources/data/wcswidth_table_wide.php');
            }
            if ($codePoint >= $tableWide[0][0] && $codePoint <= $tableWide[$ubound = \count($tableWide) - 1][1]) {
                $lbound = 0;
                while ($ubound >= $lbound) {
                    $mid = \floor(($lbound + $ubound) / 2);
                    if ($codePoint > $tableWide[$mid][1]) {
                        $lbound = $mid + 1;
                    } elseif ($codePoint < $tableWide[$mid][0]) {
                        $ubound = $mid - 1;
                    } else {
                        $width += 2;
                        continue 2;
                    }
                }
            }
            ++$width;
        }
        return $width;
    }
}
