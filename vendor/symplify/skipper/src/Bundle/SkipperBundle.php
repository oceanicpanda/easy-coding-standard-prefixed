<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScoper0ba97041430d\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScoper0ba97041430d\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
