<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\Traits;

use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Argument\BoundArgument;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Reference;
trait BindTrait
{
    /**
     * Sets bindings.
     *
     * Bindings map $named or FQCN arguments to values that should be
     * injected in the matching parameters (of the constructor, of methods
     * called and of controller actions).
     *
     * @param string $nameOrFqcn A parameter name with its "$" prefix, or an FQCN
     * @param mixed  $valueOrRef The value or reference to bind
     *
     * @return $this
     */
    public final function bind(string $nameOrFqcn, $valueOrRef) : self
    {
        $valueOrRef = static::processValue($valueOrRef, \true);
        if (!\preg_match('/^(?:(?:array|bool|float|int|string)[ \\t]*+)?\\$/', $nameOrFqcn) && !$valueOrRef instanceof Reference) {
            throw new InvalidArgumentException(\sprintf('Invalid binding for service "%s": named arguments must start with a "$", and FQCN must map to references. Neither applies to binding "%s".', $this->id, $nameOrFqcn));
        }
        $bindings = $this->definition->getBindings();
        $type = $this instanceof DefaultsConfigurator ? BoundArgument::DEFAULTS_BINDING : ($this instanceof InstanceofConfigurator ? BoundArgument::INSTANCEOF_BINDING : BoundArgument::SERVICE_BINDING);
        $bindings[$nameOrFqcn] = new BoundArgument($valueOrRef, \true, $type, $this->path ?? null);
        $this->definition->setBindings($bindings);
        return $this;
    }
}
