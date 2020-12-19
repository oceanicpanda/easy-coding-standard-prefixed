<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper269dc521b0fa\Symfony\Component\Cache\Adapter;

use _PhpScoper269dc521b0fa\Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use _PhpScoper269dc521b0fa\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use _PhpScoper269dc521b0fa\Symfony\Component\Cache\PruneableInterface;
use _PhpScoper269dc521b0fa\Symfony\Component\Cache\Traits\FilesystemTrait;
class FilesystemAdapter extends \_PhpScoper269dc521b0fa\Symfony\Component\Cache\Adapter\AbstractAdapter implements \_PhpScoper269dc521b0fa\Symfony\Component\Cache\PruneableInterface
{
    use FilesystemTrait;
    public function __construct(string $namespace = '', int $defaultLifetime = 0, string $directory = null, \_PhpScoper269dc521b0fa\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        $this->marshaller = $marshaller ?? new \_PhpScoper269dc521b0fa\Symfony\Component\Cache\Marshaller\DefaultMarshaller();
        parent::__construct('', $defaultLifetime);
        $this->init($namespace, $directory);
    }
}
