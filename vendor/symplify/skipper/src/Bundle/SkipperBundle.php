<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperf77bffce0320\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoperf77bffce0320\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
