<?php

declare (strict_types=1);
namespace Symplify\MarkdownDiff;

use _PhpScoperd675aaf00c76\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperd675aaf00c76\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension;
final class MarkdownDiffBundle extends \_PhpScoperd675aaf00c76\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperd675aaf00c76\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\MarkdownDiff\DependencyInjection\Extension\MarkdownDiffExtension();
    }
}
