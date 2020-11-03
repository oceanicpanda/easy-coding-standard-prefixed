<?php

declare (strict_types=1);
namespace _PhpScoper3d04c8135695;

require_once __DIR__ . '/vendor/autoload.php';
use _PhpScoper3d04c8135695\Nette\Utils\Strings;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
$excludedClasses = [
    // part of public API in config
    \Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class,
];
return ['prefix' => null, 'finders' => [], 'patchers' => [
    // unprefix excluded classes
    // fixes https://github.com/humbug/box/issues/470
    function (string $filePath, string $prefix, string $content) use($excludedClasses) : string {
        foreach ($excludedClasses as $excludedClass) {
            $prefixedClassPattern = '#' . $prefix . '\\\\' . \preg_quote($excludedClass, '#') . '#';
            $content = \_PhpScoper3d04c8135695\Nette\Utils\Strings::replace($content, $prefixedClassPattern, $excludedClass);
        }
        return $content;
    },
], 'whitelist' => [
    // needed for autoload, that is not prefixed, since it's in bin/* file
    'Symplify\\*',
    'PhpCsFixer\\*',
    'PHP_CodeSniffer\\*',
    'SlevomatCodingStandard\\*',
    \Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class,
    'Composer\\*',
]];
