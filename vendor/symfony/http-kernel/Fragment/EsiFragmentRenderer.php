<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Fragment;

/**
 * Implements the ESI rendering strategy.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class EsiFragmentRenderer extends \_PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Fragment\AbstractSurrogateFragmentRenderer
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'esi';
    }
}
