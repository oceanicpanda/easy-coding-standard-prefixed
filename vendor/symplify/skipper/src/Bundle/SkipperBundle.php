<?php

declare (strict_types=1);
namespace Symplify\Skipper\Bundle;

use _PhpScopercda2b863d098\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScopercda2b863d098\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\Skipper\DependencyInjection\Extension\SkipperExtension;
final class SkipperBundle extends \_PhpScopercda2b863d098\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\_PhpScopercda2b863d098\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \Symplify\Skipper\DependencyInjection\Extension\SkipperExtension();
    }
}
