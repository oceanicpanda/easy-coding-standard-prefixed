<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper6207116d4311\Symfony\Component\DependencyInjection\Loader\Configurator\Traits;

use _PhpScoper6207116d4311\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
trait DeprecateTrait
{
    /**
     * Whether this definition is deprecated, that means it should not be called anymore.
     *
     * @param string $template Template message to use if the definition is deprecated
     *
     * @return $this
     *
     * @throws InvalidArgumentException when the message template is invalid
     */
    public final function deprecate(string $template = null) : self
    {
        $this->definition->setDeprecated(\true, $template);
        return $this;
    }
}
