<?php

namespace _PhpScoper3f3a54dd086f;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use _PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme as p;
if (!\defined('GRAPHEME_EXTR_COUNT')) {
    \define('GRAPHEME_EXTR_COUNT', 0);
}
if (!\defined('GRAPHEME_EXTR_MAXBYTES')) {
    \define('GRAPHEME_EXTR_MAXBYTES', 1);
}
if (!\defined('GRAPHEME_EXTR_MAXCHARS')) {
    \define('GRAPHEME_EXTR_MAXCHARS', 2);
}
if (!\function_exists('grapheme_extract')) {
    function grapheme_extract(string $haystack, int $size, int $type = \GRAPHEME_EXTR_COUNT, int $offset = 0, &$next = null) : string|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_extract($haystack, $size, $type, $offset, $next);
    }
}
if (!\function_exists('grapheme_stripos')) {
    function grapheme_stripos(string $haystack, string $needle, int $offset = 0) : int|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_stripos($haystack, $needle, $offset);
    }
}
if (!\function_exists('grapheme_stristr')) {
    function grapheme_stristr(string $haystack, string $needle, bool $beforeNeedle = \false) : string|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_stristr($haystack, $needle, $beforeNeedle);
    }
}
if (!\function_exists('grapheme_strlen')) {
    function grapheme_strlen(string $string) : int|false|null
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_strlen($string);
    }
}
if (!\function_exists('grapheme_strpos')) {
    function grapheme_strpos(string $haystack, string $needle, int $offset = 0) : int|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_strpos($haystack, $needle, $offset);
    }
}
if (!\function_exists('grapheme_strripos')) {
    function grapheme_strripos(string $haystack, string $needle, int $offset = 0) : int|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_strripos($haystack, $needle, $offset);
    }
}
if (!\function_exists('grapheme_strrpos')) {
    function grapheme_strrpos(string $haystack, string $needle, int $offset = 0) : int|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_strrpos($haystack, $needle, $offset);
    }
}
if (!\function_exists('grapheme_strstr')) {
    function grapheme_strstr(string $haystack, string $needle, bool $beforeNeedle = \false) : string|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_strstr($haystack, $needle, $beforeNeedle);
    }
}
if (!\function_exists('grapheme_substr')) {
    function grapheme_substr(string $string, int $offset, int $length = null) : string|false
    {
        return \_PhpScoper3f3a54dd086f\Symfony\Polyfill\Intl\Grapheme\Grapheme::grapheme_substr($string, $offset, $length);
    }
}